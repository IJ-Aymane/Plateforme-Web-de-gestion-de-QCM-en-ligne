@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $qcm->titre }}</h4>
                            <small>{{ $qcm->description }}</small>
                        </div>
                        <div class="text-end">
                            <div id="timer" class="h5 mb-0">
                                <i class="fas fa-clock"></i> <span id="time-display">--:--</span>
                            </div>
                            <small>Temps restant</small>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(isset($qcm->questions) && $qcm->questions->count() > 0)
                        <form id="qcm-form" method="POST" action="{{ route('qcm.submit', $qcm->id) }}">
                            @csrf
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Progression</span>
                                    <span class="text-muted">
                                        <span id="current-question">1</span> / {{ $qcm->questions->count() }}
                                    </span>
                                </div>
                                <div class="progress">
                                    <div id="progress-bar" class="progress-bar bg-primary" role="progressbar" 
                                        style="width: 0%" 
                                        aria-valuenow="0" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            @foreach($qcm->questions as $index => $question)
                                <div class="question-container mb-5 {{ $index === 0 ? 'active' : '' }}" 
                                    data-question="{{ $index + 1 }}">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">
                                                <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                                {{ $question->question }}
                                            </h5>
                                            
                                            @if(isset($question->options) && $question->options->count() > 0)
                                                <div class="options-container">
                                                    @foreach($question->options as $optionIndex => $option)
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" 
                                                                    type="radio" 
                                                                    name="answers[{{ $question->id }}]" 
                                                                    value="{{ $option->id }}" 
                                                                    id="option_{{ $question->id }}_{{ $optionIndex }}">
                                                            <label class="form-check-label" 
                                                                    for="option_{{ $question->id }}_{{ $optionIndex }}">
                                                                {{ $option->reponse }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted">Aucune option disponible pour cette question.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="button" id="prev-btn" class="btn btn-outline-secondary" disabled>
                                    <i class="fas fa-chevron-left"></i> Précédent
                                </button>
                                
                                <div class="text-center">
                                    <span class="text-muted">Question <span id="nav-current">1</span> sur {{ $qcm->questions->count() }}</span>
                                </div>
                                
                                <button type="button" id="next-btn" class="btn btn-primary">
                                    Suivant <i class="fas fa-chevron-right"></i>
                                </button>
                                
                                <button type="submit" id="submit-btn" class="btn btn-success d-none">
                                    <i class="fas fa-check"></i> Terminer le QCM
                                </button>
                            </div>

                            <div id="summary-section" class="mt-5 d-none">
                                <div class="card border-warning">
                                    <div class="card-header bg-warning text-dark">
                                        <h5 class="mb-0"><i class="fas fa-clipboard-check"></i> Résumé de vos réponses</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted mb-3">Vérifiez vos réponses avant de soumettre le QCM :</p>
                                        <div id="answers-summary"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <h5>Aucune question disponible</h5>
                            <p class="text-muted">Ce QCM ne contient aucune question pour le moment.</p>
                            <a href="{{ route('qcm.available') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Retour aux QCM disponibles
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.question-container');
    const totalQuestions = questions.length;
    let currentQuestionIndex = 0;
    
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-btn');
    const progressBar = document.getElementById('progress-bar');
    const currentQuestionSpan = document.getElementById('current-question');
    const navCurrentSpan = document.getElementById('nav-current');
    const summarySection = document.getElementById('summary-section');
    
    let timeLimit = 30 * 60; // 30 minutes in seconds
    let timeRemaining = timeLimit;
    const timerDisplay = document.getElementById('time-display');
    
    const timer = setInterval(function() {
        if (timeRemaining <= 0) {
            clearInterval(timer);
            alert('Temps écoulé ! Le QCM va être soumis automatiquement.');
            document.getElementById('qcm-form').submit();
            return;
        }

        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        if (timeRemaining <= 300) {
            timerDisplay.parentElement.classList.add('text-warning');
        }
        
        if (timeRemaining <= 60) {
            timerDisplay.parentElement.classList.remove('text-warning');
            timerDisplay.parentElement.classList.add('text-danger');
        }
        
        timeRemaining--;
    }, 1000);
    
    function showQuestion(index) {
        questions.forEach((q, i) => {
            q.classList.toggle('active', i === index);
        });
        
        currentQuestionSpan.textContent = index + 1;
        navCurrentSpan.textContent = index + 1;
        
        prevBtn.disabled = index === 0;
        
        if (index === totalQuestions - 1) {
            nextBtn.classList.add('d-none');
            submitBtn.classList.remove('d-none');
            // The summary is now only shown on button click.
            // summarySection.classList.add('d-none'); // Ensure it's hidden when navigating to the last question
        } else {
            nextBtn.classList.remove('d-none');
            submitBtn.classList.add('d-none');
            summarySection.classList.add('d-none'); // Hide summary when navigating back
        }
        
        updateProgressBar();
    }
    
    function updateProgressBar() {
        const progress = ((currentQuestionIndex + 1) / totalQuestions) * 100;
        progressBar.style.width = progress + '%';
        progressBar.setAttribute('aria-valuenow', progress);
    }
    
    function showSummary() {
        summarySection.classList.remove('d-none');
        const summaryDiv = document.getElementById('answers-summary');
        let summaryHTML = '';
        
        questions.forEach((q, index) => {
            const questionText = q.querySelector('.card-title').textContent.trim().replace(/^\d+\s+/, '');
            const radios = q.querySelectorAll('input[type="radio"]');
            const checkedRadio = Array.from(radios).find(radio => radio.checked);
            
            summaryHTML += `
                <div class="mb-2">
                    <strong>Question ${index + 1}:</strong> ${questionText}
                    <br>
                    <span class="text-muted">Réponse: </span>
                    ${checkedRadio ? 
                        `<span class="text-success">${checkedRadio.nextElementSibling.textContent.trim()}</span>` : 
                        `<span class="text-danger">Non répondue</span>`}
                </div>
                <hr>
            `;
        });
        
        summaryDiv.innerHTML = summaryHTML;
    }
    
    nextBtn.addEventListener('click', function() {
        if (currentQuestionIndex < totalQuestions - 1) {
            currentQuestionIndex++;
            showQuestion(currentQuestionIndex);
        }
    });
    
    prevBtn.addEventListener('click', function() {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            showQuestion(currentQuestionIndex);
        }
    });

    submitBtn.addEventListener('click', function(event) {
        // Prevent default submission to show summary first
        event.preventDefault(); 
        
        showSummary();

        const confirmSubmission = confirm('Êtes-vous sûr de vouloir soumettre vos réponses ? Cette action est irréversible.');
        
        if (confirmSubmission) {
            document.getElementById('qcm-form').submit();
        }
    });

    // Initialize the quiz
    showQuestion(currentQuestionIndex);
});
</script>

<style>
.question-container {
    display: none;
}

.question-container.active {
    display: block;
}

.form-check-input:checked + .form-check-label {
    font-weight: bold;
    color: #0d6efd;
}

.progress {
    height: 8px;
}

#timer {
    font-family: 'Courier New', monospace;
    font-weight: bold;
}
</style>
@endsection
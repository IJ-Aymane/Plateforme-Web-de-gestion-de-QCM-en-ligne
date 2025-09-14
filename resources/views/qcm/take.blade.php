@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-semibold">{{ $qcm->titre }}</h1>
                    <p class="text-blue-100 text-sm mt-1">{{ $qcm->description }}</p>
                </div>
                <div class="text-right">
                    <div class="text-lg font-mono font-bold" id="timer">
                        <i class="fas fa-clock mr-2"></i>
                        <span id="time-display">30:00</span>
                    </div>
                    <p class="text-blue-100 text-xs">Temps restant</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-400 text-red-700 text-sm">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(isset($qcm->questions) && $qcm->questions->count() > 0)
                <form id="qcm-form" method="POST" action="{{ route('qcm.submit', $qcm->id) }}">
                    @csrf

                    <!-- Progress bar -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Question <span id="current-question">1</span> sur {{ $qcm->questions->count() }}</span>
                            <span><span id="progress-percent">{{ round((1 / $qcm->questions->count()) * 100) }}</span>% terminé</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="progress-bar" 
                                 class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ (1 / $qcm->questions->count()) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Questions -->
                    @foreach($qcm->questions as $index => $question)
                        <div class="question-container {{ $index === 0 ? 'block' : 'hidden' }}" 
                             data-question="{{ $index + 1 }}">
                            
                            <div class="mb-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-start">
                                    <span class="bg-blue-600 text-white text-sm font-bold px-3 py-1 rounded mr-3 mt-1 flex-shrink-0">
                                        {{ $index + 1 }}
                                    </span>
                                    {{ $question->question }}
                                </h2>
                                
                                @if(isset($question->options) && $question->options->count() > 0)
                                    <div class="ml-12 space-y-3">
                                        @foreach($question->options as $optionIndex => $option)
                                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                                <input type="radio" 
                                                       name="answers[{{ $question->id }}]" 
                                                       value="{{ $option->id }}" 
                                                       class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                                       id="option_{{ $question->id }}_{{ $optionIndex }}">
                                                <span class="ml-3 text-gray-700">
                                                    <span class="font-medium text-gray-500 mr-2">{{ chr(65 + $optionIndex) }}.</span>
                                                    {{ $option->reponse }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="ml-12 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                        <p class="text-yellow-700 text-sm">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            Aucune option disponible pour cette question.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Navigation -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                        <button type="button" id="prev-btn" 
                                class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" 
                                disabled>
                            <i class="fas fa-chevron-left mr-2"></i>Précédent
                        </button>
                        
                        <span class="text-sm text-gray-500">
                            <span id="nav-current">1</span> / {{ $qcm->questions->count() }}
                        </span>
                        
                        <button type="button" id="next-btn" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Suivant<i class="fas fa-chevron-right ml-2"></i>
                        </button>
                        
                        <button type="submit" id="submit-btn" 
                                class="hidden px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-check mr-2"></i>Terminer
                        </button>
                    </div>

                    <!-- Résumé -->
                    <div id="summary-section" class="hidden mt-6 p-4 bg-gray-50 rounded-lg border">
                        <h3 class="font-medium text-gray-900 mb-3">
                            <i class="fas fa-list-check mr-2"></i>Vérification des réponses
                        </h3>
                        <div id="answers-summary" class="space-y-2 mb-4"></div>
                        <div class="text-center">
                            <button type="button" id="confirm-submit" 
                                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Confirmer et envoyer
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-question-circle text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune question disponible</h3>
                    <p class="text-gray-600 mb-4">Ce QCM ne contient pas encore de questions.</p>
                    <a href="{{ route('qcm.available') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i>Retour aux QCM
                    </a>
                </div>
            @endif
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
    
    // Éléments
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-btn');
    const confirmBtn = document.getElementById('confirm-submit');
    const progressBar = document.getElementById('progress-bar');
    const currentQuestionSpan = document.getElementById('current-question');
    const navCurrentSpan = document.getElementById('nav-current');
    const progressPercent = document.getElementById('progress-percent');
    const summarySection = document.getElementById('summary-section');
    
    // Timer
    let timeLimit = 30 * 60; // 30 minutes
    let timeRemaining = timeLimit;
    const timerDisplay = document.getElementById('time-display');
    const timerElement = document.getElementById('timer');
    
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
        
        // Changement de couleur
        if (timeRemaining <= 300) { // 5 minutes
            timerElement.className = 'text-lg font-mono font-bold text-yellow-300';
        }
        
        if (timeRemaining <= 60) { // 1 minute
            timerElement.className = 'text-lg font-mono font-bold text-red-300';
        }
        
        timeRemaining--;
    }, 1000);
    
    // Afficher une question
    function showQuestion(index) {
        questions.forEach((q, i) => {
            q.classList.toggle('hidden', i !== index);
            q.classList.toggle('block', i === index);
        });
        
        currentQuestionSpan.textContent = index + 1;
        navCurrentSpan.textContent = index + 1;
        
        const progress = ((index + 1) / totalQuestions) * 100;
        progressBar.style.width = progress + '%';
        progressPercent.textContent = Math.round(progress);
        
        prevBtn.disabled = index === 0;
        
        if (index === totalQuestions - 1) {
            nextBtn.classList.add('hidden');
            submitBtn.classList.remove('hidden');
        } else {
            nextBtn.classList.remove('hidden');
            submitBtn.classList.add('hidden');
            summarySection.classList.add('hidden');
        }
    }
    
    // Afficher le résumé
    function showSummary() {
        summarySection.classList.remove('hidden');
        const summaryDiv = document.getElementById('answers-summary');
        let summaryHTML = '';
        let answeredCount = 0;
        
        questions.forEach((q, index) => {
            const questionText = q.querySelector('h2').textContent.trim().replace(/^\d+\s*/, '');
            const radios = q.querySelectorAll('input[type="radio"]');
            const checkedRadio = Array.from(radios).find(radio => radio.checked);
            
            if (checkedRadio) answeredCount++;
            
            const answerText = checkedRadio ? 
                checkedRadio.nextElementSibling.textContent.trim().replace(/^[A-D]\.\s*/, '') : 
                'Non répondue';
                
            const statusClass = checkedRadio ? 'text-green-600' : 'text-red-600';
            const statusIcon = checkedRadio ? 'fas fa-check' : 'fas fa-times';
            
            summaryHTML += `
                <div class="flex items-start space-x-3 p-2 text-sm">
                    <i class="${statusIcon} ${statusClass} mt-1 flex-shrink-0"></i>
                    <div class="flex-1">
                        <span class="font-medium">Q${index + 1}:</span>
                        <span class="${statusClass}">${answerText}</span>
                    </div>
                </div>
            `;
        });
        
        // Ajouter le compteur
        const completionRate = Math.round((answeredCount / totalQuestions) * 100);
        summaryHTML = `
            <div class="mb-3 p-2 bg-blue-50 rounded text-sm">
                <strong>${answeredCount}/${totalQuestions}</strong> questions répondues (${completionRate}%)
            </div>
        ` + summaryHTML;
        
        summaryDiv.innerHTML = summaryHTML;
    }
    
    // Navigation
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
        event.preventDefault();
        showSummary();
    });
    
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            const answeredCount = document.querySelectorAll('input[type="radio"]:checked').length;
            const unanswered = totalQuestions - answeredCount;
            
            let message = `Vous allez soumettre ${answeredCount} réponse(s).`;
            if (unanswered > 0) {
                message += `\n${unanswered} question(s) resteront sans réponse.`;
            }
            message += '\n\nÊtes-vous sûr de vouloir continuer ?';
            
            if (confirm(message)) {
                document.getElementById('qcm-form').submit();
            }
        });
    }
    
    // Navigation clavier simple
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft' && !prevBtn.disabled) {
            prevBtn.click();
        } else if (e.key === 'ArrowRight' && !nextBtn.classList.contains('hidden')) {
            nextBtn.click();
        }
    });
    
    // Marquer les réponses sélectionnées
    document.addEventListener('change', function(e) {
        if (e.target.type === 'radio') {
            // Réinitialiser tous les labels de cette question
            const questionContainer = e.target.closest('.question-container');
            const labels = questionContainer.querySelectorAll('label');
            labels.forEach(label => {
                label.classList.remove('bg-blue-50', 'border-blue-300');
                label.classList.add('border-gray-200');
            });
            
            // Marquer le label sélectionné
            const selectedLabel = e.target.closest('label');
            selectedLabel.classList.remove('border-gray-200');
            selectedLabel.classList.add('bg-blue-50', 'border-blue-300');
        }
    });
    
    // Initialisation
    showQuestion(currentQuestionIndex);
    
    // Avertissement avant de quitter
    window.addEventListener('beforeunload', function(e) {
        e.preventDefault();
        e.returnValue = '';
    });
});
</script>

<style>
/* Styles personnalisés en CSS pur (compatible Tailwind) */
.question-container {
    min-height: 200px;
}

.question-container label:hover {
    background-color: #f9fafb;
}

.question-container input[type="radio"]:checked + span {
    color: #1f2937;
    font-weight: 500;
}

/* Animation douce pour la progression */
#progress-bar {
    transition: width 0.3s ease;
}

/* Responsive mobile */
@media (max-width: 768px) {
    .question-container h2 {
        font-size: 1rem;
        line-height: 1.4;
    }
    
    .ml-12 {
        margin-left: 1rem;
    }
    
    .question-container label {
        padding: 0.75rem;
    }
    
    .flex.justify-between {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .flex.justify-between button {
        width: 100%;
        justify-content: center;
    }
    
    .flex.justify-between span {
        text-align: center;
        order: -1;
    }
}

/* Focus states */
button:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

input[type="radio"]:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}
</style>
@endsection
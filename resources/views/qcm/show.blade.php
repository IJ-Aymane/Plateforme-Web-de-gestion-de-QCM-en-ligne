@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ $qcm->titre }}</h4>
                    <div>
                        <a href="{{ route('qcm.edit', $qcm->id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('qcm.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h5>Description</h5>
                            <p class="text-muted">
                                {{ $qcm->description ?: 'Aucune description fournie.' }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Informations</h6>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i> Créé le : {{ $qcm->created_at->format('d/m/Y') }}<br>
                                            <i class="fas fa-edit"></i> Modifié le : {{ $qcm->updated_at->format('d/m/Y') }}<br>
                                            <i class="fas fa-question-circle"></i> 
                                            Questions : 
                                            <span class="badge bg-info">{{ $qcm->questions->count() ?? 0 }}</span>
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Questions</h5>
                        <a href="#" class="btn btn-success">
                            <i class="fas fa-plus"></i> Ajouter une question
                        </a>
                    </div>

                    @if(isset($qcm->questions) && $qcm->questions->count() > 0)
                        <div class="accordion" id="questionsAccordion">
                            @foreach($qcm->questions as $index => $question)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $index }}">
                                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#collapse{{ $index }}" 
                                                aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" 
                                                aria-controls="collapse{{ $index }}">
                                            Question {{ $index + 1 }} : {{ Str::limit($question->question_text, 60) }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $index }}" 
                                         class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" 
                                         aria-labelledby="heading{{ $index }}" 
                                         data-bs-parent="#questionsAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Question :</strong> {{ $question->question_text }}</p>
                                            
                                            @if(isset($question->options) && $question->options->count() > 0)
                                                <h6>Options de réponse :</h6>
                                                <ul class="list-group">
                                                    @foreach($question->options as $option)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            {{ $option->option_text }}
                                                            @if($option->is_correct)
                                                                <span class="badge bg-success">Correcte</span>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted">Aucune option de réponse définie.</p>
                                            @endif
                                            
                                            <div class="mt-3">
                                                <a href="#" class="btn btn-sm btn-warning me-2">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </a>
                                                <form method="POST" action="#" style="display: inline-block;" 
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                            <h5>Aucune question trouvée</h5>
                            <p class="text-muted">Commencez par ajouter des questions à ce QCM.</p>
                            <a href="#" class="btn btn-success">
                                <i class="fas fa-plus"></i> Ajouter la première question
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
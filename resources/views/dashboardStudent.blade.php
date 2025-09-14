@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Header Section -->
        <div class="col-12 mb-4">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2">Bonjour, {{ Auth::user()->name }} ! 👋</h2>
                            <p class="mb-0 opacity-75">Bienvenue dans votre espace étudiant. Gérez vos QCM et suivez vos progrès.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="text-white opacity-75">
                                <i class="fas fa-calendar-alt"></i>
                                {{ now()->isoFormat('dddd D MMMM Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-list-alt fa-2x text-primary"></i>
                        </div>
                    </div>
                    <h3 class="h4 mb-1">{{ $stats['available_qcms'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">QCM Disponibles</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                    <h3 class="h4 mb-1">{{ $stats['completed_qcms'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">QCM Terminés</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-trophy fa-2x text-warning"></i>
                        </div>
                    </div>
                    <h3 class="h4 mb-1">{{ $stats['average_score'] ?? 0 }}%</h3>
                    <p class="text-muted mb-0">Score Moyen</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Actions Rapides -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt text-primary me-2"></i>Actions Rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('qcm.available') }}" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-play-circle me-2"></i>
                                <div class="text-start">
                                    <div class="fw-bold">Passer un QCM</div>
                                    <small class="opacity-75">Commencer un nouveau test</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('student.results') }}" class="btn btn-outline-success btn-lg w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-chart-line me-2"></i>
                                <div class="text-start">
                                    <div class="fw-bold">Mes Résultats</div>
                                    <small class="text-muted">Voir mes performances</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('qcm.available') }}" class="btn btn-outline-info btn-lg w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-list me-2"></i>
                                <div class="text-start">
                                    <div class="fw-bold">Tous les QCM</div>
                                    <small class="text-muted">Parcourir tous les QCM</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('student.history') }}" class="btn btn-outline-secondary btn-lg w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-history me-2"></i>
                                <div class="text-start">
                                    <div class="fw-bold">Historique</div>
                                    <small class="text-muted">QCM précédents</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activité Récente -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock text-info me-2"></i>Activité Récente
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($recent_activities) && $recent_activities->count() > 0)
                        <div class="timeline">
                            @foreach($recent_activities as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $activity->status === 'completed' ? 'success' : 'primary' }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">{{ $activity->qcm->titre }}</h6>
                                        <p class="timeline-text text-muted small mb-1">
                                            {{ $activity->status === 'completed' ? 'QCM terminé' : 'QCM en cours' }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $activity->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-inbox text-muted fa-2x mb-2"></i>
                            <p class="text-muted mb-0">Aucune activité récente</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Section Questions disponibles -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-question-circle text-warning me-2"></i>Questions Disponibles
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($questions) && $questions->count() > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Intitulé</th>
                                    <th>QCM</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <td>{{ Str::limit($question->intitule, 60) }}</td>
                                        <td>{{ $question->qcm->titre ?? 'Sans QCM' }}</td>
                                        <td>
                                            <a href="{{ route('questions.show', $question->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $questions->links() }}
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-question text-muted fa-2x mb-2"></i>
                            <p class="text-muted mb-0">Aucune question disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Section QCM Populaires (inchangée) -->
    {{-- ... ton code actuel des QCM populaires et performance chart ... --}}
</div>
@endsection

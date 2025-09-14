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

        <!-- Statistics Cards -->
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
        <!-- Quick Actions -->
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

        <!-- Recent Activity -->
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

    <!-- Available QCMs Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-fire text-danger me-2"></i>QCM Populaires
                        </h5>
                        <a href="{{ route('qcm.available') }}" class="btn btn-sm btn-outline-primary">
                            Voir tout <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($featured_qcms) && $featured_qcms->count() > 0)
                        <div class="row">
                            @foreach($featured_qcms as $qcm)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card border-0 bg-light h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title mb-0">{{ Str::limit($qcm->titre, 40) }}</h6>
                                                <span class="badge bg-info">{{ $qcm->questions->count() ?? 0 }} Q</span>
                                            </div>
                                            <p class="card-text small text-muted mb-2">
                                                {{ Str::limit($qcm->description, 80) ?: 'Aucune description disponible.' }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i>{{ $qcm->enseignant->name ?? 'Enseignant' }}
                                                </small>
                                                <a href="{{ route('qcm.take', $qcm->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-play"></i> Passer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-graduation-cap text-muted fa-3x mb-3"></i>
                            <h6>Aucun QCM disponible</h6>
                            <p class="text-muted">Il n'y a actuellement aucun QCM disponible.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Chart Section -->
    @if(isset($performance_data) && count($performance_data) > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-area text-success me-2"></i>Évolution de vos Performances
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="performanceChart" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.btn {
    transition: all 0.3s ease;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -31px;
    top: 15px;
    width: 2px;
    height: calc(100% + 10px);
    background-color: #e9ecef;
}

.timeline-content {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.timeline-title {
    font-size: 0.9rem;
    margin-bottom: 4px;
}

.timeline-text {
    font-size: 0.8rem;
}

@media (max-width: 768px) {
    .timeline {
        padding-left: 20px;
    }
    
    .timeline-marker {
        left: -25px;
    }
    
    .timeline-item:not(:last-child)::before {
        left: -21px;
    }
}

.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}
</style>

@if(isset($performance_data) && count($performance_data) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Hidden div to pass data to JavaScript -->
<div id="chart-data" 
     data-labels='@json($performance_data["labels"] ?? [])' 
     data-scores='@json($performance_data["scores"] ?? [])' 
     style="display: none;">
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const chartDataElement = document.getElementById('chart-data');
    
    // Get data from HTML data attributes
    const chartLabels = JSON.parse(chartDataElement.getAttribute('data-labels'));
    const chartScores = JSON.parse(chartDataElement.getAttribute('data-scores'));
    
    const performanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Score (%)',
                data: chartScores,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endif
@endsection
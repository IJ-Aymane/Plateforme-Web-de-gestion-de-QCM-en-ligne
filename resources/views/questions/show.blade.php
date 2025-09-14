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

                                        <!-- Liste rapide des questions -->
                                        @if($qcm->questions->count() > 0)
                                            <ul class="list-unstyled small mb-2">
                                                @foreach($qcm->questions->take(3) as $q)
                                                    <li>
                                                        <a href="{{ route('questions.show', $q->id) }}" class="text-decoration-none">
                                                            <i class="fas fa-question-circle me-1"></i>
                                                            {{ Str::limit($q->question, 30) }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted small">Aucune question encore.</p>
                                        @endif

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

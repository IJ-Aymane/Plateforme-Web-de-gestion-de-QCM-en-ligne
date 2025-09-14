@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-list-alt"></i> QCM Disponibles</h4>
                    <p class="mb-0 text-muted">Choisissez un QCM pour commencer le test</p>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($qcms->count() > 0)
                        <div class="row">
                            @foreach($qcms as $qcm)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $qcm->titre }}</h5>
                                            <p class="card-text flex-grow-1">
                                                {{ Str::limit($qcm->description, 100) ?: 'Aucune description disponible.' }}
                                            </p>
                                            
                                            <div class="mb-3">
                                                <small class="text-muted">
                                                    <i class="fas fa-user"></i> 
                                                    Par : {{ $qcm->enseignant->name ?? 'Enseignant' }}<br>
                                                    <i class="fas fa-calendar"></i> 
                                                    Créé le : {{ $qcm->created_at->format('d/m/Y') }}<br>
                                                    <i class="fas fa-question-circle"></i> 
                                                    Questions : 
                                                    <span class="badge bg-info">{{ $qcm->questions->count() ?? 0 }}</span>
                                                </small>
                                            </div>
                                            
                                            <div class="mt-auto">
                                                @if(isset($qcm->questions) && $qcm->questions->count() > 0)
                                                    <a href="{{ route('qcm.take', $qcm->id) }}" class="btn btn-primary w-100">
                                                        <i class="fas fa-play"></i> Commencer le QCM
                                                    </a>
                                                @else
                                                    <button class="btn btn-secondary w-100" disabled>
                                                        <i class="fas fa-exclamation-triangle"></i> Pas de questions disponibles
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $qcms->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5>Aucun QCM disponible</h5>
                            <p class="text-muted">Il n'y a actuellement aucun QCM disponible pour passer le test.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}

.badge {
    font-size: 0.75em;
}
</style>
@endsection
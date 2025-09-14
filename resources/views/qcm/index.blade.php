@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Mes QCM</h4>
                    <a href="{{ route('qcm.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nouveau QCM
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($qcm->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Description</th>
                                        <th>Questions</th>
                                        <th>Créé le</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($qcm as $quiz)
                                        <tr>
                                            <td>{{ $quiz->titre }}</td>
                                            <td>{{ Str::limit($quiz->description, 50) }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $quiz->questions->count() }} questions
                                                </span>
                                            </td>
                                            <td>{{ $quiz->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('qcm.show', $quiz->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> Voir
                                                    </a>
                                                    <a href="{{ route('qcm.edit', $quiz->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i> Modifier
                                                    </a>
                                                    <form method="POST" action="{{ route('qcm.destroy', $quiz->id) }}" 
                                                          style="display: inline-block;" 
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce QCM ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i> Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $qcm->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                            <h5>Aucun QCM trouvé</h5>
                            <p class="text-muted">Commencez par créer votre premier QCM.</p>
                            <a href="{{ route('qcm.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Créer un QCM
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
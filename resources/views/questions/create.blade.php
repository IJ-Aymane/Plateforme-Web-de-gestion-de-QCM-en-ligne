@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Créer une nouvelle question</h2>

    <!-- Affichage des erreurs de validation -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('questions.store') }}" method="POST">
        @csrf

        <!-- QCM associé -->
        <div class="mb-3">
            <label for="qcm_id" class="form-label">QCM associé</label>
            <select name="qcm_id" id="qcm_id" class="form-select" required>
                <option value="">-- Choisir un QCM --</option>
                @foreach($qcm as $qc)
                    <option value="{{ $qc->id }}" {{ (old('qc_id') == $qc->id) ? 'selected' : '' }}>
                        {{ $qc->titre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Texte de la question -->
        <div class="mb-3">
            <label for="question" class="form-label">Intitulé de la question</label>
            <input type="text" name="question" id="question" class="form-control" value="{{ old('question') }}" required>
        </div>

        <!-- Bouton d'enregistrement -->
        <button type="submit" class="btn btn-primary">Enregistrer la question</button>
        <a href="{{ route('qcm.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection

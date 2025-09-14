@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">Créer une nouvelle question</div>

                <div class="card-body">
                    <form action="{{ route('questions.store') }}" method="POST">
                        @csrf

                        <!-- QCM Selection -->
                        <div class="mb-3">
                            <label for="qcm_id" class="form-label">Sélectionner un QCM</label>
                            <select name="qcm_id" id="qcm_id" class="form-select" required>
                                <option value="">-- Choisir --</option>
                                @foreach($qcms as $qcm)
                                    <option value="{{ $qcm->id }}">{{ $qcm->titre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Question Text -->
                        <div class="mb-3">
                            <label for="question" class="form-label">Question</label>
                            <input type="text" name="question" id="question" class="form-control" required>
                        </div>

                        <!-- Optional: Add choices here -->

                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <a href="{{ route('questions.index') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

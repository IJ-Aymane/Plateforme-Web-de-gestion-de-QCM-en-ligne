<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-edit me-2"></i>Modifier la question
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i>Veuillez corriger les erreurs suivantes :
                            </h6>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('questions.update', $question->id) }}" method="POST" id="question-form">
                            @csrf
                            @method('PUT')

                            <!-- QCM associé -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">QCM associé</label>
                                <select name="qcm_id" id="qcm_id" class="form-select" required>
                                    <option value="">-- Choisir un QCM --</option>
                                    @foreach($qcm as $qc)
                                        <option value="{{ $qc->id }}" 
                                            {{ (old('qcm_id', $question->qcm_id) == $qc->id) ? 'selected' : '' }}>
                                            {{ $qc->titre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Intitulé et description -->
                            <div class="mb-4">
                                <label for="intitule" class="form-label fw-bold">Intitulé <span class="text-danger">*</span></label>
                                <input type="text" name="intitule" id="intitule" class="form-control"
                                       value="{{ old('intitule', $question->intitule) }}" required>

                                <label for="question" class="form-label mt-3 fw-bold">Description (optionnelle)</label>
                                <textarea name="question" id="question" class="form-control" rows="3">{{ old('question', $question->description) }}</textarea>
                            </div>

                            <!-- Réponses -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Réponses possibles</label>
                                <div id="answers-container">
                                    @foreach(range(0,3) as $i)
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">{{ $i+1 }}</span>
                                            <input type="text" name="choix[]" class="form-control"
                                                placeholder="Réponse {{ $i+1 }}"
                                                value="{{ old('choix.'.$i, $question->choix[$i] ?? '') }}"
                                                {{ $i < 2 ? 'required' : '' }}>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Réponse correcte -->
                            <div class="mb-4">
                                <label for="reponse_correcte" class="form-label fw-bold">Réponse correcte <span class="text-danger">*</span></label>
                                <select name="reponse_correcte" id="reponse_correcte" class="form-select" required>
                                    <option value="">-- Choisir la bonne réponse --</option>
                                    @foreach($question->choix as $choix)
                                        @if($choix)
                                            <option value="{{ $choix }}" 
                                                {{ (old('reponse_correcte', $question->reponse_correcte) == $choix) ? 'selected' : '' }}>
                                                {{ $choix }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Boutons -->
                            <div class="d-flex gap-2 pt-3 mt-4 border-top">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i>Mettre à jour
                                </button>
                                <a href="{{ route('questions.index') }}" class="btn btn-secondary px-4">
                                    <i class="fas fa-times me-1"></i>Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

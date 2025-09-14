<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une nouvelle question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --secondary-color: #858796;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 1.5rem;
            font-weight: 700;
            color: #4e73df;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }
        
        .form-label {
            font-weight: 600;
            color: #5a5c69;
            margin-bottom: 0.5rem;
        }
        
        .input-group-text {
            background-color: #eaecf4;
            border: 1px solid #d1d3e2;
        }
        
        .correct-answer-badge {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            display: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #3a5fc8;
            border-color: #3a5fc8;
        }
        
        .validation-hint {
            font-size: 0.8rem;
            padding: 0.5rem;
            border-radius: 0.35rem;
            margin-top: 0.5rem;
            display: none;
        }
        
        .answer-container {
            transition: all 0.3s ease;
        }
        
        .answer-container:hover {
            transform: translateY(-2px);
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            border-color: #a1b4e8;
        }
        
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            border-color: #a1b4e8;
        }
        
        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            font-size: 0.8rem;
            margin-right: 8px;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-plus-circle me-2"></i>Créer une nouvelle question
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

                        <form action="{{ route('questions.store') }}" method="POST" id="question-form">
                            @csrf

                            <div class="mb-4">
                                <h6 class="text-primary mb-3">
                                    <span class="step-number">1</span>QCM associé
                                </h6>
                                <select name="qcm_id" id="qcm_id" class="form-select" required>
                                    <option value="">-- Choisir un QCM --</option>
                                    @foreach($qcm as $qc)
                                        <option value="{{ $qc->id }}" {{ old('qc_id') == $qc->id ? 'selected' : '' }}>
                                            {{ $qc->titre }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="validation-hint alert" id="qcm-hint"></div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-primary mb-3">
                                    <span class="step-number">2</span>Question
                                </h6>
                                <label for="intitule" class="form-label">Intitulé de la question</label>
                                <input type="text" name="intitule" id="intitule" class="form-control"
                                       value="{{ old('intitule') }}" 
                                       placeholder="Saisissez l'intitulé de votre question ici..." required>
                                <div class="validation-hint alert" id="intitule-hint"></div>
                                
                                <label for="question" class="form-label mt-3">Texte de la question (optionnel)</label>
                                <textarea name="question" id="question" class="form-control" rows="3"
                                          placeholder="Saisissez votre question ici...">{{ old('question') }}</textarea>
                                <div class="validation-hint alert" id="question-hint"></div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-primary mb-3">
                                    <span class="step-number">3</span>Réponses possibles
                                </h6>
                                <label class="form-label">Saisissez au moins 2 réponses</label>
                                
                                <div id="answers-container">
                                    @for($i = 0; $i < 4; $i++)
                                    <div class="answer-container mb-2 position-relative">
                                        <div class="input-group">
                                            <span class="input-group-text">{{ $i + 1 }}</span>
                                            <input type="text" name="choix[]" class="form-control choix-input"
                                                   placeholder="Réponse {{ $i + 1 }}{{ $i >= 2 ? ' (optionnel)' : '' }}"
                                                   value="{{ old('choix.' . $i) }}"
                                                   data-index="{{ $i }}"
                                                   {{ $i < 2 ? 'required' : '' }}>
                                            <span class="correct-answer-badge badge bg-success" id="badge-{{ $i }}">
                                                <i class="fas fa-check-circle me-1"></i>Correcte
                                            </span>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                                <div class="validation-hint alert" id="answers-hint"></div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-primary mb-3">
                                    <span class="step-number">4</span>Réponse correcte
                                </h6>
                                <label for="reponse_correcte" class="form-label">Sélectionnez la bonne réponse</label>
                                <select name="reponse_correcte" id="reponse_correcte" class="form-select" required>
                                    <option value="">-- Saisir les réponses ci-dessus d'abord --</option>
                                </select>
                                <div class="form-text text-muted mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    La bonne réponse doit être l'une des options saisies ci-dessus.
                                </div>
                                <div class="validation-hint alert" id="correct-answer-hint"></div>
                            </div>

                            <div class="d-flex gap-2 pt-3 mt-4 border-top">
                                <button type="submit" class="btn btn-primary px-4" id="submit-button">
                                    <i class="fas fa-save me-1"></i>Enregistrer la question
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const choicesInputs = document.querySelectorAll('.choix-input');
        const correctAnswerSelect = document.getElementById('reponse_correcte');
        const form = document.getElementById('question-form');
        const submitButton = document.getElementById('submit-button');
        const questionInput = document.getElementById('question');
        const intituleInput = document.getElementById('intitule');
        const qcmSelect = document.getElementById('qcm_id');
        
        // Éléments de validation
        const qcmHint = document.getElementById('qcm-hint');
        const intituleHint = document.getElementById('intitule-hint');
        const questionHint = document.getElementById('question-hint');
        const answersHint = document.getElementById('answers-hint');
        const correctAnswerHint = document.getElementById('correct-answer-hint');

        function updateCorrectAnswerOptions() {
            const selectedCorrectAnswer = correctAnswerSelect.value;
            correctAnswerSelect.innerHTML = '<option value="">-- Choisir la bonne réponse --</option>';
            
            const choices = [];
            const seenValues = new Set();
            
            choicesInputs.forEach((input, index) => {
                const value = input.value.trim();
                if (value && !seenValues.has(value)) {
                    seenValues.add(value);
                    choices.push({
                        value: value,
                        index: index + 1,
                        originalIndex: index
                    });
                    
                    // Masquer le badge de réponse correcte pour toutes les réponses
                    document.getElementById(`badge-${index}`).style.display = 'none';
                }
            });

            choices.sort((a, b) => a.originalIndex - b.originalIndex);

            choices.forEach(choice => {
                const option = document.createElement('option');
                option.value = choice.value;
                option.textContent = `Réponse ${choice.index}: ${choice.value}`;
                
                if (choice.value === selectedCorrectAnswer) {
                    option.selected = true;
                    // Afficher le badge pour la réponse correcte
                    document.getElementById(`badge-${choice.originalIndex}`).style.display = 'block';
                }
                correctAnswerSelect.appendChild(option);
            });
            
            if (selectedCorrectAnswer && !choices.some(choice => choice.value === selectedCorrectAnswer)) {
                correctAnswerSelect.value = '';
            }
            
            if (choices.length === 0) {
                correctAnswerSelect.innerHTML = '<option value="">-- Saisir les réponses ci-dessus d\'abord --</option>';
            }
            
            validateForm();
        }

        function validateForm() {
            const nonEmptyChoices = Array.from(choicesInputs).filter(i => i.value.trim() !== '').length;
            const choiceValues = Array.from(choicesInputs)
                .map(i => i.value.trim())
                .filter(v => v !== '');
            
            // Validation du QCM
            if (qcmSelect.value !== '') {
                showValidationHint(qcmHint, true, "QCM sélectionné");
            } else {
                showValidationHint(qcmHint, false, "Veuillez sélectionner un QCM");
            }
            
            // Validation de l'intitulé (champ requis)
            if (intituleInput.value.trim() !== '') {
                showValidationHint(intituleHint, true, "Intitulé saisi");
            } else {
                showValidationHint(intituleHint, false, "Veuillez saisir un intitulé");
            }
            
            // Validation de la question (optionnelle)
            if (questionInput.value.trim() !== '') {
                showValidationHint(questionHint, true, "Question saisie");
            } else {
                showValidationHint(questionHint, true, "Question optionnelle non saisie");
            }
            
            // Validation des réponses
            if (nonEmptyChoices >= 2) {
                showValidationHint(answersHint, true, `Nombre de réponses valides : ${nonEmptyChoices}/4`);
            } else {
                showValidationHint(answersHint, false, `Saisissez au moins 2 réponses (actuellement : ${nonEmptyChoices})`);
            }
            
            // Validation de la réponse correcte
            const isCorrectAnswerValid = correctAnswerSelect.value !== '' && 
                                         choiceValues.includes(correctAnswerSelect.value);
            
            if (isCorrectAnswerValid) {
                showValidationHint(correctAnswerHint, true, "Réponse correcte sélectionnée");
            } else {
                showValidationHint(correctAnswerHint, false, "Veuillez sélectionner une réponse correcte valide");
            }
            
            // Validation globale du formulaire
            const isFormValid = qcmSelect.value !== '' &&
                                intituleInput.value.trim() !== '' &&
                                nonEmptyChoices >= 2 &&
                                isCorrectAnswerValid;
            
            submitButton.disabled = !isFormValid;
            
            if (isFormValid) {
                submitButton.classList.remove('btn-secondary');
                submitButton.classList.add('btn-primary');
            } else {
                submitButton.classList.remove('btn-primary');
                submitButton.classList.add('btn-secondary');
            }
        }
        
        function showValidationHint(element, isValid, message) {
            element.textContent = message;
            element.style.display = 'block';
            
            if (isValid) {
                element.classList.remove('alert-danger');
                element.classList.add('alert-success');
            } else {
                element.classList.remove('alert-success');
                element.classList.add('alert-danger');
            }
        }

        // Écouteurs d'événements pour les champs principaux
        [qcmSelect, intituleInput, questionInput, correctAnswerSelect].forEach(element => {
            element.addEventListener('change', validateForm);
            element.addEventListener('input', validateForm);
        });
        
        // Écouteurs d'événements pour les champs de réponse
        choicesInputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(input.updateTimeout);
                input.updateTimeout = setTimeout(updateCorrectAnswerOptions, 300);
            });
            
            input.addEventListener('paste', () => {
                setTimeout(updateCorrectAnswerOptions, 100);
            });
            
            input.addEventListener('blur', updateCorrectAnswerOptions);
        });

        // Initialisation avec les valeurs old() s'il y en a
        if ({{ json_encode(old('choix') !== null) }}) {
            setTimeout(updateCorrectAnswerOptions, 100);
        } else {
            updateCorrectAnswerOptions();
        }
        validateForm();
    });
    </script>
</body>
</html>
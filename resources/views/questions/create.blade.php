<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une nouvelle question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .step-number {
            background: #007bff;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-right: 10px;
        }
        
        .correct-answer-badge {
            display: none;
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .validation-hint {
            font-size: 0.875rem;
            margin-top: 0.25rem;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            display: none;
        }
        
        .answer-container {
            position: relative;
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
                                <label for="intitule" class="form-label">Intitulé de la question <span class="text-danger">*</span></label>
                                <input type="text" name="intitule" id="intitule" class="form-control"
                                       value="{{ old('intitule') }}" 
                                       placeholder="Saisissez l'intitulé de votre question ici..." required>
                                <div class="validation-hint alert" id="intitule-hint"></div>
                                
                                <label for="question" class="form-label mt-3">Description supplémentaire <span class="text-muted">(optionnel)</span></label>
                                <textarea name="question" id="question" class="form-control" rows="3"
                                          placeholder="Ajoutez des détails ou une description supplémentaire...">{{ old('question') }}</textarea>
                                <div class="validation-hint alert" id="question-hint"></div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-primary mb-3">
                                    <span class="step-number">3</span>Réponses possibles
                                </h6>
                                <label class="form-label">Saisissez au moins 2 réponses <span class="text-danger">*</span></label>
                                
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
                                <label for="reponse_correcte" class="form-label">Sélectionnez la bonne réponse <span class="text-danger">*</span></label>
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
            
            // Réinitialiser tous les badges
            choicesInputs.forEach((input, index) => {
                document.getElementById(`badge-${index}`).style.display = 'none';
            });
            
            // Construire la liste des choix valides
            choicesInputs.forEach((input, index) => {
                const value = input.value.trim();
                if (value && !seenValues.has(value.toLowerCase())) {
                    seenValues.add(value.toLowerCase());
                    choices.push({
                        value: value,
                        index: index + 1,
                        originalIndex: index
                    });
                }
            });

            // Trier par ordre d'apparition
            choices.sort((a, b) => a.originalIndex - b.originalIndex);

            // Ajouter les options au select
            choices.forEach(choice => {
                const option = document.createElement('option');
                option.value = choice.value;
                option.textContent = `Réponse ${choice.index}: ${choice.value}`;
                correctAnswerSelect.appendChild(option);
            });
            
            // Rétablir la sélection si elle existe encore
            if (selectedCorrectAnswer) {
                const matchingChoice = choices.find(choice => choice.value === selectedCorrectAnswer);
                if (matchingChoice) {
                    correctAnswerSelect.value = selectedCorrectAnswer;
                    document.getElementById(`badge-${matchingChoice.originalIndex}`).style.display = 'block';
                }
            }
            
            // Message par défaut si aucun choix
            if (choices.length === 0) {
                correctAnswerSelect.innerHTML = '<option value="">-- Saisir les réponses ci-dessus d\'abord --</option>';
            }
            
            validateForm();
        }

        // Gérer la sélection de la réponse correcte
        correctAnswerSelect.addEventListener('change', function() {
            // Masquer tous les badges
            choicesInputs.forEach((input, index) => {
                document.getElementById(`badge-${index}`).style.display = 'none';
            });
            
            // Afficher le badge pour la réponse correcte
            if (this.value) {
                choicesInputs.forEach((input, index) => {
                    if (input.value.trim() === this.value) {
                        document.getElementById(`badge-${index}`).style.display = 'block';
                    }
                });
            }
            
            validateForm();
        });

        function validateForm() {
            // Compter les choix non vides
            const nonEmptyChoices = Array.from(choicesInputs).filter(i => i.value.trim() !== '').length;
            const choiceValues = Array.from(choicesInputs)
                .map(i => i.value.trim())
                .filter(v => v !== '');
            
            // Validation du QCM
            if (qcmSelect.value !== '') {
                showValidationHint(qcmHint, true, "✓ QCM sélectionné");
            } else {
                showValidationHint(qcmHint, false, "⚠ Veuillez sélectionner un QCM");
            }
            
            // Validation de l'intitulé (champ requis)
            if (intituleInput.value.trim() !== '') {
                showValidationHint(intituleHint, true, "✓ Intitulé saisi");
            } else {
                showValidationHint(intituleHint, false, "⚠ L'intitulé est requis");
            }
            
            // Validation de la question (optionnelle)
            if (questionInput.value.trim() !== '') {
                showValidationHint(questionHint, true, "✓ Description supplémentaire ajoutée");
            } else {
                showValidationHint(questionHint, true, "ℹ Description optionnelle non renseignée");
            }
            
            // Validation des réponses
            if (nonEmptyChoices >= 2) {
                showValidationHint(answersHint, true, `✓ ${nonEmptyChoices} réponse(s) saisie(s)`);
            } else {
                showValidationHint(answersHint, false, `⚠ Au moins 2 réponses requises (${nonEmptyChoices} actuellement)`);
            }
            
            // Validation de la réponse correcte
            const isCorrectAnswerValid = correctAnswerSelect.value !== '' && 
                                         choiceValues.includes(correctAnswerSelect.value);
            
            if (isCorrectAnswerValid) {
                showValidationHint(correctAnswerHint, true, "✓ Réponse correcte sélectionnée");
            } else {
                showValidationHint(correctAnswerHint, false, "⚠ Veuillez sélectionner une réponse correcte");
            }
            
            // Validation globale du formulaire
            const isFormValid = qcmSelect.value !== '' &&
                                intituleInput.value.trim() !== '' &&
                                nonEmptyChoices >= 2 &&
                                isCorrectAnswerValid;
            
            // État du bouton
            submitButton.disabled = !isFormValid;
            
            if (isFormValid) {
                submitButton.classList.remove('btn-secondary');
                submitButton.classList.add('btn-primary');
                submitButton.innerHTML = '<i class="fas fa-save me-1"></i>Enregistrer la question';
            } else {
                submitButton.classList.remove('btn-primary');
                submitButton.classList.add('btn-secondary');
                submitButton.innerHTML = '<i class="fas fa-save me-1"></i>Formulaire incomplet';
            }
        }
        
        function showValidationHint(element, isValid, message) {
            element.textContent = message;
            element.style.display = 'block';
            
            // Supprimer les anciennes classes
            element.classList.remove('alert-danger', 'alert-success', 'alert-info');
            
            if (isValid && message.startsWith('✓')) {
                element.classList.add('alert-success');
            } else if (isValid && message.startsWith('ℹ')) {
                element.classList.add('alert-info');
            } else {
                element.classList.add('alert-danger');
            }
        }

        // Écouteurs d'événements pour les champs principaux
        [qcmSelect, intituleInput, questionInput].forEach(element => {
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

        // Validation de soumission du formulaire
        form.addEventListener('submit', function(e) {
            const nonEmptyChoices = Array.from(choicesInputs).filter(i => i.value.trim() !== '').length;
            
            if (nonEmptyChoices < 2) {
                e.preventDefault();
                alert('Veuillez saisir au moins 2 réponses.');
                return false;
            }
            
            if (!correctAnswerSelect.value) {
                e.preventDefault();
                alert('Veuillez sélectionner une réponse correcte.');
                return false;
            }
            
            if (!intituleInput.value.trim()) {
                e.preventDefault();
                alert('L\'intitulé de la question est requis.');
                return false;
            }
        });

        // Initialisation avec les valeurs old() s'il y en a
        setTimeout(() => {
            updateCorrectAnswerOptions();
            
            // Restaurer la sélection de la réponse correcte si elle existe
            const oldCorrectAnswer = '{{ old("reponse_correcte") }}';
            if (oldCorrectAnswer) {
                correctAnswerSelect.value = oldCorrectAnswer;
                correctAnswerSelect.dispatchEvent(new Event('change'));
            }
        }, 100);
        
        // Validation initiale
        validateForm();
    });
    </script>
</body>
</html> 
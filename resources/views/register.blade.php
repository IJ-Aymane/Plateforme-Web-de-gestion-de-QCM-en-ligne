<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Mon Espace QCM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Style pour le spinner du bouton --}}
    <style>
        .spinner {
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            width: 16px;
            height: 16px;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-bg-light text-text font-sans">

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-2xl border border-border shadow-sm space-y-8">
            <div class="flex justify-center items-center gap-2 text-2xl font-bold text-primary">
                <i data-lucide="graduation-cap" class="h-8 w-8"></i>
                <span>Mon Espace QCM</span>
            </div>
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
                Créez votre compte
            </h2>
            
            <form id="register-form" class="mt-8 space-y-6" action="{{ route('register.submit') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    
                    <div>
                        <label for="name" class="block text-sm font-medium">Nom complet</label>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                               class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-primary focus:border-primary @error('name') border-red-500 @else border-border @enderror">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- CHAMP EMAIL (inchangé) --}}
                    <div>
                        <label for="email" class="block text-sm font-medium">Adresse e-mail</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                               class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-primary focus:border-primary @error('email') border-red-500 @else border-border @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- CHAMP MOT DE PASSE (inchangé) --}}
                    <div>
                        <label for="password" class="block text-sm font-medium">Mot de passe</label>
                        <div class="relative mt-1">
                            <input id="password" name="password" type="password" required
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-primary focus:border-primary @error('password') border-red-500 @else border-border @enderror">
                            <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500" onclick="togglePassword('password')">
                                <i data-lucide="eye" class="h-5 w-5"></i>
                            </button>
                        </div>
                         @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- CHAMP CONFIRMATION MOT DE PASSE (inchangé) --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium">Confirmer le mot de passe</label>
                         <div class="relative mt-1">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-primary focus:border-primary">
                             <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500" onclick="togglePassword('password_confirmation')">
                                <i data-lucide="eye" class="h-5 w-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" id="submit-button"
                            class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent text-sm font-semibold rounded-lg text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition disabled:opacity-50">
                        S'inscrire
                    </button>
                </div>
            </form>
            <div class="border-t border-border pt-6">
                <p class="text-center text-sm text-text-muted">
                    Déjà un compte ?
                    <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary-dark">
                        Connectez-vous
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                field.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        const form = document.getElementById('register-form');
        const submitButton = document.getElementById('submit-button');
        
        form.addEventListener('submit', function() {
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <div class="spinner"></div>
                <span>Inscription en cours...</span>
            `;
        });
    </script>
</body>
</html>
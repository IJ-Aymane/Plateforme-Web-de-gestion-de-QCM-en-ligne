<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Mon Espace QCM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-light text-text font-sans">

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-2xl border border-border shadow-sm space-y-8">
            
            <div>
                <div class="flex justify-center items-center gap-2 text-2xl font-bold text-primary">
                    <i data-lucide="graduation-cap" class="h-8 w-8"></i>
                    <span>Mon Espace QCM</span>
                </div>
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
                    Connectez-vous
                </h2>
                <p class="mt-2 text-center text-sm text-text-muted">
                    Accédez à votre tableau de bord ou à vos quiz.
                </p>
            </div>

            <!-- Affichage des erreurs -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Erreur de connexion</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Message succès -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="check-circle" class="h-5 w-5 text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <form class="mt-8 space-y-6" action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="rounded-md -space-y-px">
                    <div class="mb-4">
                        <label for="email" class="font-medium text-sm mb-1 block">Adresse e-mail</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               value="{{ old('email') }}"
                               class="appearance-none relative block w-full px-3 py-2 border border-border placeholder-gray-500 text-text rounded-lg focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm @error('email') border-red-500 @enderror" 
                               placeholder="nom@exemple.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password" class="font-medium text-sm mb-1 block">Mot de passe</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                   class="appearance-none relative block w-full px-3 py-2 border border-border placeholder-gray-500 text-text rounded-lg focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm @error('password') border-red-500 @enderror" 
                                   placeholder="Votre mot de passe">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword()">
                                <i data-lucide="eye" id="eye-icon" class="h-4 w-4 text-gray-400"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                               class="h-4 w-4 text-primary bg-bg-light border-border rounded focus:ring-primary">
                        <label for="remember" class="ml-2 block text-sm text-text">
                            Se souvenir de moi
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-primary hover:text-primary-dark">
                            Mot de passe oublié ?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-lg text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition disabled:opacity-50 disabled:cursor-not-allowed"
                            id="login-btn">
                        <span id="login-text">Se connecter</span>
                        <span id="login-loading" class="hidden">
                            <i data-lucide="loader-2" class="h-4 w-4 animate-spin"></i>
                            Connexion...
                        </span>
                    </button>
                </div>

                @if(config('app.env') === 'local')
                <div class="border-t border-border pt-6">
                    <p class="text-center text-sm text-text-muted mb-3">Mode développement - Connexion rapide:</p>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" onclick="quickLogin('enseignant')" class="text-xs bg-blue-100 text-blue-700 py-2 px-3 rounded border hover:bg-blue-200">
                            Enseignant
                        </button>
                        <button type="button" onclick="quickLogin('etudiant')" class="text-xs bg-green-100 text-green-700 py-2 px-3 rounded border hover:bg-green-200">
                            Étudiant
                        </button>
                    </div>
                </div>
                @endif
            </form>

            <div class="border-t border-border pt-6">
                <p class="text-center text-sm text-text-muted">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="font-medium text-primary hover:text-primary-dark">
                        Inscrivez-vous
                    </a>
                </p>
            </div>

        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordField.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('login-btn');
            const text = document.getElementById('login-text');
            const loading = document.getElementById('login-loading');
            btn.disabled = true;
            text.classList.add('hidden');
            loading.classList.remove('hidden');
        });

        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-red-50, .bg-green-50');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() { alert.remove(); }, 500);
            });
        }, 5000);
    </script>

    @if(config('app.env') === 'local')
    <script>
        function quickLogin(role) {
            if (role === 'enseignant') {
                document.getElementById('email').value = 'enseignant@test.com';
                document.getElementById('password').value = 'password';
            } else {
                document.getElementById('email').value = 'etudiant@test.com';
                document.getElementById('password').value = 'password';
            }
        }
    </script>
    @endif

</body>
</html>

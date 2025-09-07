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
            
            <form class="mt-8 space-y-6" action="#" method="POST">
                <input type="hidden" name="remember" value="true">
                
                <div class="rounded-md -space-y-px">
                    <div class="mb-4">
                        <label for="email-address" class="font-medium text-sm mb-1 block">Adresse e-mail</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required 
                               class="appearance-none relative block w-full px-3 py-2 border border-border placeholder-gray-500 text-text rounded-lg focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" 
                               placeholder="nom@exemple.com">
                    </div>
                    
                    <div>
                        <label for="password" class="font-medium text-sm mb-1 block">Mot de passe</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="appearance-none relative block w-full px-3 py-2 border border-border placeholder-gray-500 text-text rounded-lg focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" 
                               placeholder="Votre mot de passe">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" 
                               class="h-4 w-4 text-primary bg-bg-light border-border rounded focus:ring-primary">
                        <label for="remember-me" class="ml-2 block text-sm text-text">
                            Se souvenir de moi
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-primary hover:text-primary-dark">
                            Mot de passe oublié ?
                        </a>
                    </div>
                </div>

                <div>
                    <a href="{{ url('/dashboardAdmin') }}" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-lg text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                        Se connecter
</a>
                </div>
            </form>

            <p class="text-center text-sm text-text-muted">
                Pas encore de compte ?
                <a href="#" class="font-medium text-primary hover:text-primary-dark">
                    Inscrivez-vous
                </a>
            </p>

        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
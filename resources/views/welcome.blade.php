<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace QCM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-light text-text font-sans">

    <!-- HEADER SIMPLE -->
    <header class="bg-white shadow-sm border-b border-border">
        <div class="container mx-auto flex h-16 items-center justify-between px-4">
            <div class="flex items-center gap-2 text-xl font-bold text-primary">
                <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                <span>Mon Espace QCM</span>
            </div>
            <div class="flex items-center gap-4">
                <!-- Boutons de connexion -->
                <div class="flex items-center gap-2">
                    <button class="px-4 py-2 text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition font-medium">
                        <i data-lucide="user" class="h-4 w-4 inline mr-2"></i>
                        Client
                    </button>
                    <button class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-secondary-dark transition font-medium">
                        <i data-lucide="shield" class="h-4 w-4 inline mr-2"></i>
                        Admin
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- CONTENU PRINCIPAL -->
    <main class="container mx-auto px-4 py-8">
        
        <!-- TITRE DE BIENVENUE -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-primary mb-2">Bienvenue dans votre espace QCM</h1>
            <p class="text-text-muted">Accédez à vos quiz et consultez vos résultats</p>
        </div>

        <!-- ACTIONS PRINCIPALES -->
        <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto mb-10">
            
            <!-- Quiz Disponibles -->
            <div class="bg-white rounded-xl border border-border p-6 shadow-sm hover:shadow-md transition">
                <div class="text-center">
                    <div class="p-4 rounded-lg bg-primary-light mx-auto w-fit mb-4">
                        <i data-lucide="play-circle" class="w-8 h-8 text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-primary mb-2">Passer un QCM</h3>
                    <p class="text-text-muted mb-4">Quiz disponibles à réaliser</p>
                    <button class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition">
                        Voir les quiz
                    </button>
                </div>
            </div>

            <!-- Mes Résultats -->
            <div class="bg-white rounded-xl border border-border p-6 shadow-sm hover:shadow-md transition">
                <div class="text-center">
                    <div class="p-4 rounded-lg bg-secondary-light mx-auto w-fit mb-4">
                        <i data-lucide="bar-chart-3" class="w-8 h-8 text-secondary"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-secondary mb-2">Mes Résultats</h3>
                    <p class="text-text-muted mb-4">Consultez vos notes et performances</p>
                    <button class="w-full bg-secondary text-white py-3 rounded-lg font-semibold hover:bg-secondary-dark transition">
                        Voir les résultats
                    </button>
                </div>
            </div>
        </div>

        <!-- STATISTIQUES RAPIDES -->
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm max-w-4xl mx-auto">
            <h3 class="text-lg font-semibold text-primary mb-4">Aperçu rapide</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-bg-light rounded-lg">
                    <div class="text-2xl font-bold text-primary">5</div>
                    <div class="text-sm text-text-muted">Quiz disponibles</div>
                </div>
                <div class="text-center p-4 bg-bg-light rounded-lg">
                    <div class="text-2xl font-bold text-secondary">12</div>
                    <div class="text-sm text-text-muted">Quiz complétés</div>
                </div>
                <div class="text-center p-4 bg-bg-light rounded-lg">
                    <div class="text-2xl font-bold text-accent">85%</div>
                    <div class="text-sm text-text-muted">Moyenne générale</div>
                </div>
                <div class="text-center p-4 bg-bg-light rounded-lg">
                    <div class="text-2xl font-bold text-primary">3</div>
                    <div class="text-sm text-text-muted">Matières actives</div>
                </div>
            </div>
        </div>

    </main>

    <!-- FOOTER SIMPLE -->
    <footer class="bg-white border-t border-border mt-12 py-4">
        <div class="container mx-auto px-4 text-center text-sm text-text-muted">
            © 2025 Plateforme QCM - Espace Étudiant
        </div>
    </footer>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
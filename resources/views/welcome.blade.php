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
                @auth
                    <!-- User is logged in -->
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <img src="https://i.pravatar.cc/32?u={{ Auth::user()->email }}" alt="Avatar" class="h-8 w-8 rounded-full">
                            <span class="text-sm font-medium">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                        </div>
                        @if(Auth::user()->role === 'enseignant')
                            <a href="{{ route('dashboard.admin') }}" 
                               class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-medium">
                                <i data-lucide="layout-dashboard" class="h-4 w-4 inline mr-2"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('dashboard.student') }}" 
                               class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-medium">
                                <i data-lucide="user" class="h-4 w-4 inline mr-2"></i>
                                Mes QCM
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-red-500 border border-red-500 rounded-lg hover:bg-red-500 hover:text-white transition font-medium">
                                <i data-lucide="log-out" class="h-4 w-4 inline mr-2"></i>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                @else
                    <!-- User is not logged in -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('register') }}" 
                           class="px-4 py-2 text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition font-medium">
                            <i data-lucide="user-plus" class="h-4 w-4 inline mr-2"></i>
                            S'inscrire
                        </a>
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition font-medium">
                            <i data-lucide="log-in" class="h-4 w-4 inline mr-2"></i>
                            Connexion
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- CONTENU PRINCIPAL -->
    <main class="container mx-auto px-4 py-8">
        
        @auth
            <!-- Content for logged-in users -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-primary mb-2">
                    Bienvenue {{ Auth::user()->prenom }} !
                </h1>
                <p class="text-text-muted">
                    @if(Auth::user()->role === 'enseignant')
                        Gérez vos QCM et suivez les performances de vos étudiants
                    @else
                        Accédez à vos quiz et consultez vos résultats
                    @endif
                </p>
            </div>

            @if(Auth::user()->role === 'enseignant')
                <!-- Teacher Dashboard Quick Actions -->
                <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto mb-10">
                    <div class="bg-white rounded-xl border border-border p-6 shadow-sm hover:shadow-md transition">
                        <div class="text-center">
                            <div class="p-4 rounded-lg bg-primary-light mx-auto w-fit mb-4">
                                <i data-lucide="file-plus" class="w-8 h-8 text-primary"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-primary mb-2">Créer un QCM</h3>
                            <p class="text-text-muted mb-4">Créez de nouveaux questionnaires</p>
                            <a href="{{ route('qcm.create') }}" class="w-full inline-block bg-primary text-white py-3 px-4 rounded-lg font-semibold hover:bg-primary-dark transition">
                                Nouveau QCM
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-border p-6 shadow-sm hover:shadow-md transition">
                        <div class="text-center">
                            <div class="p-4 rounded-lg bg-secondary-light mx-auto w-fit mb-4">
                                <i data-lucide="users" class="w-8 h-8 text-secondary"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-secondary mb-2">Mes Étudiants</h3>
                            <p class="text-text-muted mb-4">Gérer les étudiants et leurs résultats</p>
                            <a href="{{ route('users.index') }}" class="w-full inline-block bg-secondary text-white py-3 px-4 rounded-lg font-semibold hover:bg-secondary-dark transition">
                                Voir les étudiants
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-border p-6 shadow-sm hover:shadow-md transition">
                        <div class="text-center">
                            <div class="p-4 rounded-lg bg-green-100 mx-auto w-fit mb-4">
                                <i data-lucide="bar-chart-3" class="w-8 h-8 text-green-600"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-green-600 mb-2">Statistiques</h3>
                            <p class="text-text-muted mb-4">Analysez les performances</p>
                            <a href="{{ route('resultats.index') }}" class="w-full inline-block bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition">
                                Voir les stats
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Teacher Statistics -->
                <div class="bg-white rounded-xl border border-border p-6 shadow-sm max-w-6xl mx-auto">
                    <h3 class="text-lg font-semibold text-primary mb-4">Aperçu de vos activités</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 bg-bg-light rounded-lg">
                            <div class="text-2xl font-bold text-primary">{{ $userQcmCount ?? 0 }}</div>
                            <div class="text-sm text-text-muted">QCM créés</div>
                        </div>
                        <div class="text-center p-4 bg-bg-light rounded-lg">
                            <div class="text-2xl font-bold text-secondary">{{ $userQuestionsCount ?? 0 }}</div>
                            <div class="text-sm text-text-muted">Questions créées</div>
                        </div>
                        <div class="text-center p-4 bg-bg-light rounded-lg">
                            <div class="text-2xl font-bold text-accent">{{ $studentsCount ?? 0 }}</div>
                            <div class="text-sm text-text-muted">Étudiants actifs</div>
                        </div>
                        <div class="text-center p-4 bg-bg-light rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ $totalAttempts ?? 0 }}</div>
                            <div class="text-sm text-text-muted">Tentatives totales</div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Student Dashboard Quick Actions -->
                <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto mb-10">
                    
                    <!-- Quiz Disponibles -->
                    <div class="bg-white rounded-xl border border-border p-6 shadow-sm hover:shadow-md transition">
                        <div class="text-center">
                            <div class="p-4 rounded-lg bg-primary-light mx-auto w-fit mb-4">
                                <i data-lucide="play-circle" class="w-8 h-8 text-primary"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-primary mb-2">Passer un QCM</h3>
                            <p class="text-text-muted mb-4">{{ $availableQcmCount ?? 0 }} quiz disponibles à réaliser</p>
                            <a href="{{ route('qcm.available') }}" class="w-full inline-block bg-primary text-white py-3 px-4 rounded-lg font-semibold hover:bg-primary-dark transition">
                                Voir les quiz
                            </a>
                        </div>
                    </div>

                    <!-- Mes Résultats -->
                    <div class="bg-white rounded-xl border border-border p-6 shadow-sm hover:shadow-md transition">
                        <div class="text-center">
                            <div class="p-4 rounded-lg bg-secondary-light mx-auto w-fit mb-4">
                                <i data-lucide="bar-chart-3" class="w-8 h-8 text-secondary"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-secondary mb-2">Mes Résultats</h3>
                            <p class="text-text-muted mb-4">Consultez vos {{ $completedQcmCount ?? 0 }} QCM complétés</p>
                            <a href="{{ route('student.results') }}" class="w-full inline-block bg-secondary text-white py-3 px-4 rounded-lg font-semibold hover:bg-secondary-dark transition">
                                Voir les résultats
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Student Statistics -->
                <div class="bg-white rounded-xl border border-border p-6 shadow-sm max-w-4xl mx-auto">
                    <h3 class="text-lg font-semibold text-primary mb-4">Vos performances</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 bg-bg-light rounded-lg">
                            <div class="text-2xl font-bold text-primary">{{ $availableQcmCount ?? 0 }}</div>
                            <div class="text-sm text-text-muted">Quiz disponibles</div>
                        </div>
                        <div class="text-center p-4 bg-bg-light rounded-lg">
                            <div class="text-2xl font-bold text-secondary">{{ $completedQcmCount ?? 0 }}</div>
                            <div class="text-sm text-text-muted">Quiz complétés</div>
                        </div>
                        <div class="text-center p-4 bg-bg-light rounded-lg">
                            <div class="text-2xl font-bold text-accent">{{ number_format($averageScore ?? 0, 1) }}%</div>
                            <div class="text-sm text-text-muted">Moyenne générale</div>
                        </div>
                        <div class="text-center p-4 bg-bg-light rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ $bestScore ?? 0 }}%</div>
                            <div class="text-sm text-text-muted">Meilleur score</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Results for Student -->
                @if(isset($recentResults) && $recentResults->count() > 0)
                <div class="mt-8 bg-white rounded-xl border border-border shadow-sm max-w-4xl mx-auto">
                    <div class="p-6 border-b border-border">
                        <h3 class="text-lg font-semibold text-primary">Vos derniers résultats</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($recentResults->take(5) as $result)
                            <div class="flex items-center justify-between p-4 bg-bg-light rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-full {{ $result->score >= ($result->total_questions * 0.7) ? 'bg-green-100' : 'bg-red-100' }}">
                                        <i data-lucide="{{ $result->score >= ($result->total_questions * 0.7) ? 'check-circle' : 'x-circle' }}" 
                                           class="h-4 w-4 {{ $result->score >= ($result->total_questions * 0.7) ? 'text-green-600' : 'text-red-600' }}"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $result->qcm->titre }}</p>
                                        <p class="text-sm text-text-muted">{{ $result->created_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold {{ $result->score >= ($result->total_questions * 0.7) ? 'text-green-600' : 'text-red-500' }}">
                                        {{ number_format(($result->score / $result->total_questions) * 100, 1) }}%
                                    </div>
                                    <div class="text-sm text-text-muted">{{ $result->score }}/{{ $result->total_questions }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            @endif

        @else
            <!-- Content for guest users -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-primary mb-2">Bienvenue dans votre espace QCM</h1>
                <p class="text-text-muted">Connectez-vous pour accéder à vos quiz et consulter vos résultats</p>
            </div>

            <!-- Call to action for guests -->
            <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto mb-10">
                
                <!-- Étudiants -->
                <div class="bg-white rounded-xl border border-border p-8 shadow-sm hover:shadow-md transition">
                    <div class="text-center">
                        <div class="p-4 rounded-lg bg-primary-light mx-auto w-fit mb-4">
                            <i data-lucide="user" class="w-8 h-8 text-primary"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-primary mb-2">Vous êtes étudiant ?</h3>
                        <p class="text-text-muted mb-6">Accédez à vos quiz, passez des tests et consultez vos résultats en temps réel.</p>
                        <div class="space-y-3">
                            <a href="{{ route('register', ['role' => 'etudiant']) }}" class="w-full inline-block bg-primary text-white py-3 px-4 rounded-lg font-semibold hover:bg-primary-dark transition">
                                S'inscrire comme étudiant
                            </a>
                            <a href="{{ route('login') }}" class="w-full inline-block border border-primary text-primary py-3 px-4 rounded-lg font-semibold hover:bg-primary hover:text-white transition">
                                Se connecter
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Enseignants -->
                <div class="bg-white rounded-xl border border-border p-8 shadow-sm hover:shadow-md transition">
                    <div class="text-center">
                        <div class="p-4 rounded-lg bg-secondary-light mx-auto w-fit mb-4">
                            <i data-lucide="graduation-cap" class="w-8 h-8 text-secondary"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-secondary mb-2">Vous êtes enseignant ?</h3>
                        <p class="text-text-muted mb-6">Créez des QCM, gérez vos étudiants et analysez leurs performances facilement.</p>
                        <div class="space-y-3">
                            <a href="{{ route('register', ['role' => 'enseignant']) }}" class="w-full inline-block bg-secondary text-white py-3 px-4 rounded-lg font-semibold hover:bg-secondary-dark transition">
                                S'inscrire comme enseignant
                            </a>
                            <a href="{{ route('login') }}" class="w-full inline-block border border-secondary text-secondary py-3 px-4 rounded-lg font-semibold hover:bg-secondary hover:text-white transition">
                                Se connecter
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features showcase -->
            <div class="bg-white rounded-xl border border-border p-8 shadow-sm max-w-6xl mx-auto">
                <h3 class="text-2xl font-semibold text-primary mb-8 text-center">Pourquoi choisir notre plateforme ?</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="p-4 rounded-lg bg-blue-100 mx-auto w-fit mb-4">
                            <i data-lucide="zap" class="w-8 h-8 text-blue-600"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Rapide et intuitif</h4>
                        <p class="text-text-muted">Interface moderne et facile à utiliser pour créer et passer des QCM rapidement.</p>
                    </div>
                    <div class="text-center">
                        <div class="p-4 rounded-lg bg-green-100 mx-auto w-fit mb-4">
                            <i data-lucide="shield-check" class="w-8 h-8 text-green-600"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Sécurisé</h4>
                        <p class="text-text-muted">Vos données sont protégées et vos résultats sont sauvegardés de manière sécurisée.</p>
                    </div>
                    <div class="text-center">
                        <div class="p-4 rounded-lg bg-purple-100 mx-auto w-fit mb-4">
                            <i data-lucide="trending-up" class="w-8 h-8 text-purple-600"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Suivi des performances</h4>
                        <p class="text-text-muted">Statistiques détaillées et suivi de la progression pour optimiser l'apprentissage.</p>
                    </div>
                </div>
            </div>
        @endauth

    </main>

    <!-- FOOTER SIMPLE -->
    <footer class="bg-white border-t border-border mt-12 py-6">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <div class="flex items-center gap-2 text-lg font-bold text-primary justify-center md:justify-start">
                        <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                        <span>Mon Espace QCM</span>
                    </div>
                    <p class="text-sm text-text-muted mt-1">
                        © {{ date('Y') }} Plateforme QCM - Tous droits réservés
                    </p>
                </div>
                <div class="flex items-center gap-6 text-sm text-text-muted">
                    <a href="#" class="hover:text-primary transition">Aide</a>
                    <a href="#" class="hover:text-primary transition">Contact</a>
                    <a href="#" class="hover:text-primary transition">Conditions d'utilisation</a>
                </div>
            </div>
        </div>
    </footer>

    @if(session('success'))
    <div id="success-alert" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) alert.style.display = 'none';
        }, 3000);
    </script>
    @endif

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace QCM - Plateforme d'évaluation en ligne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- HEADER -->
    <header class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto flex h-16 items-center justify-between px-6">
            <div class="flex items-center gap-3 text-2xl font-bold text-blue-600">
                <i class="fas fa-graduation-cap"></i>
                <span>Mon Espace QCM</span>
            </div>
            <nav class="hidden md:flex items-center gap-6">
                <a href="#features" class="text-gray-600 hover:text-blue-600 transition duration-300 font-medium">
                    Fonctionnalités
                </a>
                <a href="#qcms" class="text-gray-600 hover:text-blue-600 transition duration-300 font-medium">
                    QCM Disponibles
                </a>
                <a href="#contact" class="text-gray-600 hover:text-blue-600 transition duration-300 font-medium">
                    Contact
                </a>
            </nav>
            <div class="flex items-center gap-3">
                <a href="{{ route('register') }}" 
                   class="px-5 py-2 text-blue-600 border-2 border-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition duration-300 font-medium">
                    <i class="fas fa-user-plus mr-2"></i>
                    S'inscrire
                </a>
                <a href="{{ route('login') }}" 
                   class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 font-medium shadow-md">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Connexion
                </a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 text-white overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative container mx-auto px-6 py-20 lg:py-28">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Évaluez vos connaissances avec
                    <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">
                        nos QCM interactifs
                    </span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100 leading-relaxed">
                    Une plateforme moderne pour passer des tests, suivre vos progrès et améliorer vos compétences
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if(auth()->check())
                        <a href="{{ route('student.dashboard') }}" 
                           class="px-8 py-4 bg-yellow-400 text-gray-900 rounded-lg hover:bg-yellow-300 transition duration-300 font-bold text-lg shadow-lg transform hover:scale-105">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Mon Tableau de Bord
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="px-8 py-4 bg-yellow-400 text-gray-900 rounded-lg hover:bg-yellow-300 transition duration-300 font-bold text-lg shadow-lg transform hover:scale-105">
                            <i class="fas fa-rocket mr-2"></i>
                            Commencer Maintenant
                        </a>
                    @endif
                    <a href="#qcms" 
                       class="px-8 py-4 border-2 border-white text-white rounded-lg hover:bg-white hover:text-blue-600 transition duration-300 font-bold text-lg">
                        <i class="fas fa-list-alt mr-2"></i>
                        Voir les QCM
                    </a>
                </div>
            </div>
        </div>
        <!-- Animated Background Elements -->
        <div class="absolute top-10 left-10 w-20 h-20 bg-yellow-400 rounded-full opacity-20 animate-bounce"></div>
        <div class="absolute bottom-10 right-10 w-16 h-16 bg-pink-400 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute top-1/2 left-20 w-12 h-12 bg-green-400 rounded-full opacity-20 animate-ping"></div>
    </section>

    <!-- FEATURES SECTION -->
    <section id="features" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    Pourquoi choisir notre plateforme ?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Découvrez les fonctionnalités qui font de notre plateforme l'outil idéal pour vos évaluations
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="text-center group hover:shadow-2xl transition duration-500 p-8 rounded-2xl border border-gray-100">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-500 transition duration-300">
                        <i class="fas fa-stopwatch text-3xl text-blue-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Chronométrage Intelligent</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Système de timer avancé avec alertes visuelles pour une gestion optimale du temps
                    </p>
                </div>
                
                <div class="text-center group hover:shadow-2xl transition duration-500 p-8 rounded-2xl border border-gray-100">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-green-500 transition duration-300">
                        <i class="fas fa-chart-line text-3xl text-green-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Suivi de Performances</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Analyses détaillées de vos résultats avec graphiques et statistiques personnalisées
                    </p>
                </div>
                
                <div class="text-center group hover:shadow-2xl transition duration-500 p-8 rounded-2xl border border-gray-100">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-purple-500 transition duration-300">
                        <i class="fas fa-mobile-alt text-3xl text-purple-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Design Responsive</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Interface adaptée à tous les écrans pour une expérience optimale sur mobile et desktop
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- STATISTICS SECTION -->
    <section class="py-20 bg-gradient-to-r from-gray-800 to-gray-900 text-white">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div class="group">
                    <div class="text-4xl font-bold text-yellow-400 mb-2 group-hover:scale-110 transition duration-300">
                        {{ $stats['total_qcms'] ?? 0 }}
                    </div>
                    <div class="text-gray-300">QCM Disponibles</div>
                </div>
                <div class="group">
                    <div class="text-4xl font-bold text-green-400 mb-2 group-hover:scale-110 transition duration-300">
                        {{ $stats['total_users'] ?? 0 }}
                    </div>
                    <div class="text-gray-300">Utilisateurs Actifs</div>
                </div>
                <div class="group">
                    <div class="text-4xl font-bold text-blue-400 mb-2 group-hover:scale-110 transition duration-300">
                        {{ $stats['total_questions'] ?? 0 }}
                    </div>
                    <div class="text-gray-300">Questions Disponibles</div>
                </div>
                <div class="group">
                    <div class="text-4xl font-bold text-purple-400 mb-2 group-hover:scale-110 transition duration-300">
                        {{ $stats['completion_rate'] ?? 0 }}%
                    </div>
                    <div class="text-gray-300">Taux de Réussite</div>
                </div>
            </div>
        </div>
    </section>

    <!-- QCM DISPONIBLES SECTION -->
    <section id="qcms" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    QCM Disponibles
                </h2>
                <p class="text-xl text-gray-600">
                    Découvrez notre sélection de questionnaires dans différents domaines
                </p>
            </div>

            @if(isset($availableQcms) && $availableQcms->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                    @foreach($availableQcms->take(6) as $qcm)
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-lg hover:shadow-2xl transition duration-500 overflow-hidden group">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-medium">
                                        {{ $qcm->questions->count() ?? 0 }} questions
                                    </span>
                                    <div class="text-gray-400">
                                        <i class="fas fa-clock"></i>
                                        <span class="text-sm ml-1">30 min</span>
                                    </div>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-blue-600 transition duration-300">
                                    {{ $qcm->titre }}
                                </h3>
                                
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ Str::limit($qcm->description, 120) ?: 'Testez vos connaissances avec ce QCM interactif et obtenez un feedback immédiat sur vos performances.' }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-user-tie mr-1"></i>
                                        {{ $qcm->enseignant->name ?? 'Enseignant' }}
                                    </div>
                                    <a href="{{ auth()->check() ? route('qcm.take', $qcm->id) : route('login') }}" 
                                       class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 font-medium group-hover:shadow-lg transform group-hover:scale-105">
                                        <i class="fas fa-play mr-2"></i>
                                        Commencer
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-12">
                    <a href="{{ auth()->check() ? route('qcm.available') : route('login') }}" 
                       class="px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 font-bold text-lg shadow-lg inline-block">
                        <i class="fas fa-list mr-2"></i>
                        Voir Tous les QCM
                    </a>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-600 mb-2">Aucun QCM disponible</h3>
                    <p class="text-gray-500 mb-8">Les QCM seront bientôt disponibles. Revenez plus tard !</p>
                    <a href="{{ route('register') }}" 
                       class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 font-medium">
                        S'inscrire pour être notifié
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">
                Prêt à commencer votre évaluation ?
            </h2>
            <p class="text-xl mb-8 text-blue-100 max-w-2xl mx-auto">
                Rejoignez des milliers d'étudiants qui utilisent déjà notre plateforme pour améliorer leurs compétences
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if(auth()->check())
                    <a href="{{ route('qcm.available') }}" 
                       class="px-8 py-4 bg-yellow-400 text-gray-900 rounded-lg hover:bg-yellow-300 transition duration-300 font-bold text-lg shadow-lg">
                        <i class="fas fa-play-circle mr-2"></i>
                        Passer un QCM
                    </a>
                @else
                    <a href="{{ route('register') }}" 
                       class="px-8 py-4 bg-yellow-400 text-gray-900 rounded-lg hover:bg-yellow-300 transition duration-300 font-bold text-lg shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer un compte
                    </a>
                    <a href="{{ route('login') }}" 
                       class="px-8 py-4 border-2 border-white text-white rounded-lg hover:bg-white hover:text-blue-600 transition duration-300 font-bold text-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Se connecter
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 text-2xl font-bold text-blue-400 mb-4">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Mon Espace QCM</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed max-w-md">
                        Une plateforme moderne et intuitive pour l'évaluation en ligne. 
                        Développez vos compétences avec nos QCM interactifs et suivez vos progrès en temps réel.
                    </p>
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg mb-4">Liens Rapides</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-400 hover:text-white transition duration-300">Fonctionnalités</a></li>
                        <li><a href="#qcms" class="text-gray-400 hover:text-white transition duration-300">QCM Disponibles</a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition duration-300">S'inscrire</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition duration-300">Se connecter</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Politique de confidentialité</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-8 text-center text-gray-400">
                <p>© {{ date('Y') }} Mon Espace QCM - Tous droits réservés. Développé avec ❤️ pour l'éducation.</p>
            </div>
        </div>
    </footer>

    <!-- Success Alert -->
    @if(session('success'))
    <div id="success-alert" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-2xl z-50 transform translate-x-full transition-transform duration-300">
        <div class="flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => alert.classList.remove('translate-x-full'), 100);
                setTimeout(() => alert.classList.add('translate-x-full'), 5000);
            }
        });
    </script>
    @endif

    <!-- Error Alert -->
    @if(session('error'))
    <div id="error-alert" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-2xl z-50 transform translate-x-full transition-transform duration-300">
        <div class="flex items-center gap-2">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('error-alert');
            if (alert) {
                setTimeout(() => alert.classList.remove('translate-x-full'), 100);
                setTimeout(() => alert.classList.add('translate-x-full'), 5000);
            }
        });
    </script>
    @endif

    <!-- Smooth Scroll -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Parallax Effect for Hero Section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-parallax');
            if (parallax) {
                const speed = scrolled * 0.5;
                parallax.style.transform = `translateY(${speed}px)`;
            }
        });
    </script>
</body>
</html>
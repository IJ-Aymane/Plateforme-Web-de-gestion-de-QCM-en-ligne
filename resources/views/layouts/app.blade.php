<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Espace QCM')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Navigation Bar - Tailwind Only -->
    <nav class="bg-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard.student') }}" class="flex items-center space-x-2">
                        <i class="fas fa-graduation-cap text-yellow-300"></i>
                        <span class="font-bold text-xl">Mon Espace QCM</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    @auth
                        @if(Auth::user()->role === 'etudiant')
                            <a href="{{ route('dashboard.student') }}" class="hover:text-yellow-300 transition-colors flex items-center space-x-1">
                                <i class="fas fa-home"></i>
                                <span>Tableau de bord</span>
                            </a>
                            <a href="{{ route('qcm.available') }}" class="hover:text-yellow-300 transition-colors flex items-center space-x-1">
                                <i class="fas fa-list"></i>
                                <span>QCM Disponibles</span>
                            </a>
                            <a href="{{ route('student.results') }}" class="hover:text-yellow-300 transition-colors flex items-center space-x-1">
                                <i class="fas fa-chart-line"></i>
                                <span>Mes Résultats</span>
                            </a>
                        @else
                            <a href="{{ route('dashboard.admin') }}" class="hover:text-yellow-300 transition-colors flex items-center space-x-1">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard Admin</span>
                            </a>
                            <a href="{{ route('admin.qcm.index') }}" class="hover:text-yellow-300 transition-colors flex items-center space-x-1">
                                <i class="fas fa-list"></i>
                                <span>Gérer QCM</span>
                            </a>
                        @endif

                        <!-- User Dropdown -->
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                <i class="fas fa-user"></i>
                                <span class="text-sm">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 flex items-center space-x-2">
                                    <i class="fas fa-user-edit"></i>
                                    <span>Profil</span>
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 flex items-center space-x-2">
                                    @csrf
                                    <button type="submit" class="flex items-center space-x-2 w-full text-left">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Déconnexion</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-yellow-300 transition-colors flex items-center space-x-1">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Connexion</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden bg-blue-700 text-white shadow-lg hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                @auth
                    @if(Auth::user()->role === 'etudiant')
                        <a href="{{ route('dashboard.student') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600 flex items-center space-x-2">
                            <i class="fas fa-home"></i>
                            <span>Tableau de bord</span>
                        </a>
                        <a href="{{ route('qcm.available') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600 flex items-center space-x-2">
                            <i class="fas fa-list"></i>
                            <span>QCM Disponibles</span>
                        </a>
                        <a href="{{ route('student.results') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600 flex items-center space-x-2">
                            <i class="fas fa-chart-line"></i>
                            <span>Mes Résultats</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard.admin') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600 flex items-center space-x-2">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard Admin</span>
                        </a>
                        <a href="{{ route('admin.qcm.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600 flex items-center space-x-2">
                            <i class="fas fa-list"></i>
                            <span>Gérer QCM</span>
                        </a>
                    @endif

                    <!-- Mobile User Menu -->
                    <div class="border-t border-blue-600 pt-4 mt-2">
                        <div class="flex items-center px-3 py-2 space-x-2">
                            <i class="fas fa-user"></i>
                            <span class="text-sm">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                        </div>
                        <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600 flex items-center space-x-2">
                            <i class="fas fa-user-edit"></i>
                            <span>Profil</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600 flex items-center space-x-2">
                            @csrf
                            <button type="submit" class="flex items-center space-x-2 w-full text-left">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600 flex items-center space-x-2">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Connexion</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 py-3 mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2 text-green-600"></i>
                    <strong class="font-medium">{{ session('success') }}</strong>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 py-3 mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>
                    <strong class="font-medium">{{ session('error') }}</strong>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="max-w-7xl mx-auto px-4 py-3 mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle mr-2 mt-0.5 text-red-600"></i>
                    <div>
                        <strong class="font-medium">Erreurs de validation :</strong>
                        <ul class="mt-1 list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="mb-2">&copy; {{ date('Y') }} Mon Espace QCM. Tous droits réservés.</p>
            <p class="text-sm text-gray-400">
                <i class="fas fa-code mr-1"></i>
                Développé avec Laravel & Tailwind CSS
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

    @yield('scripts')

    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-button').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // User Dropdown Toggle
        document.getElementById('user-menu-button').addEventListener('click', () => {
            document.getElementById('user-menu').classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', (e) => {
            const userMenu = document.getElementById('user-menu');
            const userButton = document.getElementById('user-menu-button');
            if (userMenu && !userMenu.contains(e.target) && !userButton.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
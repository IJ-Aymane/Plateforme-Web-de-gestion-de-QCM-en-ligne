@extends('layouts.app')

@section('title', 'Tableau de Bord - Administration')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-3xl font-bold text-gray-900">
                            <i class="fas fa-tachometer-alt text-blue-600 mr-3"></i>
                            Tableau de Bord Admin
                        </h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-500">
                        Connecté en tant que: <span class="font-semibold text-gray-900">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                    </div>
                    <div class="h-8 w-px bg-gray-300"></div>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Déconnexion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Total Users Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-users text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Utilisateurs</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ \App\Models\User::where('role', '!=', 'admin')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.users') }}" class="font-medium text-blue-700 hover:text-blue-900">
                            Gérer les utilisateurs
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total QCMs Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-question-circle text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total QCMs</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ \App\Models\Qcm::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.qcms') }}" class="font-medium text-green-700 hover:text-green-900">
                            Gérer les QCMs
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Results Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-chart-bar text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Résultats</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ \App\Models\Resultat::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.results') }}" class="font-medium text-yellow-700 hover:text-yellow-900">
                            Voir les résultats
                        </a>
                    </div>
                </div>
            </div>

            <!-- Teachers Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Enseignants</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ \App\Models\User::where('role', 'enseignant')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-purple-700">
                            {{ \App\Models\User::where('role', 'etudiant')->count() }} Étudiants
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                    Actions Rapides
                </h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <a href="{{ route('admin.users.create') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer Utilisateur
                    </a>
                    <a href="{{ route('admin.users') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-users mr-2"></i>
                        Gérer Utilisateurs
                    </a>
                    <a href="{{ route('admin.qcms') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <i class="fas fa-question-circle mr-2"></i>
                        Gérer QCMs
                    </a>
                    <a href="{{ route('admin.results') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                        <i class="fas fa-chart-line mr-2"></i>
                        Voir Résultats
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <!-- Recent Users -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        <i class="fas fa-user-clock text-blue-500 mr-2"></i>
                        Utilisateurs Récents
                    </h3>
                    <div class="space-y-3">
                        @forelse(\App\Models\User::where('role', '!=', 'admin')->latest()->limit(5)->get() as $user)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-600 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $user->prenom }} {{ $user->nom }}</p>
                                        <p class="text-xs text-gray-500">{{ ucfirst($user->role) }}</p>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Aucun utilisateur trouvé.</p>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.users') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            Voir tous les utilisateurs →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent QCMs -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        <i class="fas fa-clock text-green-500 mr-2"></i>
                        QCMs Récents
                    </h3>
                    <div class="space-y-3">
                        @forelse(\App\Models\Qcm::with('enseignant')->latest()->limit(5)->get() as $qcm)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-question text-green-600 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($qcm->titre, 30) }}</p>
                                        <p class="text-xs text-gray-500">par {{ $qcm->enseignant->prenom ?? 'N/A' }} {{ $qcm->enseignant->nom ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $qcm->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Aucun QCM trouvé.</p>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.qcms') }}" class="text-sm font-medium text-green-600 hover:text-green-500">
                            Voir tous les QCMs →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="mt-8 bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    <i class="fas fa-info-circle text-indigo-500 mr-2"></i>
                    Informations Système
                </h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('role', 'etudiant')->count() }}</div>
                        <div class="text-sm text-gray-500">Étudiants actifs</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('role', 'enseignant')->count() }}</div>
                        <div class="text-sm text-gray-500">Enseignants actifs</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Qcm::count() }}</div>
                        <div class="text-sm text-gray-500">QCMs créés</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Resultat::count() }}</div>
                        <div class="text-sm text-gray-500">Tests complétés</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.transition-colors {
    transition-property: color, background-color, border-color;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

.hover\:bg-blue-700:hover {
    background-color: #1d4ed8;
}

.hover\:bg-red-700:hover {
    background-color: #b91c1c;
}

.hover\:bg-gray-50:hover {
    background-color: #f9fafb;
}

.focus\:ring-2:focus {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

.focus\:ring-offset-2:focus {
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(59, 130, 246, 0.5);
}
</style>
@endsection
@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs - Administration')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">
                        <i class="fas fa-users text-blue-600 mr-3"></i>
                        Gestion des Utilisateurs
                    </h1>
                </div>
                <a href="{{ route('admin.users.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-user-plus mr-2"></i>
                    Créer Utilisateur
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
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

        @if(session('error') || $errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        @if(session('error'))
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        @endif
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <p class="text-sm font-medium text-red-800">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
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
                                <dd class="text-lg font-medium text-gray-900">{{ $users->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Étudiants</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ \App\Models\User::where('role', 'etudiant')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

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
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Liste des Utilisateurs
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Gérez tous les utilisateurs de la plateforme
                </p>
            </div>
            
            @if($users->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-{{ $user->role === 'enseignant' ? 'purple' : 'blue' }}-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-{{ $user->role === 'enseignant' ? 'chalkboard-teacher' : 'user-graduate' }} text-{{ $user->role === 'enseignant' ? 'purple' : 'blue' }}-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $user->prenom }} {{ $user->nom }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $user->role === 'enseignant' ? 'purple' : 'blue' }}-100 text-{{ $user->role === 'enseignant' ? 'purple' : 'blue' }}-800">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <div class="text-sm text-gray-500">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </div>
                                    
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        <i class="fas fa-edit mr-1"></i>
                                        Modifier
                                    </a>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action supprimera également tous ses QCMs et résultats.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                            <i class="fas fa-trash mr-1"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $users->links() }}
                </div>
            @else
                <div class="px-4 py-12 text-center">
                    <i class="fas fa-users text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun utilisateur trouvé</h3>
                    <p class="text-gray-500 mb-6">Commencez par créer votre premier utilisateur.</p>
                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer un utilisateur
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
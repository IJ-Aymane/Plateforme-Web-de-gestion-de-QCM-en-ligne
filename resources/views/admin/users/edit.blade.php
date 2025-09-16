@extends('layouts.app')

@section('title', 'Modifier un Utilisateur - Administration')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <a href="{{ route('admin.users') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">
                        <i class="fas fa-user-edit text-blue-600 mr-3"></i>
                        Modifier un Utilisateur
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Error Messages -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Erreurs de validation :</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Edit User Form -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Personal Information Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-user text-blue-600 mr-2"></i>
                            Informations Personnelles
                        </h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- First Name -->
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700">
                                    Prénom <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="prenom" 
                                       id="prenom" 
                                       value="{{ old('prenom', $user->prenom) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('prenom') border-red-300 @enderror"
                                       required>
                                @error('prenom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">
                                    Nom <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nom" 
                                       id="nom" 
                                       value="{{ old('nom', $user->nom) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nom') border-red-300 @enderror"
                                       required>
                                @error('nom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Account Information Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-envelope text-green-600 mr-2"></i>
                            Informations de Compte
                        </h3>
                        
                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $user->email) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 @enderror"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="mb-6">
                            <label for="role" class="block text-sm font-medium text-gray-700">
                                Rôle <span class="text-red-500">*</span>
                            </label>
                            <select name="role" 
                                    id="role" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-300 @enderror"
                                    required>
                                <option value="etudiant" {{ old('role', $user->role) == 'etudiant' ? 'selected' : '' }}>
                                    Étudiant
                                </option>
                                <option value="enseignant" {{ old('role', $user->role) == 'enseignant' ? 'selected' : '' }}>
                                    Enseignant
                                </option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-key text-yellow-600 mr-2"></i>
                            Modifier le Mot de Passe (Optionnel)
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Laissez ces champs vides si vous ne souhaitez pas changer le mot de passe.
                        </p>
                        
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Nouveau mot de passe
                                </label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-300 @enderror">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Minimum 8 caractères</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    Confirmer le nouveau mot de passe
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- User Statistics -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-chart-bar text-purple-600 mr-2"></i>
                            Statistiques de l'Utilisateur
                        </h3>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            @if($user->role === 'enseignant')
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <div class="text-lg font-semibold text-green-800">
                                        {{ $user->qcms->count() }}
                                    </div>
                                    <div class="text-sm text-green-600">QCMs créés</div>
                                </div>
                            @else
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="text-lg font-semibold text-blue-800">
                                        {{ $user->resultats->count() }}
                                    </div>
                                    <div class="text-sm text-blue-600">Tests passés</div>
                                </div>
                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <div class="text-lg font-semibold text-yellow-800">
                                        {{ $user->resultats->avg('score') ? number_format($user->resultats->avg('score'), 1) . '%' : 'N/A' }}
                                    </div>
                                    <div class="text-sm text-yellow-600">Score moyen</div>
                                </div>
                            @endif
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-lg font-semibold text-gray-800">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </div>
                                <div class="text-sm text-gray-600">Date d'inscription</div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.users') }}" 
                               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-times mr-2"></i>
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-save mr-2"></i>
                                Mettre à jour
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
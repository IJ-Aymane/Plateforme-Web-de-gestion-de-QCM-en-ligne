

@section('title', 'Créer un Utilisateur - Administration')

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
                        <i class="fas fa-user-plus text-blue-600 mr-3"></i>
                        Créer un Utilisateur
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

        <!-- Create User Form -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                    @csrf

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
                                       value="{{ old('prenom') }}"
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
                                       value="{{ old('nom') }}"
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
                                   value="{{ old('email') }}"
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
                                <option value="">Sélectionner un rôle</option>
                                <option value="etudiant" {{ old('role') == 'etudiant' ? 'selected' : '' }}>
                                    <i class="fas fa-user-graduate"></i> Étudiant
                                </option>
                                <option value="enseignant" {{ old('role') == 'enseignant' ? 'selected' : '' }}>
                                    <i class="fas fa-chalkboard-teacher"></i> Enseignant
                                </option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Mot de passe <span class="text-red-500">*</span>
                                </label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-300 @enderror"
                                       required>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Minimum 8 caractères</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    Confirmer le mot de passe <span class="text-red-500">*</span>
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
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
                                Créer l'utilisateur
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Information</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>Étudiants</strong> : Peuvent passer des tests et voir leurs résultats</li>
                            <li><strong>Enseignants</strong> : Peuvent créer des QCMs et voir les résultats de leurs étudiants</li>
                            <li>L'utilisateur recevra ses identifiants par email après la création du compte</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Show role-specific information
    document.getElementById('role').addEventListener('change', function() {
        const roleInfo = document.getElementById('role-info');
        const role = this.value;
        
        if (role === 'etudiant') {
            roleInfo.innerHTML = '<i class="fas fa-info-circle text-blue-500 mr-1"></i> Les étudiants peuvent passer des tests et consulter leurs résultats.';
            roleInfo.className = 'mt-2 text-sm text-blue-600';
        } else if (role === 'enseignant') {
            roleInfo.innerHTML = '<i class="fas fa-info-circle text-purple-500 mr-1"></i> Les enseignants peuvent créer des QCMs et gérer les résultats.';
            roleInfo.className = 'mt-2 text-sm text-purple-600';
        } else {
            roleInfo.innerHTML = '';
        }
    });
</script>
@endsection
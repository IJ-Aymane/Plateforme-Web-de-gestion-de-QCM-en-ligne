<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'Utilisateur - Mon Espace QCM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .spinner {
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            width: 16px;
            height: 16px;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-bg-light text-text font-sans">

    <div class="min-h-screen">
        {{-- Header --}}
        <header class="bg-white shadow-sm border-b border-border">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-3">
                        <i data-lucide="graduation-cap" class="h-8 w-8 text-primary"></i>
                        <h1 class="text-xl font-bold text-gray-900">Mon Espace QCM</h1>
                    </div>
                    <nav class="flex items-center gap-4">
                        <a href="#" class="text-text-muted hover:text-primary transition">Tableau de bord</a>
                        <a href="{{ route('users.index') }}" class="text-primary font-medium">Utilisateurs</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-text-muted hover:text-red-600 transition">
                                <i data-lucide="log-out" class="h-5 w-5"></i>
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
        </header>

        {{-- Contenu principal --}}
        <main class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            
            {{-- Navigation de retour --}}
            <div class="mb-6">
                <a href="{{ route('users.index') }}" 
                   class="inline-flex items-center gap-2 text-primary hover:text-primary-dark transition">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Retour à la liste
                </a>
            </div>

            {{-- Formulaire --}}
            <div class="bg-white rounded-xl shadow-sm border border-border p-8">
                
                {{-- En-tête --}}
                <div class="mb-8 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 bg-primary bg-opacity-10 rounded-full">
                            <i data-lucide="edit" class="h-8 w-8 text-primary"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Modifier l'utilisateur</h2>
                    <p class="mt-2 text-text-muted">{{ $user->name }} ({{ $user->email }})</p>
                </div>

                {{-- Messages d'erreurs --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <i data-lucide="alert-circle" class="h-5 w-5 text-red-600 mt-0.5"></i>
                            <div>
                                <h4 class="text-red-800 font-medium mb-2">Veuillez corriger les erreurs suivantes :</h4>
                                <ul class="list-disc pl-5 text-red-700 text-sm space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Formulaire --}}
                <form id="edit-form" action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nom complet --}}
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-lucide="user" class="h-4 w-4 inline mr-1"></i>
                                Nom complet
                            </label>
                            <input id="name" name="name" type="text" required 
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary @error('name') border-red-500 @else border-border @enderror">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-lucide="mail" class="h-4 w-4 inline mr-1"></i>
                                Adresse e-mail
                            </label>
                            <input id="email" name="email" type="email" required 
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary @error('email') border-red-500 @else border-border @enderror">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Rôle --}}
                        <div class="md:col-span-2">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-lucide="shield" class="h-4 w-4 inline mr-1"></i>
                                Rôle
                            </label>
                            <select id="role" name="role" required
                                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary @error('role') border-red-500 @else border-border @enderror">
                                <option value="">Sélectionnez un rôle</option>
                                <option value="enseignant" {{ old('role', $user->role) == 'enseignant' ? 'selected' : '' }}>
                                    Enseignant
                                </option>
                                <option value="etudiant" {{ old('role', $user->role) == 'etudiant' ? 'selected' : '' }}>
                                    Étudiant
                                </option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Section mot de passe --}}
                        <div class="md:col-span-2">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <div class="flex items-start gap-2">
                                    <i data-lucide="info" class="h-5 w-5 text-yellow-600 mt-0.5"></i>
                                    <div class="text-yellow-800 text-sm">
                                        <p class="font-medium mb-1">Modification du mot de passe</p>
                                        <p>Laissez les champs vides si vous ne souhaitez pas modifier le mot de passe actuel.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Nouveau mot de passe --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-lucide="lock" class="h-4 w-4 inline mr-1"></i>
                                Nouveau mot de passe
                            </label>
                            <div class="relative">
                                <input id="password" name="password" type="password"
                                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary @error('password') border-red-500 @else border-border @enderror"
                                       placeholder="Laissez vide pour conserver l'actuel">
                                <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500" 
                                        onclick="togglePassword('password')">
                                    <i data-lucide="eye" class="h-5 w-5"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirmation nouveau mot de passe --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-lucide="lock" class="h-4 w-4 inline mr-1"></i>
                                Confirmer le nouveau mot de passe
                            </label>
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                       placeholder="Confirmation du nouveau mot de passe">
                                <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500" 
                                        onclick="togglePassword('password_confirmation')">
                                    <i data-lucide="eye" class="h-5 w-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Informations supplémentaires --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Informations du compte</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Date de création :</span>
                                <span class="font-medium">{{ $user->created_at->format('d/m/Y à H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Dernière modification :</span>
                                <span class="font-medium">{{ $user->updated_at->format('d/m/Y à H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Boutons d'action --}}
                    <div class="flex items-center justify-between pt-6 border-t border-border">
                        <div class="flex items-center gap-4">
                            <a href="{{ route('users.index') }}" 
                               class="px-6 py-3 border border-border text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                Annuler
                            </a>
                            <button type="submit" id="submit-button"
                                    class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition disabled:opacity-50">
                                <i data-lucide="save" class="h-4 w-4"></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                        
                        {{-- Bouton de suppression --}}
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="flex items-center gap-2 px-4 py-3 text-red-600 border border-red-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition">
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                field.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        const form = document.getElementById('edit-form');
        const submitButton = document.getElementById('submit-button');
        
        form.addEventListener('submit', function() {
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <div class="spinner"></div>
                <span>Modification en cours...</span>
            `;
        });
    </script>
</body>
</html>
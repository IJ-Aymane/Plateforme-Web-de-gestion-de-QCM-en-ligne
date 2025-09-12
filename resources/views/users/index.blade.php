<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - Mon Espace QCM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            
            {{-- En-tête de la page --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Gestion des Utilisateurs</h2>
                        <p class="mt-2 text-text-muted">Gérez les comptes enseignants et étudiants</p>
                    </div>
                    <a href="{{ route('users.create') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                        <i data-lucide="plus" class="h-5 w-5"></i>
                        Nouvel utilisateur
                    </a>
                </div>
            </div>

            {{-- Messages de succès --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-green-800">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="h-5 w-5"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Tableau des utilisateurs --}}
            <div class="bg-white rounded-xl shadow-sm border border-border overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rôle
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date d'inscription
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-border">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
                                                    <i data-lucide="user" class="h-5 w-5 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->nom }} {{ $user->prenom }}</div>
                                                <div class="text-sm text-text-muted">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($user->role === 'enseignant') bg-blue-100 text-blue-800 
                                            @else bg-green-100 text-green-800 @endif">
                                            @if($user->role === 'enseignant')
                                                <i data-lucide="graduation-cap" class="h-3 w-3 mr-1"></i>
                                                Enseignant
                                            @else
                                                <i data-lucide="user" class="h-3 w-3 mr-1"></i>
                                                Étudiant
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-text-muted">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('users.edit', $user) }}" 
                                               class="text-primary hover:text-primary-dark transition p-2 rounded-lg hover:bg-gray-100">
                                                <i data-lucide="edit" class="h-4 w-4"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800 transition p-2 rounded-lg hover:bg-red-50">
                                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-text-muted">
                                        <div class="flex flex-col items-center gap-2">
                                            <i data-lucide="users" class="h-8 w-8"></i>
                                            <p>Aucun utilisateur trouvé</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-border">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
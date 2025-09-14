<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard Enseignantistrateur - Mon Espace QCM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-light text-text font-sans flex">

    <aside class="w-64 bg-white border-r border-border flex flex-col h-screen sticky top-0">
        <div class="flex items-center gap-2 text-xl font-bold text-primary h-16 border-b border-border px-6">
            <i data-lucide="graduation-cap" class="h-6 w-6"></i>
            <span>Mon Espace QCM</span>
        </div>
        
        <nav class="flex-1 px-4 py-4">
            <a href="{{ route('dashboard.Enseignant') }}" class="flex items-center gap-3 px-4 py-2 text-white bg-primary rounded-lg font-medium">
                <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="{{ route('qcm.index') }}" class="flex items-center gap-3 px-4 py-2 text-text-muted hover:bg-bg-light rounded-lg transition mt-2">
                <i data-lucide="file-text" class="h-5 w-5"></i>
                <span>Gestion des QCM</span>
            </a>

            <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-2 text-text-muted hover:bg-bg-light rounded-lg transition mt-2">
                <i data-lucide="settings" class="h-5 w-5"></i>
                <span>Paramètres</span>
            </a>
        </nav>
        
        <div class="px-4 py-4 border-t border-border">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition w-full text-left">
                    <i data-lucide="log-out" class="h-5 w-5"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1">
        <header class="bg-white shadow-sm border-b border-border h-16 flex items-center justify-between px-8 sticky top-0">
            <div class="relative">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-text-muted"></i>
                <input type="text" placeholder="Rechercher un QCM, un utilisateur..." class="bg-bg-light border border-border rounded-lg pl-10 pr-4 py-2 w-80 focus:ring-2 focus:ring-primary focus:outline-none">
            </div>
            
            <div class="flex items-center gap-4">
                 <button class="text-text-muted hover:text-primary">
                    <i data-lucide="bell" class="h-6 w-6"></i>
                </button>
                <div class="flex items-center gap-3">
                    <!-- ✅ Avatar avec initiales "AI" -->
                    <img src="https://ui-avatars.com/api/?name=Aymane+Ihdj&background=0D8ABC&color=fff&size=40" 
                         alt="Avatar" 
                         class="h-10 w-10 rounded-full">
                    <div>
                        <div class="font-semibold">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                        <div class="text-sm text-text-muted">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-primary">Tableau de Bord</h1>
                <div class="text-sm text-text-muted">
                    Dernière connexion : {{ Auth::user()->updated_at->format('d/m/Y à H:i') }}
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl border border-border shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-primary-light"><i data-lucide="users" class="w-7 h-7 text-primary"></i></div>
                        <div>
                            <div class="text-3xl font-bold text-primary">{{ $totalStudents ?? 0 }}</div>
                            <div class="text-text-muted">Étudiants inscrits</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-border shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-secondary-light"><i data-lucide="file-text" class="w-7 h-7 text-secondary"></i></div>
                        <div>
                            <div class="text-3xl font-bold text-secondary">{{ $totalQcm ?? 0 }}</div>
                            <div class="text-text-muted">QCM créés</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-border shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-green-100"><i data-lucide="check-circle-2" class="w-7 h-7 text-green-600"></i></div>
                        <div>
                            <div class="text-3xl font-bold text-green-600">{{ number_format($averageScore ?? 0, 1) }}%</div>
                            <div class="text-text-muted">Score moyen</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-border shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-yellow-100"><i data-lucide="message-square-plus" class="w-7 h-7 text-yellow-600"></i></div>
                        <div>
                            <div class="text-3xl font-bold text-yellow-600">{{ $totalQuestions ?? 0 }}</div>
                            <div class="text-text-muted">Questions créées</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent QCM Table -->
            <div class="bg-white rounded-xl border border-border shadow-sm">
                <div class="p-6 flex justify-between items-center border-b border-border">
                    <h3 class="text-xl font-semibold text-primary">Mes QCM Récents</h3>
                    <a href="{{ route('qcm.create') }}" class="bg-primary text-white py-2 px-4 rounded-lg font-semibold hover:bg-primary-dark transition text-sm">
                        <i data-lucide="plus" class="inline h-4 w-4 mr-1"></i> Créer un QCM
                    </a>
                </div>
                <div class="p-6">
                    @if(isset($recentQcm) && $recentQcm->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-border text-text-muted text-sm">
                                    <th class="py-3">Titre du QCM</th>
                                    <th class="py-3">Description</th>
                                    <th class="py-3">Questions</th>
                                    <th class="py-3">Tentatives</th>
                                    <th class="py-3">Date de création</th>
                                    <th class="py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentQcm as $qcm)
                                <tr class="border-b border-border">
                                    <td class="py-4 font-medium">{{ $qcm->titre }}</td>
                                    <td class="py-4 text-sm text-text-muted">{{ Str::limit($qcm->description ?? 'Aucune description', 50) }}</td>
                                    <td class="py-4">{{ $qcm->questions_count ?? 0 }}</td>
                                    <td class="py-4">{{ $qcm->resultats_count ?? 0 }}</td>
                                    <td class="py-4">{{ $qcm->created_at->format('d M Y') }}</td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('qcm.show', $qcm->id) }}" class="p-2 hover:bg-bg-light rounded-md" title="Voir">
                                                <i data-lucide="eye" class="h-4 w-4 text-text-muted"></i>
                                            </a>
                                            <a href="{{ route('qcm.edit', $qcm->id) }}" class="p-2 hover:bg-bg-light rounded-md" title="Modifier">
                                                <i data-lucide="pencil" class="h-4 w-4 text-text-muted"></i>
                                            </a>
                                            <form method="POST" action="{{ route('qcm.destroy', $qcm->id) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce QCM ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 hover:bg-bg-light rounded-md" title="Supprimer">
                                                    <i data-lucide="trash-2" class="h-4 w-4 text-red-500"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <i data-lucide="file-text" class="h-12 w-12 text-text-muted mx-auto mb-4"></i>
                        <p class="text-text-muted">Aucun QCM créé pour le moment.</p>
                        <a href="{{ route('qcm.create') }}" class="inline-flex items-center gap-2 mt-4 bg-primary text-white py-2 px-4 rounded-lg font-semibold hover:bg-primary-dark transition">
                            <i data-lucide="plus" class="h-4 w-4"></i> Créer votre premier QCM
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity -->
            @if(isset($recentResults) && $recentResults->count() > 0)
            <div class="mt-8 bg-white rounded-xl border border-border shadow-sm">
                <div class="p-6 border-b border-border">
                    <h3 class="text-xl font-semibold text-primary">Activité Récente</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($recentResults->take(5) as $result)
                        <div class="flex items-center justify-between p-4 bg-bg-light rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-full bg-primary-light">
                                    <i data-lucide="user-check" class="h-4 w-4 text-primary"></i>
                                </div>
                                <div>
                                    <p class="font-medium">{{ $result->etudiant->prenom }} {{ $result->etudiant->nom }}</p>
                                    <p class="text-sm text-text-muted">a complété "{{ $result->qcm->titre }}"</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold {{ $result->score >= ($result->total_questions * 0.7) ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $result->score }}/{{ $result->total_questions }}
                                </div>
                                <div class="text-sm text-text-muted">{{ $result->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </main>
    </div>

    @if(session('success'))
    <div id="success-alert" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('success-alert').style.display = 'none';
        }, 3000);
    </script>
    @endif

    @if(session('error'))
    <div id="error-alert" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('error-alert').style.display = 'none';
        }, 3000);
    </script>
    @endif

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>

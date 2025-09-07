<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrateur - Mon Espace QCM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-light text-text font-sans flex">

    <aside class="w-64 bg-white border-r border-border flex flex-col h-screen sticky top-0">
        <div class="flex items-center gap-2 text-xl font-bold text-primary h-16 border-b border-border px-6">
            <i data-lucide="graduation-cap" class="h-6 w-6"></i>
            <span>Mon Espace QCM</span>
        </div>
        
        <nav class="flex-1 px-4 py-4">
            <a href="#" class="flex items-center gap-3 px-4 py-2 text-white bg-primary rounded-lg font-medium">
                <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 text-text-muted hover:bg-bg-light rounded-lg transition mt-2">
                <i data-lucide="file-text" class="h-5 w-5"></i>
                <span>Gestion des QCM</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 text-text-muted hover:bg-bg-light rounded-lg transition mt-2">
                <i data-lucide="database" class="h-5 w-5"></i>
                <span>Banque de questions</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 text-text-muted hover:bg-bg-light rounded-lg transition mt-2">
                <i data-lucide="users" class="h-5 w-5"></i>
                <span>Utilisateurs</span>
            </a>
             <a href="#" class="flex items-center gap-3 px-4 py-2 text-text-muted hover:bg-bg-light rounded-lg transition mt-2">
                <i data-lucide="bar-chart-2" class="h-5 w-5"></i>
                <span>Résultats & Stats</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 text-text-muted hover:bg-bg-light rounded-lg transition mt-2">
                <i data-lucide="settings" class="h-5 w-5"></i>
                <span>Paramètres</span>
            </a>
        </nav>
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
                    <img src="https://i.pravatar.cc/40" alt="Avatar" class="h-10 w-10 rounded-full">
                    <div>
                        <div class="font-semibold">Admin User</div>
                        <div class="text-sm text-text-muted">Administrateur</div>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-8">
            <h1 class="text-3xl font-bold text-primary mb-6">Tableau de Bord</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl border border-border shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-primary-light"><i data-lucide="users" class="w-7 h-7 text-primary"></i></div>
                        <div>
                            <div class="text-3xl font-bold text-primary">148</div>
                            <div class="text-text-muted">Étudiants inscrits</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-border shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-secondary-light"><i data-lucide="file-text" class="w-7 h-7 text-secondary"></i></div>
                        <div>
                            <div class="text-3xl font-bold text-secondary">32</div>
                            <div class="text-text-muted">QCM actifs</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-border shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-green-100"><i data-lucide="check-circle-2" class="w-7 h-7 text-green-600"></i></div>
                        <div>
                            <div class="text-3xl font-bold text-green-600">78%</div>
                            <div class="text-text-muted">Taux de réussite moyen</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-border shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-yellow-100"><i data-lucide="message-square-plus" class="w-7 h-7 text-yellow-600"></i></div>
                        <div>
                            <div class="text-3xl font-bold text-yellow-600">852</div>
                            <div class="text-text-muted">Questions en banque</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-border shadow-sm">
                <div class="p-6 flex justify-between items-center border-b border-border">
                    <h3 class="text-xl font-semibold text-primary">Derniers QCM Ajoutés</h3>
                    <button class="bg-primary text-white py-2 px-4 rounded-lg font-semibold hover:bg-primary-dark transition text-sm">
                        <i data-lucide="plus" class="inline h-4 w-4 mr-1"></i> Créer un QCM
                    </button>
                </div>
                <div class="p-6">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-border text-text-muted text-sm">
                                <th class="py-3">Titre du QCM</th>
                                <th class="py-3">Matière</th>
                                <th class="py-3">Questions</th>
                                <th class="py-3">Date de création</th>
                                <th class="py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-border">
                                <td class="py-4 font-medium">Introduction à l'Algorithmique</td>
                                <td>Informatique</td>
                                <td>20</td>
                                <td>03 Sep 2025</td>
                                <td class="text-right">
                                    <button class="p-2 hover:bg-bg-light rounded-md"><i data-lucide="pencil" class="h-4 w-4 text-text-muted"></i></button>
                                    <button class="p-2 hover:bg-bg-light rounded-md"><i data-lucide="trash-2" class="h-4 w-4 text-red-500"></i></button>
                                </td>
                            </tr>
                            <tr class="border-b border-border">
                                <td class="py-4 font-medium">Biologie Cellulaire - Chapitre 1</td>
                                <td>Biologie</td>
                                <td>15</td>
                                <td>01 Sep 2025</td>
                                <td class="text-right">
                                    <button class="p-2 hover:bg-bg-light rounded-md"><i data-lucide="pencil" class="h-4 w-4 text-text-muted"></i></button>
                                    <button class="p-2 hover:bg-bg-light rounded-md"><i data-lucide="trash-2" class="h-4 w-4 text-red-500"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 font-medium">Histoire de la Révolution Française</td>
                                <td>Histoire</td>
                                <td>25</td>
                                <td>30 Août 2025</td>
                                <td class="text-right">
                                    <button class="p-2 hover:bg-bg-light rounded-md"><i data-lucide="pencil" class="h-4 w-4 text-text-muted"></i></button>
                                    <button class="p-2 hover:bg-bg-light rounded-md"><i data-lucide="trash-2" class="h-4 w-4 text-red-500"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
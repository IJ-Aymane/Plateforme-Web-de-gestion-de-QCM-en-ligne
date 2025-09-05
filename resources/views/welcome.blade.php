<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QCM Platform - Plateforme de Quiz en Ligne</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.js"></script>
</head>
<body class="bg-bg-light font-sans text-text antialiased">

    <header class="bg-surface sticky top-0 z-50 border-b border-border shadow-sm">
        <div class="container mx-auto px-4">
            <nav class="flex h-16 items-center justify-between">
                <a href="#" class="flex items-center gap-2 text-xl font-bold text-primary">
                    <i data-lucide="brain" class="h-6 w-6"></i>
                    <span>QCM Platform</span>
                </a>
                <ul class="hidden items-center space-x-8 md:flex">
                    <li><a href="#accueil" class="font-medium text-text transition-colors hover:text-primary">Accueil</a></li>
                    <li><a href="#tableau-bord" class="font-medium text-text transition-colors hover:text-primary">Tableau de bord</a></li>
                    <li><a href="#aide" class="font-medium text-text transition-colors hover:text-primary">Aide</a></li>
                    <li><a href="#connexion" class="bg-primary text-white font-semibold py-2 px-5 rounded-lg shadow-sm hover:bg-primary-dark hover:-translate-y-0.5 transition-all">Se connecter</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section id="accueil" class="bg-secondary px-4 py-20 text-center text-white">
            <div class="container mx-auto">
                <h1 class="mb-4 text-4xl font-bold md:text-5xl">Plateforme QCM Interactive</h1>
                <p class="mx-auto mb-8 max-w-2xl text-lg opacity-90 md:text-xl">Créez, gérez et administrez vos quiz en ligne facilement.</p>
                <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <a href="#tableau-bord" class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary py-3 px-6 font-semibold text-white shadow-lg transition-all hover:-translate-y-1 hover:bg-primary-dark sm:w-auto">
                        <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                        Espace Enseignant
                    </a>
                    <a href="#tableau-bord" class="flex w-full items-center justify-center gap-2 rounded-lg border-2 border-primary bg-surface py-3 px-6 font-semibold text-primary transition-all hover:-translate-y-1 hover:bg-primary hover:text-white sm:w-auto">
                        <i data-lucide="user" class="h-5 w-5"></i>
                        Espace Étudiant
                    </a>
                </div>
            </div>
        </section>

        <div id="tableau-bord" class="container mx-auto px-4 py-16">
            <div class="overflow-hidden rounded-xl border border-border bg-surface shadow-lg">
                <div class="flex border-b border-border">
                    <button data-tab-target="dashboard" class="tab active flex-1 border-b-2 border-primary p-4 font-semibold text-primary transition-colors">Tableau de bord</button>
                    <button data-tab-target="create-quiz" class="tab flex-1 border-b-2 border-transparent p-4 font-semibold text-text-muted transition-colors hover:text-primary">Créer un QCM</button>
                    <button data-tab-target="take-quiz" class="tab flex-1 border-b-2 border-transparent p-4 font-semibold text-text-muted transition-colors hover:text-primary">Passer un QCM</button>
                    <button data-tab-target="results" class="tab flex-1 border-b-2 border-transparent p-4 font-semibold text-text-muted transition-colors hover:text-primary">Résultats</button>
                </div>

                <div class="p-6 md:p-8">
                    <div id="dashboard" class="tab-content">
                        <h2 class="mb-6 text-2xl font-bold text-secondary">Tableau de bord</h2>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <div class="rounded-lg border border-border bg-surface p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                                <div class="flex items-center gap-4">
                                    <div class="rounded-lg bg-primary p-3 text-white">
                                        <i data-lucide="file-text" class="h-6 w-6"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-secondary">Créer un nouveau QCM</h3>
                                        <p class="text-sm text-text-muted">Concevez facilement vos questionnaires.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="rounded-lg border border-border bg-surface p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                                <div class="flex items-center gap-4">
                                    <div class="rounded-lg bg-primary p-3 text-white">
                                        <i data-lucide="users" class="h-6 w-6"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-secondary">Gérer les classes</h3>
                                        <p class="text-sm text-text-muted">Organisez vos étudiants par groupes.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="rounded-lg border border-border bg-surface p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                                <div class="flex items-center gap-4">
                                    <div class="rounded-lg bg-primary p-3 text-white">
                                        <i data-lucide="bar-chart-2" class="h-6 w-6"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-secondary">Analyser les résultats</h3>
                                        <p class="text-sm text-text-muted">Consultez les statistiques détaillées.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="create-quiz" class="tab-content hidden">
                        <h2 class="mb-6 text-2xl font-bold text-secondary">Créer un nouveau QCM</h2>
                        <form class="max-w-xl">
                            <div class="space-y-6">
                                <div>
                                    <label for="quiz-title" class="mb-1 block text-sm font-medium text-text-muted">Titre du QCM</label>
                                    <input type="text" id="quiz-title" placeholder="Ex: Évaluation de Mathématiques" class="form-input block w-full rounded-md border-border shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label for="quiz-description" class="mb-1 block text-sm font-medium text-text-muted">Description</label>
                                    <textarea id="quiz-description" rows="3" placeholder="Brève description du contenu du quiz" class="form-textarea block w-full rounded-md border-border shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
                                </div>
                                <button type="submit" class="bg-primary text-white font-semibold py-2 px-5 rounded-lg shadow-sm hover:bg-primary-dark hover:-translate-y-0.5 transition-all">
                                    Enregistrer le QCM
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="take-quiz" class="tab-content hidden">
                        <h2 class="mb-6 text-2xl font-bold text-secondary">Passer un QCM</h2>
                        <p class="text-text-muted">Ici se trouvera l'interface pour que l'étudiant puisse passer un quiz.</p>
                    </div>

                    <div id="results" class="tab-content hidden">
                         <h2 class="mb-6 text-2xl font-bold text-secondary">Résultats et Statistiques</h2>
                         <p class="text-text-muted">Ici s'afficheront les résultats détaillés des quiz passés.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
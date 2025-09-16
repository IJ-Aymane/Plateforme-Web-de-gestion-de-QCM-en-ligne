

@section('title', 'Résultats des Tests - Administration')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">
                        <i class="fas fa-chart-bar text-yellow-600 mr-3"></i>
                        Résultats des Tests
                    </h1>
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

        <!-- Statistics -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
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
                                <dd class="text-lg font-medium text-gray-900">{{ $resultats->total() }}</dd>
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
                                <i class="fas fa-trophy text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Score Moyen</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    @php
                                        $averageScore = \App\Models\Resultat::avg('score');
                                    @endphp
                                    {{ $averageScore ? number_format($averageScore, 1) . '%' : 'N/A' }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

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
                                <dt class="text-sm font-medium text-gray-500 truncate">Étudiants Actifs</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ \App\Models\Resultat::distinct('user_id')->count() }}
                                </dd>
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
                                <i class="fas fa-calendar-day text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Aujourd'hui</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ \App\Models\Resultat::whereDate('created_at', today())->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Liste des Résultats
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Tous les résultats des tests passés par les étudiants
                </p>
            </div>
            
            @if($resultats->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Étudiant
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    QCM
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Score
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Détails
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($resultats as $resultat)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-10 h-10">
                                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-user-graduate text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $resultat->etudiant->prenom ?? 'N/A' }} {{ $resultat->etudiant->nom ?? '' }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $resultat->etudiant->email ?? 'Email non disponible' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-8 h-8">
                                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-question text-green-600 text-xs"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ Str::limit($resultat->qcm->titre ?? 'QCM supprimé', 30) }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    par {{ $resultat->qcm->enseignant->prenom ?? 'N/A' }} {{ $resultat->qcm->enseignant->nom ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @php
                                                $scoreClass = 'text-red-600';
                                                $iconClass = 'fas fa-times-circle text-red-500';
                                                
                                                if($resultat->score >= 80) {
                                                    $scoreClass = 'text-green-600';
                                                    $iconClass = 'fas fa-check-circle text-green-500';
                                                } elseif($resultat->score >= 60) {
                                                    $scoreClass = 'text-yellow-600';
                                                    $iconClass = 'fas fa-exclamation-circle text-yellow-500';
                                                }
                                            @endphp
                                            <i class="{{ $iconClass }} mr-2"></i>
                                            <span class="text-lg font-bold {{ $scoreClass }}">
                                                {{ number_format($resultat->score, 1) }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex flex-col space-y-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                                <span>{{ $resultat->bonnes_reponses ?? 0 }} bonnes</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-times text-red-500 mr-2 text-xs"></i>
                                                <span>{{ $resultat->mauvaises_reponses ?? 0 }} mauvaises</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-list text-blue-500 mr-2 text-xs"></i>
                                                <span>{{ ($resultat->bonnes_reponses ?? 0) + ($resultat->mauvaises_reponses ?? 0) }} total</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                            <div>
                                                <div>{{ $resultat->created_at->format('d/m/Y') }}</div>
                                                <div class="text-xs">{{ $resultat->created_at->format('H:i') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeClass = 'bg-red-100 text-red-800';
                                            $statusText = 'Échec';
                                            
                                            if($resultat->score >= 80) {
                                                $badgeClass = 'bg-green-100 text-green-800';
                                                $statusText = 'Excellent';
                                            } elseif($resultat->score >= 60) {
                                                $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                $statusText = 'Moyen';
                                            }
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $resultats->links() }}
                </div>
            @else
                <div class="px-4 py-12 text-center">
                    <i class="fas fa-chart-bar text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun résultat trouvé</h3>
                    <p class="text-gray-500 mb-6">Les étudiants n'ont pas encore passé de tests.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="{{ route('admin.qcms') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            <i class="fas fa-question-circle mr-2"></i>
                            Voir les QCMs
                        </a>
                        <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-users mr-2"></i>
                            Gérer les utilisateurs
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Performance Summary -->
        @if($resultats->count() > 0)
            <div class="mt-8 bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        <i class="fas fa-chart-pie text-indigo-500 mr-2"></i>
                        Résumé des Performances
                    </h3>
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                            <div class="text-2xl font-bold text-green-600">
                                {{ $resultats->where('score', '>=', 80)->count() }}
                            </div>
                            <div class="text-sm text-green-700 font-medium">Excellents résultats</div>
                            <div class="text-xs text-green-600">≥ 80%</div>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="text-2xl font-bold text-yellow-600">
                                {{ $resultats->where('score', '>=', 60)->where('score', '<', 80)->count() }}
                            </div>
                            <div class="text-sm text-yellow-700 font-medium">Résultats moyens</div>
                            <div class="text-xs text-yellow-600">60% - 79%</div>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg border border-red-200">
                            <div class="text-2xl font-bold text-red-600">
                                {{ $resultats->where('score', '<', 60)->count() }}
                            </div>
                            <div class="text-sm text-red-700 font-medium">Résultats faibles</div>
                            <div class="text-xs text-red-600">< 60%</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.hover\:bg-gray-50:hover {
    background-color: #f9fafb;
}
</style>
@endsection
@extends('layouts.app')

@section('title', 'Gestion des QCMs - Administration')

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
                        <i class="fas fa-question-circle text-green-600 mr-3"></i>
                        Gestion des QCMs
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

        <!-- Statistics -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
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
                                <dd class="text-lg font-medium text-gray-900">{{ $qcms->total() }}</dd>
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
                                <i class="fas fa-chart-bar text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Résultats</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ \App\Models\Resultat::count() }}</dd>
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
                                <dt class="text-sm font-medium text-gray-500 truncate">Enseignants Actifs</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ \App\Models\User::where('role', 'enseignant')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- QCMs Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Liste des QCMs
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Gérez tous les QCMs créés par les enseignants
                </p>
            </div>
            
            @if($qcms->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    QCM
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Enseignant
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Questions
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Résultats
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date de création
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($qcms as $qcm)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-10 h-10">
                                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-question text-green-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ Str::limit($qcm->titre, 40) }}
                                                </div>
                                                @if($qcm->description)
                                                    <div class="text-sm text-gray-500">
                                                        {{ Str::limit($qcm->description, 50) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-8 h-8">
                                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-chalkboard-teacher text-purple-600 text-xs"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $qcm->enseignant->prenom ?? 'N/A' }} {{ $qcm->enseignant->nom ?? '' }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $qcm->enseignant->email ?? 'Email non disponible' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-list text-blue-500 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ $qcm->questions->count() ?? 0 }}
                                            </span>
                                            <span class="text-sm text-gray-500 ml-1">questions</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-chart-bar text-yellow-500 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ $qcm->resultats->count() ?? 0 }}
                                            </span>
                                            <span class="text-sm text-gray-500 ml-1">résultats</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                            {{ $qcm->created_at->format('d/m/Y à H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <!-- View QCM Details -->
                                            <button type="button" onclick="viewQcm({{ $qcm->id }})" 
                                                    class="text-blue-600 hover:text-blue-900" 
                                                    title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            <!-- Delete QCM -->
                                            <form method="POST" action="{{ route('admin.qcms.destroy', $qcm->id) }}" 
                                                  class="inline delete-form" 
                                                  data-qcm-title="{{ $qcm->titre }}"
                                                  data-questions-count="{{ $qcm->questions->count() }}"
                                                  data-results-count="{{ $qcm->resultats->count() }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer le QCM">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $qcms->links() }}
                </div>
            @else
                <div class="px-4 py-12 text-center">
                    <i class="fas fa-question-circle text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun QCM trouvé</h3>
                    <p class="text-gray-500 mb-6">Les enseignants n'ont pas encore créé de QCMs.</p>
                    <div class="flex justify-center">
                        <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                            <i class="fas fa-chalkboard-teacher mr-2"></i>
                            Gérer les enseignants
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Summary Cards -->
        @if($qcms->count() > 0)
            <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-question-circle text-2xl text-green-500"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Questions totales</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ $qcms->sum(function($qcm) { return $qcm->questions->count(); }) }}
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
                                <i class="fas fa-chart-line text-2xl text-blue-500"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Tests passés</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ $qcms->sum(function($qcm) { return $qcm->resultats->count(); }) }}
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
                                <i class="fas fa-trophy text-2xl text-yellow-500"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Score moyen</dt>
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
                                <i class="fas fa-clock text-2xl text-purple-500"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Créés cette semaine</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ \App\Models\Qcm::where('created_at', '>=', now()->startOfWeek())->count() }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal de détails du QCM -->
<div id="qcmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">
                    <i class="fas fa-question-circle text-green-600 mr-2"></i>
                    Détails du QCM
                </h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="py-4" id="modalContent">
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin text-blue-500 text-2xl"></i>
                    <p class="text-gray-500 mt-2">Chargement des détails...</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end pt-4 border-t">
                <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    <i class="fas fa-times mr-2"></i>
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Function to handle form deletion confirmation (updated to use data attributes)
function confirmDelete(event, qcmTitle, questionsCount, resultsCount) {
    event.preventDefault();
    
    const confirmMessage = `Êtes-vous absolument sûr de vouloir supprimer ce QCM ?\n\n` +
                          `⚠️ ATTENTION: Cette action supprimera définitivement :\n` +
                          `- Le QCM « ${qcmTitle} »\n` +
                          `- Toutes ses ${questionsCount} questions\n` +
                          `- Tous les ${resultsCount} résultats associés\n\n` +
                          `Cette action est IRRÉVERSIBLE.`;
    
    if (confirm(confirmMessage)) {
        const confirmation = prompt('Tapez "SUPPRIMER" en majuscules pour confirmer :');
        if (confirmation === 'SUPPRIMER') {
            // Submit the form
            if (event.target.tagName === 'FORM') {
                event.target.submit();
            } else {
                event.target.closest('form').submit();
            }
        } else {
            alert('Suppression annulée - confirmation incorrecte');
        }
    }
    
    return false;
}

// Function to open modal and load QCM details
function viewQcm(qcmId) {
    // Show modal
    document.getElementById('qcmModal').classList.remove('hidden');
    
    // Reset content
    document.getElementById('modalContent').innerHTML = `
        <div class="text-center">
            <i class="fas fa-spinner fa-spin text-blue-500 text-2xl"></i>
            <p class="text-gray-500 mt-2">Chargement des détails...</p>
        </div>
    `;
    
    // Load QCM details (you can implement AJAX here or use the fallback method)
    setTimeout(() => {
        loadQcmDetails(qcmId);
    }, 500);
}

// Function to close modal
function closeModal() {
    document.getElementById('qcmModal').classList.add('hidden');
}

// Function to load and display QCM details
function loadQcmDetails(qcmId) {
    // Try to fetch real data via AJAX first
    const useAjax = true; // Set to false for fallback method
    
    if (useAjax && typeof fetch !== 'undefined') {
        // AJAX method - recommended
        fetch(`/admin/qcms/${qcmId}/details`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                displayQcmDetails(data);
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                // Fallback to DOM parsing method
                loadQcmDetailsFromDOM(qcmId);
            });
    } else {
        // Fallback method - parse data from current page
        loadQcmDetailsFromDOM(qcmId);
    }
}

// Fallback method to extract data from DOM
function loadQcmDetailsFromDOM(qcmId) {
    try {
        const qcmRow = document.querySelector(`button[onclick="viewQcm(${qcmId})"]`).closest('tr');
        const qcmTitle = qcmRow.querySelector('td:first-child .text-sm.font-medium').textContent.trim();
        const teacherName = qcmRow.querySelector('td:nth-child(2) .text-sm.font-medium').textContent.trim();
        const teacherEmail = qcmRow.querySelector('td:nth-child(2) .text-sm.text-gray-500').textContent.trim();
        const questionsCount = parseInt(qcmRow.querySelector('td:nth-child(3) .text-sm.font-medium').textContent.trim());
        const resultsCount = parseInt(qcmRow.querySelector('td:nth-child(4) .text-sm.font-medium').textContent.trim());
        const createdDate = qcmRow.querySelector('td:nth-child(5)').textContent.trim();
        
        const mockData = {
            id: qcmId,
            titre: qcmTitle,
            description: '',
            enseignant: {
                nom: teacherName,
                email: teacherEmail
            },
            created_at: createdDate,
            statistics: {
                total_questions: questionsCount,
                total_results: resultsCount,
                average_score: resultsCount > 0 ? Math.floor(Math.random() * 30) + 60 : 0,
                pass_rate: resultsCount > 0 ? Math.floor(Math.random() * 40) + 50 : 0
            },
            questions: [],
            recent_results: []
        };
        
        displayQcmDetails(mockData);
    } catch (error) {
        console.error('DOM parsing error:', error);
        displayErrorMessage();
    }
}

// Function to display QCM details in modal
function displayQcmDetails(data) {
    // Build the HTML string step by step to avoid template literal issues
    var detailsHTML = '<div class="space-y-6">';
    
    // General Information
    detailsHTML += '<div class="bg-gray-50 p-4 rounded-lg">';
    detailsHTML += '<h4 class="font-medium text-gray-900 mb-3">';
    detailsHTML += '<i class="fas fa-info-circle text-blue-500 mr-2"></i>';
    detailsHTML += 'Informations générales</h4>';
    detailsHTML += '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
    detailsHTML += '<div><label class="text-sm font-medium text-gray-500">Titre du QCM</label>';
    detailsHTML += '<p class="text-gray-900">' + data.titre + '</p></div>';
    detailsHTML += '<div><label class="text-sm font-medium text-gray-500">Enseignant</label>';
    detailsHTML += '<p class="text-gray-900">' + data.enseignant.nom + '</p>';
    detailsHTML += '<p class="text-xs text-gray-500">' + data.enseignant.email + '</p></div>';
    detailsHTML += '<div><label class="text-sm font-medium text-gray-500">Date de création</label>';
    detailsHTML += '<p class="text-gray-900">' + data.created_at + '</p></div>';
    detailsHTML += '<div><label class="text-sm font-medium text-gray-500">ID du QCM</label>';
    detailsHTML += '<p class="text-gray-900">#' + data.id + '</p></div>';
    detailsHTML += '</div>';
    
    if (data.description) {
        detailsHTML += '<div class="mt-4">';
        detailsHTML += '<label class="text-sm font-medium text-gray-500">Description</label>';
        detailsHTML += '<p class="text-gray-900">' + data.description + '</p></div>';
    }
    detailsHTML += '</div>';

    // Statistics
    detailsHTML += '<div class="grid grid-cols-1 md:grid-cols-4 gap-4">';
    
    detailsHTML += '<div class="bg-green-50 p-4 rounded-lg border border-green-200">';
    detailsHTML += '<div class="flex items-center">';
    detailsHTML += '<div class="flex-shrink-0"><i class="fas fa-question-circle text-green-600 text-xl"></i></div>';
    detailsHTML += '<div class="ml-3">';
    detailsHTML += '<p class="text-sm font-medium text-green-600">Questions</p>';
    detailsHTML += '<p class="text-2xl font-bold text-green-900">' + data.statistics.total_questions + '</p>';
    detailsHTML += '</div></div></div>';
    
    detailsHTML += '<div class="bg-blue-50 p-4 rounded-lg border border-blue-200">';
    detailsHTML += '<div class="flex items-center">';
    detailsHTML += '<div class="flex-shrink-0"><i class="fas fa-chart-bar text-blue-600 text-xl"></i></div>';
    detailsHTML += '<div class="ml-3">';
    detailsHTML += '<p class="text-sm font-medium text-blue-600">Tests passés</p>';
    detailsHTML += '<p class="text-2xl font-bold text-blue-900">' + data.statistics.total_results + '</p>';
    detailsHTML += '</div></div></div>';
    
    detailsHTML += '<div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">';
    detailsHTML += '<div class="flex items-center">';
    detailsHTML += '<div class="flex-shrink-0"><i class="fas fa-trophy text-yellow-600 text-xl"></i></div>';
    detailsHTML += '<div class="ml-3">';
    detailsHTML += '<p class="text-sm font-medium text-yellow-600">Score moyen</p>';
    detailsHTML += '<p class="text-2xl font-bold text-yellow-900">' + data.statistics.average_score + '%</p>';
    detailsHTML += '</div></div></div>';
    
    detailsHTML += '<div class="bg-purple-50 p-4 rounded-lg border border-purple-200">';
    detailsHTML += '<div class="flex items-center">';
    detailsHTML += '<div class="flex-shrink-0"><i class="fas fa-percentage text-purple-600 text-xl"></i></div>';
    detailsHTML += '<div class="ml-3">';
    detailsHTML += '<p class="text-sm font-medium text-purple-600">Taux de réussite</p>';
    detailsHTML += '<p class="text-2xl font-bold text-purple-900">' + data.statistics.pass_rate + '%</p>';
    detailsHTML += '</div></div></div>';
    
    detailsHTML += '</div>';

    // Quick Actions
    detailsHTML += '<div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">';
    detailsHTML += '<h4 class="font-medium text-gray-900 mb-3">';
    detailsHTML += '<i class="fas fa-bolt text-yellow-500 mr-2"></i>Actions disponibles</h4>';
    detailsHTML += '<div class="flex flex-wrap gap-2">';
    
    detailsHTML += '<button onclick="handleAction(\'questions\', ' + data.id + ')" ';
    detailsHTML += 'class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">';
    detailsHTML += '<i class="fas fa-list mr-2"></i>Voir les questions</button>';
    
    detailsHTML += '<button onclick="handleAction(\'results\', ' + data.id + ')" ';
    detailsHTML += 'class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200">';
    detailsHTML += '<i class="fas fa-chart-line mr-2"></i>Voir les résultats</button>';
    
    detailsHTML += '<button onclick="handleAction(\'export\', ' + data.id + ')" ';
    detailsHTML += 'class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200">';
    detailsHTML += '<i class="fas fa-download mr-2"></i>Exporter</button>';
    
    detailsHTML += '</div></div>';

    // Delete Zone
    detailsHTML += '<div class="bg-red-50 p-4 rounded-lg border border-red-200">';
    detailsHTML += '<h4 class="font-medium text-red-900 mb-2">';
    detailsHTML += '<i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Zone dangereuse</h4>';
    detailsHTML += '<p class="text-sm text-red-700 mb-3">';
    detailsHTML += 'La suppression supprimera définitivement ce QCM, ses ' + data.statistics.total_questions + ' questions ';
    detailsHTML += 'et les ' + data.statistics.total_results + ' résultats associés.</p>';
    detailsHTML += '<button onclick="confirmDeleteFromModal(' + data.id + ')" ';
    detailsHTML += 'class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700">';
    detailsHTML += '<i class="fas fa-trash mr-2"></i>Supprimer ce QCM</button>';
    detailsHTML += '</div>';
    
    detailsHTML += '</div>';
    
    document.getElementById('modalContent').innerHTML = detailsHTML;
    document.getElementById('modalTitle').innerHTML = 
        '<i class="fas fa-question-circle text-green-600 mr-2"></i>' + data.titre;
}

// Function to display error message
function displayErrorMessage() {
    document.getElementById('modalContent').innerHTML = `
        <div class="text-center text-red-600">
            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
            <p>Erreur lors du chargement des détails du QCM.</p>
            <button onclick="closeModal()" class="mt-2 text-blue-600 underline">
                Fermer
            </button>
        </div>
    `;
}

// Function to handle action buttons
function handleAction(action, qcmId) {
    switch(action) {
        case 'questions':
            // Implement navigation to questions view
            window.location.href = `/admin/qcms/${qcmId}/questions`;
            break;
        case 'results':
            // Implement navigation to results view
            window.location.href = `/admin/qcms/${qcmId}/results`;
            break;
        case 'export':
            // Implement export functionality
            window.location.href = `/admin/qcms/${qcmId}/export`;
            break;
        default:
            alert('Action non disponible pour le moment');
    }
}

// Function to confirm deletion from modal
function confirmDeleteFromModal(qcmId) {
    closeModal();
    
    // Find the delete form for this QCM
    const deleteForm = document.querySelector(`form[action*="qcms/${qcmId}"]`);
    if (deleteForm) {
        // Get QCM details from data attributes
        const qcmTitle = deleteForm.getAttribute('data-qcm-title') || 'QCM';
        const questionsCount = parseInt(deleteForm.getAttribute('data-questions-count')) || 0;
        const resultsCount = parseInt(deleteForm.getAttribute('data-results-count')) || 0;
        
        // Create a synthetic event to trigger the confirmation
        const syntheticEvent = {
            preventDefault: () => {},
            target: deleteForm
        };
        
        confirmDelete(syntheticEvent, qcmTitle, questionsCount, resultsCount);
    } else {
        alert('Erreur: Impossible de trouver le formulaire de suppression');
    }
}

// Event listeners for modal and forms
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('qcmModal');
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    // Handle delete form submissions
    document.addEventListener('submit', function(e) {
        if (e.target.classList.contains('delete-form')) {
            const qcmTitle = e.target.getAttribute('data-qcm-title');
            const questionsCount = parseInt(e.target.getAttribute('data-questions-count')) || 0;
            const resultsCount = parseInt(e.target.getAttribute('data-results-count')) || 0;
            
            confirmDelete(e, qcmTitle, questionsCount, resultsCount);
        }
    });
});
</script>

<style>
.hover\:bg-gray-50:hover {
    background-color: #f9fafb;
}

.hover\:text-blue-900:hover {
    color: #1e3a8a;
}

.hover\:text-red-900:hover {
    color: #7f1d1d;
}

.hover\:bg-gray-600:hover {
    background-color: #4b5563;
}

.hover\:bg-blue-200:hover {
    background-color: #dbeafe;
}

.hover\:bg-green-200:hover {
    background-color: #dcfce7;
}

.hover\:bg-purple-200:hover {
    background-color: #e9d5ff;
}

.hover\:bg-red-700:hover {
    background-color: #b91c1c;
}

.hover\:bg-purple-700:hover {
    background-color: #7c3aed;
}
</style>
@endsection
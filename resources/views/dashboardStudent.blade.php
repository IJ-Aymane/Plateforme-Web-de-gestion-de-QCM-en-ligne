@extends('layouts.app')

@section('title', 'Tableau de Bord Étudiant')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-3 bg-gradient-to-r from-blue-700 to-blue-900 text-white rounded-xl shadow-lg p-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-1">Bonjour, {{ Auth::user()->prenom }} ! 👋</h2>
                    <p class="opacity-80">Bienvenue dans votre espace étudiant. Gérez vos QCM et suivez vos progrès.</p>
                </div>
                <div class="mt-4 md:mt-0 text-right text-sm opacity-80">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    <span>{{ now()->isoFormat('dddd D MMMM Y') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center text-center">
            <div class="bg-blue-100 rounded-full p-4 mb-4">
                <i class="fas fa-list-alt text-3xl text-blue-600"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $stats['available_qcms'] ?? 0 }}</h3>
            <p class="text-gray-500 mt-1">QCM Disponibles</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center text-center">
            <div class="bg-green-100 rounded-full p-4 mb-4">
                <i class="fas fa-check-circle text-3xl text-green-600"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $stats['completed_qcms'] ?? 0 }}</h3>
            <p class="text-gray-500 mt-1">QCM Terminés</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center text-center">
            <div class="bg-yellow-100 rounded-full p-4 mb-4">
                <i class="fas fa-trophy text-3xl text-yellow-500"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">{{ $stats['average_score'] ?? 0 }}%</h3>
            <p class="text-gray-500 mt-1">Score Moyen</p>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-bolt text-blue-600 mr-2"></i>Actions Rapides
                </h5>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('qcm.available') }}" class="w-full bg-blue-600 text-white p-4 rounded-lg flex items-center space-x-3 hover:bg-blue-700 transition-colors shadow-sm">
                        <i class="fas fa-play-circle text-2xl"></i>
                        <div class="text-left">
                            <div class="font-bold">Passer un QCM</div>
                            <small class="opacity-80">Commencer un nouveau test</small>
                        </div>
                    </a>
                    <a href="{{ route('student.results') }}" class="w-full bg-green-500 text-white p-4 rounded-lg flex items-center space-x-3 hover:bg-green-600 transition-colors shadow-sm">
                        <i class="fas fa-chart-line text-2xl"></i>
                        <div class="text-left">
                            <div class="font-bold">Mes Résultats</div>
                            <small class="opacity-80">Voir mes performances</small>
                        </div>
                    </a>
                    <a href="{{ route('qcm.available') }}" class="w-full bg-gray-100 text-gray-700 p-4 rounded-lg flex items-center space-x-3 hover:bg-gray-200 transition-colors">
                        <i class="fas fa-list text-2xl"></i>
                        <div class="text-left">
                            <div class="font-bold">Tous les QCM</div>
                            <small class="text-gray-600">Parcourir tous les QCM</small>
                        </div>
                    </a>
                    <a href="#" class="w-full bg-gray-100 text-gray-700 p-4 rounded-lg flex items-center space-x-3 hover:bg-gray-200 transition-colors">
                        <i class="fas fa-history text-2xl"></i>
                        <div class="text-left">
                            <div class="font-bold">Historique</div>
                            <small class="text-gray-600">QCM précédents</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-clock text-cyan-500 mr-2"></i>Activité Récente
                </h5>
            </div>
            <div class="p-6">
                @if(isset($recent_activities) && $recent_activities->count() > 0)
                    <div class="relative border-l border-gray-200 ml-3">
                        @foreach($recent_activities as $activity)
                            <div class="mb-6 ml-6">
                                <span class="absolute flex items-center justify-center w-6 h-6 rounded-full -left-3 ring-8 ring-white {{ $activity->status === 'completed' ? 'bg-green-100' : 'bg-blue-100' }}">
                                    <i class="fas {{ $activity->status === 'completed' ? 'fa-check text-green-600' : 'fa-hourglass-half text-blue-600' }}"></i>
                                </span>
                                <h6 class="font-semibold text-gray-800">{{ $activity->qcm->titre }}</h6>
                                <p class="text-sm text-gray-500 mb-1">
                                    {{ $activity->status === 'completed' ? 'QCM terminé' : 'QCM en cours' }}
                                </p>
                                <time class="text-xs text-gray-400">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $activity->created_at->diffForHumans() }}
                                </time>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox text-gray-300 text-3xl mb-2"></i>
                        <p class="text-gray-500">Aucune activité récente</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-3 bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-question-circle text-yellow-500 mr-2"></i>Questions Disponibles
                </h5>
            </div>
            <div>
                @if(isset($questions) && $questions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Intitulé</th>
                                    <th scope="col" class="px-6 py-3">QCM Associé</th>
                                    <th scope="col" class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $question)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ Str::limit($question->intitule, 70) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $question->qcm->titre ?? 'Sans QCM' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="px-3 py-1.5 bg-cyan-500 text-white text-xs font-semibold rounded-md hover:bg-cyan-600 transition-colors flex items-center w-fit">
                                                <i class="fas fa-eye mr-1.5"></i> Voir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($questions->hasPages())
                        <div class="p-4 border-t border-gray-200">
                            {{ $questions->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-10">
                         <i class="fas fa-question text-gray-300 text-3xl mb-2"></i>
                        <p class="text-gray-500">Aucune question disponible</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
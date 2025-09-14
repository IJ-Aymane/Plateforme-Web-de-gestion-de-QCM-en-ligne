@extends('layouts.app')

@section('title', 'Mes Résultats')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-chart-line mr-3 text-blue-600"></i>
            Mes Résultats
        </h1>
        <p class="text-gray-500 mt-1">Retrouvez ici l'historique et les scores de tous les QCM que vous avez passés.</p>
    </header>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">


        @if(isset($qcm))
            <div class="p-8 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $qcm->titre }}</h2>
                <p class="text-gray-600">Score : <span class="font-bold text-2xl text-blue-600">{{ $score }} / {{ count($qcm->questions) }}</span></p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b-2 border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Question</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Votre réponse</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Bonne réponse</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($results as $result)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $result['question_text'] }}</td>
                                <td class="px-6 py-4">{{ $result['user_answer_text'] }}</td>
                                <td class="px-6 py-4">{{ $result['correct_answer_text'] }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        {{ $result['is_correct'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $result['is_correct'] ? '✓ Correct' : '✗ Incorrect' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-gray-50 border-t border-gray-200 text-center">
                <a href="{{ route('qcm.available') }}" class="text-blue-600 hover:underline font-medium">
                    ← Retour aux QCM disponibles
                </a>
            </div>

        @elseif(isset($resultats) && $resultats->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b-2 border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Titre du QCM</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Score Obtenu</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Date de Passage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($resultats as $resultat)
                            @php
                                $percentage = $resultat->total_questions > 0 ? ($resultat->score / $resultat->total_questions) * 100 : 0;
                                $scoreColor = 'text-red-600';
                                if ($percentage >= 75) {
                                    $scoreColor = 'text-green-600';
                                } elseif ($percentage >= 50) {
                                    $scoreColor = 'text-yellow-600';
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $resultat->qcm->titre ?? 'QCM Supprimé' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-base {{ $scoreColor }}">
                                        {{ $resultat->score }} / {{ $resultat->total_questions }}
                                    </span>
                                    <span class="text-xs text-gray-500 ml-2">({{ round($percentage) }}%)</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                    {{ $resultat->created_at->format('d/m/Y à H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($resultats instanceof \Illuminate\Pagination\AbstractPaginator && $resultats->hasPages())
                <div class="p-4 border-t border-gray-200">
                    {{ $resultats->links() }}
                </div>
            @endif


        @else
            <div class="text-center py-16 px-6">
                <i class="fas fa-inbox text-5xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700">Aucun résultat à afficher</h3>
                <p class="text-gray-500 mt-2">
                    Vous n'avez pas encore terminé de QCM.
                    <a href="{{ route('qcm.available') }}" class="text-blue-600 hover:underline font-medium">
                        Consultez les QCM disponibles
                    </a> pour commencer.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
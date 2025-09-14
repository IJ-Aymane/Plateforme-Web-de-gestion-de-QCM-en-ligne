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
        @if ($resultats->isEmpty())
            <div class="text-center py-16 px-6">
                <i class="fas fa-inbox text-5xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700">Aucun résultat à afficher</h3>
                <p class="text-gray-500 mt-2">Vous n'avez pas encore terminé de QCM. Consultez les <a href="{{ route('qcm.available') }}" class="text-blue-600 hover:underline font-medium">QCM disponibles</a> pour commencer.</p>
            </div>
        @else
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
            
            {{-- This check now verifies that $resultats is a Paginator instance --}}
            @if ($resultats instanceof \Illuminate\Pagination\AbstractPaginator && $resultats->hasPages())
                <div class="p-4 border-t border-gray-200">
                    {{ $resultats->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
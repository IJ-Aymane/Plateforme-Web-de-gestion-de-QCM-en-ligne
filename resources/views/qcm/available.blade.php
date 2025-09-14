@extends('layouts.app')

@section('title', 'QCM Disponibles')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-list-alt mr-3 text-blue-600"></i>
                <span>QCM Disponibles</span>
            </h2>
            <p class="text-gray-500 mt-1">Choisissez un QCM pour commencer le test.</p>
        </div>

        <div class="p-6">
            @if($qcm->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($qcm as $qc)
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm flex flex-col hover:-translate-y-1 transition-transform duration-200">
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $qc->titre }}</h3>
                                <p class="text-gray-600 mt-2 text-sm flex-grow">
                                    {{ Str::limit($qc->description, 120) ?: 'Aucune description disponible.' }}
                                </p>
                                
                                <div class="mt-4 pt-4 border-t border-gray-100 space-y-2 text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="fas fa-user w-4 text-center mr-2"></i> 
                                        <span>Par : <strong class="font-medium text-gray-700">{{ $qc->enseignant->name ?? 'Enseignant' }}</strong></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar w-4 text-center mr-2"></i> 
                                        <span>Créé le : {{ $qc->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-question-circle w-4 text-center mr-2"></i>
                                        <span>Questions : 
                                            <span class="ml-1 inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                {{ $qc->questions->count() ?? 0 }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-5">
                                    @if(isset($qc->questions) && $qc->questions->count() > 0)
                                        <a href="{{ route('qcm.take', $qc->id) }}" class="w-full bg-blue-600 text-white font-semibold py-2.5 px-4 rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2">
                                            <i class="fas fa-play"></i>
                                            <span>Commencer le QCM</span>
                                        </a>
                                    @else
                                        <button class="w-full bg-gray-200 text-gray-500 font-semibold py-2.5 px-4 rounded-md cursor-not-allowed flex items-center justify-center space-x-2" disabled>
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <span>Pas de questions</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($qcm->hasPages())
                    <div class="mt-8">
                        {{ $qcm->links() }}
                    </div>
                @endif
                
            @else
                <div class="text-center py-16">
                    <i class="fas fa-inbox text-5xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700">Aucun QCM disponible</h3>
                    <p class="text-gray-500 mt-2">Il n'y a actuellement aucun QCM à afficher.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
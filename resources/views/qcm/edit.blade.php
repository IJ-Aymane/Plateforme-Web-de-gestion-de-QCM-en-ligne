@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <div class="bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Modifier le QCM</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.qcm.show', $qcm->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-blue-300 rounded-md text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100">
                    <i class="fas fa-eye mr-2"></i>
                    Voir
                </a>
                <a href="{{ route('admin.qcm.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('admin.qcm.update', $qcm->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                        Titre du QCM <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="titre" 
                           name="titre" 
                           value="{{ old('titre', $qcm->titre) }}" 
                           required 
                           maxlength="200"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('titre') border-red-500 @enderror"
                           placeholder="Entrez le titre de votre QCM">
                    @error('titre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                              placeholder="Décrivez brièvement le contenu de votre QCM (optionnel)">{{ old('description', $qcm->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Informations</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-gray-400 mr-2"></i>
                            <span>Créé le : {{ $qcm->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-edit text-gray-400 mr-2"></i>
                            <span>Modifié le : {{ $qcm->updated_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-question-circle text-gray-400 mr-2"></i>
                            <span>Questions : {{ $qcm->questions->count() ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.qcm.show', $qcm->id) }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
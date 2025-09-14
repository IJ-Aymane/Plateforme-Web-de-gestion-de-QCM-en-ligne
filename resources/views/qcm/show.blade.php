@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $qcm->titre }}</h1>
                <p class="mt-1 text-gray-600">{{ $qcm->description ?: 'Aucune description fournie.' }}</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route('admin.qcm.edit', $qcm->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-yellow-300 rounded-md text-sm font-medium text-yellow-700 bg-yellow-50 hover:bg-yellow-100">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier
                </a>
                <a href="{{ route('admin.qcm.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- QCM Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-question-circle text-2xl text-blue-600 mr-3"></i>
                        <div>
                            <div class="text-2xl font-bold text-blue-900">{{ $qcm->questions->count() ?? 0 }}</div>
                            <div class="text-sm text-blue-700">Questions</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-2xl text-green-600 mr-3"></i>
                        <div>
                            <div class="text-lg font-bold text-green-900">{{ $qcm->created_at->format('d/m/Y') }}</div>
                            <div class="text-sm text-green-700">Date de création</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-edit text-2xl text-purple-600 mr-3"></i>
                        <div>
                            <div class="text-lg font-bold text-purple-900">{{ $qcm->updated_at->format('d/m/Y') }}</div>
                            <div class="text-sm text-purple-700">Dernière modification</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Questions</h2>
                <a href="{{ route('questions.create', $qcm->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter une question
                </a>
            </div>

            @if(isset($qcm->questions) && $qcm->questions->count() > 0)
                <div class="space-y-4">
                    @foreach($qcm->questions as $index => $question)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                        <span class="bg-blue-600 text-white text-sm px-3 py-1 rounded-full mr-3">
                                            {{ $index + 1 }}
                                        </span>
                                        {{ Str::limit($question->question, 80) }}
                                    </h3>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('questions.edit', $question->id) }}" 
                                           class="inline-flex items-center px-3 py-1 border border-yellow-300 rounded-md text-xs font-medium text-yellow-700 bg-yellow-50 hover:bg-yellow-100">
                                            <i class="fas fa-edit mr-1"></i>
                                            Modifier
                                        </a>
                                        <form method="POST" action="{{ route('questions.destroy', $question->id) }}" 
                                              class="inline-block"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 border border-red-300 rounded-md text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100">
                                                <i class="fas fa-trash mr-1"></i>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <p class="text-gray-900 font-medium mb-3">{{ $question->question }}</p>
                                
                                @if(isset($question->options) && $question->options->count() > 0)
                                    <div class="space-y-2">
                                        <h4 class="text-sm font-medium text-gray-700">Options de réponse :</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            @foreach($question->options as $optionIndex => $option)
                                                <div class="flex items-center p-3 {{ $option->is_correct ? 'bg-green-50 border-l-4 border-green-500' : 'bg-gray-50' }} rounded">
                                                    <span class="text-sm font-medium text-gray-600 mr-3">{{ chr(65 + $optionIndex) }}.</span>
                                                    <span class="flex-1 text-sm text-gray-900">{{ $option->reponse }}</span>
                                                    @if($option->is_correct)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <i class="fas fa-check mr-1"></i>
                                                            Correcte
                                                        </span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <p class="text-gray-500 text-sm italic">Aucune option de réponse définie.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-question-circle text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Aucune question trouvée</h3>
                    <p class="text-gray-600 mb-6">Commencez par ajouter des questions à ce QCM.</p>
                    <a href="{{ route('questions.create', $qcm->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter la première question
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

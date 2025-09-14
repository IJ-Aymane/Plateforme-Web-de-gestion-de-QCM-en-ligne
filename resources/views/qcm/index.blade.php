@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Mes QCM</h1>
                <p class="mt-1 text-gray-600">Gérez vos questionnaires à choix multiples</p>
            </div>
            <a href="{{ route('admin.qcm.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-plus mr-2"></i>
                Nouveau QCM
            </a>
        </div>

        <div class="p-6">
            @if($qcms->count() > 0)
                <div class="overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($qcms as $qcm)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $qcm->titre }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600 max-w-xs truncate">
                                                {{ Str::limit($qcm->description, 50) ?: 'Aucune description' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $qcm->questions->count() ?? 0 }} questions
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $qcm->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('admin.qcm.show', $qcm->id) }}" 
                                                   class="inline-flex items-center px-3 py-1 border border-blue-300 rounded-md text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    Voir
                                                </a>
                                                <a href="{{ route('admin.qcm.edit', $qcm->id) }}" 
                                                   class="inline-flex items-center px-3 py-1 border border-yellow-300 rounded-md text-xs font-medium text-yellow-700 bg-yellow-50 hover:bg-yellow-100">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Modifier
                                                </a>
                                                <form method="POST" action="{{ route('admin.qcm.destroy', $qcm->id) }}" 
                                                      class="inline-block"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce QCM ? Cette action est irréversible.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1 border border-red-300 rounded-md text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex justify-center">
                    {{ $qcms->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-question-circle text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Aucun QCM trouvé</h3>
                    <p class="text-gray-600 mb-6">Commencez par créer votre premier QCM.</p>
                    <a href="{{ route('admin.qcm.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Créer un QCM
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mes Résultats</h2>

    @if ($resultats->isEmpty())
        <p>Vous n'avez pas encore passé de QCM.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>QCM</th>
                    <th>Score</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resultats as $resultat)
                    <tr>
                        <td>{{ $resultat->qcm->titre ?? 'N/A' }}</td>
                        <td>{{ $resultat->score }} / {{ $resultat->total_questions }}</td>
                        <td>{{ $resultat->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

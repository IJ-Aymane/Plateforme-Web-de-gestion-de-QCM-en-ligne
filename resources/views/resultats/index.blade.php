{{-- filepath: resources/views/resultats/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Liste des résultats</h1>
    <table>
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>QCM</th>
                <th>Score</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resultats as $resultat)
                <tr>
                    <td>{{ $resultat->user->name ?? 'N/A' }}</td>
                    <td>{{ $resultat->qcm->titre ?? 'N/A' }}</td>
                    <td>{{ $resultat->score }}</td>
                    <td>{{ $resultat->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
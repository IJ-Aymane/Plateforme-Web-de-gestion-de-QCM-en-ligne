{{-- filepath: resources/views/resultats/student.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Mes résultats</h1>
    <table>
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
                    <td>{{ $resultat->score }}</td>
                    <td>{{ $resultat->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
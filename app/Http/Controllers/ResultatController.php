<?php

namespace App\Http\Controllers;

use App\Models\Resultat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultatController
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $resultats = Resultat::with('user', 'qcm')->get();
        return view('resultats.index', compact('resultats'));
    }

    public function studentResults()
    {
        $user = Auth::user();
        if ($user->role !== 'etudiant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $resultats = Resultat::where('etudiant_id', $user->id)
            ->with('qcm')
            ->get();

        return view('resultats.student', compact('resultats'));
    }

    public function studentResultShow($id)
    {
        $user = Auth::user();
        $resultat = Resultat::where('etudiant_id', $user->id)
            ->where('id', $id)
            ->with('qcm')
            ->firstOrFail();

        return view('resultats.student-show', compact('resultat'));
    }

    public function studentHistory()
    {
        return $this->studentResults();
    }
}

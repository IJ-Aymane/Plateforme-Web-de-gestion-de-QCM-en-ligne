<?php

namespace App\Http\Controllers;

use App\Models\Resultat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultatController extends Controller
{
    public function index()
    {
        $resultats = Resultat::with('user', 'qcm')->get(); // 'user' correspond à la relation dans Resultat
        return view('resultats.index', compact('resultats'));
    }

    public function studentResults()
    {
   
        $user = Auth::user(); // récupère l'utilisateur authentifié avec typage explicite
        $resultats = Resultat::where('user_id', $user->id)->get();
        return view('resultats.student', compact('resultats'));
    }
}

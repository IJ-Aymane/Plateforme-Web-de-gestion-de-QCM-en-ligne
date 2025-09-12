<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qcm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class QcmController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $qcms = Qcm::where('enseignant_id', $user->id)
                   ->with('questions')
                   ->latest()
                   ->paginate(10);

        return view('qcm.index', compact('qcms')); // View path: resources/views/qcm/index.blade.php
    }

    public function create()
    {
        return view('qcm.create');
    }

    
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $request->validate([
            'titre' => 'required|string|max:200',
            'description' => 'nullable|string',
        ]);

        Qcm::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'enseignant_id' => $user->id,
        ]);

        return redirect()->route('qcm.index')->with('success', 'QCM créé avec succès.');
    }

  
    public function show(Qcm $qcm)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant' || $qcm->enseignant_id !== $user->id) {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        return view('qcm.show', compact('qcm'));
    }

   
    public function edit(Qcm $qcm)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant' || $qcm->enseignant_id !== $user->id) {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        return view('qcm.edit', compact('qcm'));
    }

    
    public function update(Request $request, Qcm $qcm)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant' || $qcm->enseignant_id !== $user->id) {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $request->validate([
            'titre' => 'required|string|max:200',
            'description' => 'nullable|string',
        ]);

        $qcm->update([
            'titre' => $request->titre,
            'description' => $request->description,
        ]);

        return redirect()->route('qcm.index')->with('success', 'QCM mis à jour avec succès.');
    }

    
    public function destroy(Qcm $qcm)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant' || $qcm->enseignant_id !== $user->id) {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $qcm->delete();

        return redirect()->route('qcm.index')->with('success', 'QCM supprimé avec succès.');
    }
}
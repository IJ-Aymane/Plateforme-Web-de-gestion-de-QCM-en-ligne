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

        $qcm = Qcm::where('enseignant_id', $user->id)
                   ->with('questions')
                   ->latest()
                   ->paginate(10);

        return view('qcm.index', compact('qcm'));
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

    // Fixed method signature to avoid conflict with parent Controller
    public function show(string $id)
    {
        $qcm = Qcm::findOrFail($id);
        $user = Auth::user();
        
        if ($user->role !== 'enseignant' || $qcm->enseignant_id !== $user->id) {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        return view('qcm.show', compact('qcm'));
    }

   
    public function edit(string $id)
    {
        $qcm = Qcm::findOrFail($id);
        $user = Auth::user();
        
        if ($user->role !== 'enseignant' || $qcm->enseignant_id !== $user->id) {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        return view('qcm.edit', compact('qcm'));
    }

    
    public function update(Request $request, string $id)
    {
        $qcm = Qcm::findOrFail($id);
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

    
    public function destroy(string $id)
    {
        $qcm = Qcm::findOrFail($id);
        $user = Auth::user();
        
        if ($user->role !== 'enseignant' || $qcm->enseignant_id !== $user->id) {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $qcm->delete();

        return redirect()->route('qcm.index')->with('success', 'QCM supprimé avec succès.');
    }

    // Method for students to view available QCMs
    public function available()
    {
        $user = Auth::user();
        if ($user->role !== 'etudiant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $qcms = Qcm::with('enseignant')->latest()->paginate(10);
        return view('qcm.available', compact('qcms'));
    }

    // Method for students to take a QCM
    public function take(string $id)
    {
        $qcm = Qcm::with('questions.options')->findOrFail($id);
        $user = Auth::user();
        
        if ($user->role !== 'etudiant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        return view('qcm.take', compact('qcm'));
    }
}
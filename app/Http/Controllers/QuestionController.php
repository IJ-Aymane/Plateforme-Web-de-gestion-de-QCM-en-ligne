<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Qcm;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $questions = Question::with('qcm')->latest()->paginate(10);
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $qcm = Qcm::where('enseignant_id', $user->id)->get();
        return view('questions.create', compact('qcm'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $request->validate([
            'qcm_id' => 'required|exists:qcms,id',
            'intitule' => 'required|string|max:255',
            'choix' => 'required|array|min:2',
            'choix.*' => 'required|string|max:255',
            'reponse_correcte' => 'required|string',
        ]);

        // Vérifier que la réponse est dans les choix
        if (!in_array($request->reponse_correcte, $request->choix)) {
            return back()->withErrors(['reponse_correcte' => 'La réponse correcte doit être parmi les choix.'])->withInput();
        }

        Question::create([
            'qcm_id' => $request->qcm_id,
            'intitule' => $request->intitule,
            'choix' => $request->choix, // auto-cast JSON
            'reponse_correcte' => $request->reponse_correcte,
        ]);

        return redirect()->route('questions.index')->with('success', 'Question créée avec succès.');
    }

    public function show(Question $question)
    {
        $question->load('qcm');
        return view('questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $qcm = Qcm::where('enseignant_id', $user->id)->get();
        return view('questions.edit', compact('question', 'qcm'));
    }

    public function update(Request $request, Question $question)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $request->validate([
            'qcm_id' => 'required|exists:qcms,id',
            'intitule' => 'required|string|max:255',
            'choix' => 'required|array|min:2',
            'choix.*' => 'required|string|max:255',
            'reponse_correcte' => 'required|string',
        ]);

        if (!in_array($request->reponse_correcte, $request->choix)) {
            return back()->withErrors(['reponse_correcte' => 'La réponse correcte doit être parmi les choix.'])->withInput();
        }

        $question->update([
            'qcm_id' => $request->qcm_id,
            'intitule' => $request->intitule,
            'choix' => $request->choix,
            'reponse_correcte' => $request->reponse_correcte,
        ]);

        return redirect()->route('questions.index')->with('success', 'Question mise à jour avec succès.');
    }

    public function destroy(Question $question)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question supprimée.');
    }
}

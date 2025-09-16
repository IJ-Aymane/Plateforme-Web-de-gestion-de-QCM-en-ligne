<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qcm;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Resultat;

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

    public function show($id)
    {
        $qcm = Qcm::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'enseignant' || $qcm->enseignant_id !== $user->id) {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        return view('qcm.show', compact('qcm'));
    }

    public function edit($id)
    {
        $qcm = Qcm::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'enseignant' || $qcm->enseignant_id !== $user->id) {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        return view('qcm.edit', compact('qcm'));
    }

    public function update(Request $request, $id)
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

    public function destroy($id)
    {
        $qcm = Qcm::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'enseignant' || $qcm->enseignant_id !== $user->id) {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $qcm->delete();

        return redirect()->route('qcm.index')->with('success', 'QCM supprimé avec succès.');
    }


    public function available()
    {
        $user = Auth::user();
        if ($user->role !== 'etudiant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $qcm = Qcm::with('enseignant')->latest()->paginate(10);
        return view('qcm.available', compact('qcm'));
    }

    
    public function take($id)
    {
        $qcm = Qcm::with('questions.options')->findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'etudiant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        return view('qcm.take', compact('qcm'));
    }


    public function submit(Request $request, $id)
    {
        $qcm = Qcm::with('questions.options')->findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'etudiant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $answers = $request->input('answers', []);
        $score = 0;
        $results = [];

        foreach ($qcm->questions as $question) {
            $userAnswerId = $answers[$question->id] ?? null;
            $correctOption = $question->options->where('is_correct', 1)->first();

            $isCorrect = $userAnswerId && $correctOption && $userAnswerId == $correctOption->id;

            if ($isCorrect) {
                $score++;
            }

            $userAnswerText = 'Non répondue';
            if ($userAnswerId) {
                $userAnswerOption = $question->options->find($userAnswerId);
                if ($userAnswerOption) {
                    $userAnswerText = $userAnswerOption->reponse;
                }
            }
            
            $correctAnswerText = $correctOption ? $correctOption->reponse : '—';

            $results[] = [
                'question_text' => $question->question,
                'user_answer_text' => $userAnswerText,
                'correct_answer_text' => $correctAnswerText,
                'is_correct' => $isCorrect,
            ];
        }

       
        Resultat::create([
            'qcm_id' => $qcm->id,
            'etudiant_id' => $user->id,
            'score' => $score,
            'total_questions' => count($qcm->questions),
        ]);

        return view('resultats.student', compact('qcm', 'results', 'score'));
    }
    public function myResults()
{
    $user = Auth::user();

    if ($user->role !== 'etudiant') {
        return redirect()->route('welcome')->with('error', 'Accès refusé.');
    }

    $resultats = Resultat::where('etudiant_id', $user->id)
                         ->with('qcm')
                         ->latest()
                         ->get();

    return view('resultats.student', compact('resultats'));
}
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Qcm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $questions = Question::with(['qcm', 'reponses'])->latest()->paginate(10);
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
            'qcm_id' => 'required|exists:qcm,id',
            'intitule' => 'required|string|max:255',
            'question' => 'nullable|string|max:1000',
            'choix' => 'required|array|min:2',
            'choix.*' => 'required|string|max:255',
            'reponse_correcte' => 'required|string',
        ]);

        $choixFiltres = array_values(array_filter($request->choix, function($choix) {
            return !empty(trim($choix));
        }));

        if (!in_array($request->reponse_correcte, $choixFiltres)) {
            return back()->withErrors(['reponse_correcte' => 'La réponse correcte doit être parmi les choix.'])->withInput();
        }

        DB::beginTransaction();
        
        try {
            $questionComplete = $request->intitule;
            if (!empty($request->question)) {
                $questionComplete .= "\n\n" . $request->question;
            }

            $question = Question::create([
                'qcm_id' => $request->qcm_id,
                'question' => $questionComplete,
            ]);

            foreach ($choixFiltres as $choix) {
                Reponse::create([
                    'question_id' => $question->id,
                    'reponse' => $choix,
                    'is_correct' => $choix === $request->reponse_correcte,
                ]);
            }

            DB::commit();
            
            return redirect()->route('questions.index')->with('success', 'Question créée avec succès.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Erreur lors de la création de la question.'])->withInput();
        }
    }

    public function show($id)
    {
        $question = Question::with(['qcm', 'reponses'])->findOrFail($id);
        return view('questions.show', compact('question'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $question = Question::with('reponses')->findOrFail($id);
        $qcm = Qcm::where('enseignant_id', $user->id)->get();
        
        $questionParts = explode("\n\n", $question->question, 2);
        $question->intitule = $questionParts[0];
        $question->description = isset($questionParts[1]) ? $questionParts[1] : '';
        
        $question->choix = $question->reponses->pluck('reponse')->toArray();
        $question->reponse_correcte = $question->reponses->where('is_correct', true)->first()->reponse ?? '';
        
        return view('questions.edit', compact('question', 'qcm'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $question = Question::findOrFail($id);

        $request->validate([
            'qcm_id' => 'required|exists:qcm,id',
            'intitule' => 'required|string|max:255',
            'question' => 'nullable|string|max:1000',
            'choix' => 'required|array|min:2',
            'choix.*' => 'required|string|max:255',
            'reponse_correcte' => 'required|string',
        ]);

        $choixFiltres = array_values(array_filter($request->choix, function($choix) {
            return !empty(trim($choix));
        }));

        if (!in_array($request->reponse_correcte, $choixFiltres)) {
            return back()->withErrors(['reponse_correcte' => 'La réponse correcte doit être parmi les choix.'])->withInput();
        }

        DB::beginTransaction();
        
        try {
            $questionComplete = $request->intitule;
            if (!empty($request->question)) {
                $questionComplete .= "\n\n" . $request->question;
            }

            $question->update([
                'qcm_id' => $request->qcm_id,
                'question' => $questionComplete,
            ]);

            $question->reponses()->delete();

            foreach ($choixFiltres as $choix) {
                Reponse::create([
                    'question_id' => $question->id,
                    'reponse' => $choix,
                    'is_correct' => $choix === $request->reponse_correcte,
                ]);
            }

            DB::commit();
            
            return redirect()->route('questions.index')->with('success', 'Question mise à jour avec succès.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Erreur lors de la mise à jour de la question.'])->withInput();
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $question = Question::findOrFail($id);

        $question->delete();
        
        return redirect()->route('questions.index')->with('success', 'Question supprimée.');
    }

    
    public function getStats($id)
    {
        $question = Question::with('reponses')->findOrFail($id);
        
        return response()->json([
            'question_id' => $question->id,
            'total_reponses' => $question->reponses->count(),
            'reponse_correcte' => $question->reponses->where('is_correct', true)->first()->reponse ?? null,
            'reponses' => $question->reponses->map(function($reponse) {
                return [
                    'id' => $reponse->id,
                    'texte' => $reponse->reponse,
                    'is_correct' => $reponse->is_correct
                ];
            })
        ]);
    }

    
    public function duplicate($id)
    {
        $user = Auth::user();
        if ($user->role !== 'enseignant') {
            return redirect()->route('welcome')->with('error', 'Accès refusé.');
        }

        $originalQuestion = Question::with('reponses')->findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            $newQuestion = Question::create([
                'qcm_id' => $originalQuestion->qcm_id,
                'question' => $originalQuestion->question . ' (Copie)',
            ]);

            foreach ($originalQuestion->reponses as $reponse) {
                Reponse::create([
                    'question_id' => $newQuestion->id,
                    'reponse' => $reponse->reponse,
                    'is_correct' => $reponse->is_correct,
                ]);
            }

            DB::commit();
            
            return redirect()->route('questions.edit', $newQuestion->id)
                           ->with('success', 'Question dupliquée avec succès. Vous pouvez maintenant la modifier.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('questions.index')
                           ->with('error', 'Erreur lors de la duplication de la question.');
        }
    }
}
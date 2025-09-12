<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Qcm;
use App\Models\Question;
use App\Models\Resultat;

class DashboardController extends Controller
{
    public function welcome()
    {
        $data = [];

        if (Auth::check()) {
           
            $user = Auth::user();

            if ($user->role === 'enseignant') {
                $data = [
                    'userQcmCount' => $user->qcm()->count(),
                    'userQuestionsCount' => Question::whereHas('qcm', fn($q) => $q->where('enseignant_id', $user->id))->count(),
                    'studentsCount' => User::where('role', 'etudiant')->count(),
                    'totalAttempts' => Resultat::whereHas('qcm', fn($q) => $q->where('enseignant_id', $user->id))->count(),
                ];
            } else {
                $userResults = $user->resultats();
                $data = [
                    'availableQcmCount' => Qcm::whereNotIn('id', $userResults->pluck('qcm_id'))->count(),
                    'completedQcmCount' => $userResults->count(),
                    'averageScore' => $userResults->count() > 0 ? $userResults->avg(DB::raw('score * 100 / total_questions')) : 0,
                    'bestScore' => $userResults->count() > 0 ? $userResults->max(DB::raw('score * 100 / total_questions')) : 0,
                    'recentResults' => $userResults->with('qcm')->latest()->take(5)->get(),
                ];
            }
        }

        return view('welcome', $data);
    }

    public function adminDashboard()
    {
       
        $user = Auth::user();

        $data = [
            'totalStudents' => User::where('role', 'etudiant')->count(),
            'totalQcm' => $user->qcm()->count(),
            'totalQuestions' => Question::whereHas('qcm', fn($q) => $q->where('enseignant_id', $user->id))->count(),
            'averageScore' => Resultat::whereHas('qcm', fn($q) => $q->where('enseignant_id', $user->id))
                ->avg(DB::raw('score * 100 / total_questions')) ?? 0,
            'recentQcm' => $user->qcm()->withCount(['questions', 'resultats'])->latest()->take(10)->get(),
            'recentResults' => Resultat::with(['etudiant', 'qcm'])
                ->whereHas('qcm', fn($q) => $q->where('enseignant_id', $user->id))
                ->latest()->take(10)->get(),
        ];

        return view('dashboardAdmin', $data);
    }

    public function studentDashboard()
    {
        return redirect()->route('welcome');
    }

    public function settings()
    {
        return view('settings');
    }
}

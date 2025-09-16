<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Qcm;
use App\Models\Question;
use App\Models\Resultat;

class DashboardController 
{
    public function welcome()
    {
        // If user is logged in, redirect to student dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard.student');
        }
        
        // Calculate statistics for the welcome page
        $stats = [
            'total_qcms' => Qcm::count(),
            'total_users' => User::where('role', 'etudiant')->count(),
            'total_questions' => Question::count(),
            'completion_rate' => $this->calculateCompletionRate(),
        ];
        
        // Get available QCMs for display (limit to 6 for the homepage)
        $availableQcms = Qcm::with(['enseignant', 'questions'])
            ->latest()
            ->take(6)
            ->get();
        
        return view('welcome', compact('stats', 'availableQcms'));
    }

    /**
     * Calculate the overall completion/success rate
     */
    private function calculateCompletionRate()
    {
        try {
            $totalResults = Resultat::count();
            if ($totalResults == 0) {
                return 0;
            }
            
            // Calculate average success rate based on scores
            $totalScore = Resultat::sum('score');
            $totalQuestions = Resultat::sum('total_questions');
            
            if ($totalQuestions > 0) {
                return round(($totalScore / $totalQuestions) * 100);
            }
            
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function EnseignantDashboard()
    {
        $user = Auth::user();

        $data = [
            'user' => $user,
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

        return view('DashboardEnseignant', $data);
    }

   
    public function studentDashboard()
    {
        $user = Auth::user();
        
        $completedQcmIds = collect();
        $userResults = collect();
        $availableQcm = collect();
        $recentActivities = collect();
        $questions = collect();
        
        try {
            if (method_exists($user, 'resultats')) {
                $userResults = $user->resultats()->with('qcm');
                $completedQcmIds = $userResults->pluck('qcm_id');
                $recentActivities = $userResults->latest()->take(5)->get()->map(function ($result) {
                    return (object) [
                        'qcm' => $result->qcm,
                        'status' => 'completed', 
                        'created_at' => $result->created_at,
                    ];
                });
            }
        } catch (\Exception $e) {
            
        }

       
        try {
            $availableQcm = Qcm::whereNotIn('id', $completedQcmIds)
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
           
        }


        try {
            $questions = Question::whereHas('qcm', function ($query) use ($completedQcmIds) {
                $query->whereNotIn('id', $completedQcmIds);
            })->with('qcm')->latest()->paginate(10);
        } catch (\Exception $e) {
         
        }


        $availableQcms = Qcm::count();
        $completedQcms = Resultat::where('etudiant_id', $user->id)->count(); 
        $totalScore = Resultat::where('etudiant_id', $user->id)->sum('score'); 
        $totalQuestions = Resultat::where('etudiant_id', $user->id)->sum('total_questions'); 
        $averageScore = 0;
        if ($totalQuestions > 0) {
            $averageScore = round(($totalScore / $totalQuestions) * 100);
        }

        $bestScore = Resultat::where('etudiant_id', $user->id)->max('score') ?? 0;

        $stats = [
            'available_qcms' => $availableQcms,
            'completed_qcms' => $completedQcms,
            'average_score' => $averageScore,
        ];

        $data = [
            'user' => $user,
            'availableQcmCount' => $availableQcm->count(),
            'completedQcmCount' => is_object($userResults) ? $userResults->count() : 0,
            'averageScore' => $averageScore,
            'bestScore' => $bestScore,
            'recentResults' => $recentActivities, 
            'recent_activities' => $recentActivities, 
            'availableQcm' => $availableQcm,
            'totalResultats' => is_object($userResults) ? $userResults->count() : 0,
            'stats' => $stats,
            'questions' => $questions, 
        ];

    
        return view('dashboardStudent', $data);
    }

    public function redirectToDashboard()
    {
        return redirect()->route('dashboard.student');
    }

    
}
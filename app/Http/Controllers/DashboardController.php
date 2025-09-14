<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        // If user is logged in, redirect to student dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard.student');
        }
        
        return view('welcome');
    }

    public function adminDashboard()
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

        return view('dashboardAdmin', $data);
    }

    /**
     * This is the main method that renders dashboardStudent.blade.php
     */
    public function studentDashboard()
    {
        $user = Auth::user();
        
        // Initialize default values
        $completedQcmIds = collect();
        $userResults = collect();
        $availableQcm = collect();
        $recentActivities = collect();
        $questions = collect();
        
        // Try to get user results safely
        try {
            if (method_exists($user, 'resultats')) {
                $userResults = $user->resultats()->with('qcm');
                $completedQcmIds = $userResults->pluck('qcm_id');
                // Fetch recent activities (latest 5 results)
                $recentActivities = $userResults->latest()->take(5)->get()->map(function ($result) {
                    return (object) [
                        'qcm' => $result->qcm,
                        'status' => 'completed', // Assuming all results are completed; adjust if status column exists
                        'created_at' => $result->created_at,
                    ];
                });
            }
        } catch (\Exception $e) {
            // Handle case where relationship doesn't exist yet
        }

        // Try to get available QCM safely
        try {
            $availableQcm = Qcm::whereNotIn('id', $completedQcmIds)
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // Handle case where QCM model doesn't exist yet
        }

        // Try to get available questions safely
        try {
            $questions = Question::whereHas('qcm', function ($query) use ($completedQcmIds) {
                $query->whereNotIn('id', $completedQcmIds);
            })->with('qcm')->latest()->paginate(10);
        } catch (\Exception $e) {
            // Handle case where Question model or relationship doesn't exist yet
        }

        // Calculate new statistics
        $availableQcms = Qcm::count(); // Count all available QCMs
        $completedQcms = Resultat::where('etudiant_id', $user->id)->count(); // Fixed column name
        // Calculate average score in percentage
        $totalScore = Resultat::where('etudiant_id', $user->id)->sum('score'); // Fixed column name
        $totalQuestions = Resultat::where('etudiant_id', $user->id)->sum('total_questions'); // Fixed column name
        $averageScore = 0;
        if ($totalQuestions > 0) {
            $averageScore = round(($totalScore / $totalQuestions) * 100);
        }

        // Calculate best score
        $bestScore = Resultat::where('etudiant_id', $user->id)->max('score') ?? 0;

        // Assemble stats array
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
            'recentResults' => $recentActivities, // Updated to use recent activities
            'recent_activities' => $recentActivities, // Match view expectation
            'availableQcm' => $availableQcm,
            'totalResultats' => is_object($userResults) ? $userResults->count() : 0,
            'stats' => $stats,
            'questions' => $questions, // Add paginated questions
        ];

        // This will render views/dashboardStudent.blade.php
        return view('dashboardStudent', $data);
    }

    public function redirectToDashboard()
    {
        // Always redirect to student dashboard
        return redirect()->route('dashboard.student');
    }

    public function settings()
    {
        $user = Auth::user();
        return view('settings', compact('user'));
    }
}
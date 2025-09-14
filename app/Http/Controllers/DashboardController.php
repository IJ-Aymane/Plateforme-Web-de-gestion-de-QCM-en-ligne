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
        
        // Try to get user results safely
        try {
            if (method_exists($user, 'resultats')) {
                $userResults = $user->resultats();
                $completedQcmIds = $userResults->pluck('qcm_id');
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
        
        $data = [
            'user' => $user,
            'availableQcmCount' => $availableQcm->count(),
            'completedQcmCount' => is_object($userResults) ? $userResults->count() : 0,
            'averageScore' => 0, // Default to 0 for now
            'bestScore' => 0,    // Default to 0 for now
            'recentResults' => collect(), // Empty collection for now
            'availableQcm' => $availableQcm,
            'totalResultats' => is_object($userResults) ? $userResults->count() : 0,
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
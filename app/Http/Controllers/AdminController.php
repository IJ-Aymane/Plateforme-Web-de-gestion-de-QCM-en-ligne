<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Qcm;
use App\Models\Resultat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Admin dashboard home
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * List all users (students + teachers)
     */
    public function users()
    {
        $users = User::where('role', '!=', 'admin') // Don't show admin users
                    ->orderBy('nom')
                    ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user (student or teacher)
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:etudiant,enseignant',
        ]);

        User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Delete a user (student or teacher)
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting admin
        if ($user->role === 'admin') {
            return back()->withErrors(['error' => 'Impossible de supprimer un administrateur.']);
        }

        // Optional: Also delete their QCMs and results if desired
        $user->qcms()->delete();   // Deletes QCMs created by this teacher
        $user->resultats()->delete(); // Deletes results taken by this student

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * List all QCMs (admin can delete any)
     */
    public function qcms()
    {
        $qcms = Qcm::with('enseignant')
                   ->latest()
                   ->paginate(15);

        return view('admin.qcms.index', compact('qcms'));
    }

    /**
     * Delete any QCM (even if created by teacher)
     */
    public function destroyQcm($id)
    {
        $qcm = Qcm::findOrFail($id);
        $qcm->questions()->with('options')->delete(); // Cascade delete questions and options
        $qcm->resultats()->delete(); // Delete all results linked to this QCM
        $qcm->delete();

        return back()->with('success', 'QCM supprimé avec succès et tous ses contenus détruits.');
    }

    /**
     * View all results system-wide
     */
    public function results()
    {
        $resultats = Resultat::with(['etudiant', 'qcm'])
                             ->latest()
                             ->paginate(20);

        return view('admin.results.index', compact('resultats'));
    }
}
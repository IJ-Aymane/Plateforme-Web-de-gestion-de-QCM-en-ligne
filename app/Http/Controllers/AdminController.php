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
     * Display admin dashboard
     */
    public function index()
    {
        // Changed from view('admin.dashboard') to view('DashboardAdmin')
        return view('DashboardAdmin');
    }

    /**
     * Display all users (except admins)
     */
    public function users()
    {
        $users = User::where('role', '!=', 'admin')
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
     * Store new user
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
     * Delete user and associated data
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->withErrors(['error' => 'Impossible de supprimer un administrateur.']);
        }

        // Delete associated QCMs and results
        $user->qcms()->delete();   
        $user->resultats()->delete(); 

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Display all QCMs
     */
    public function qcms()
    {
        $qcms = Qcm::with('enseignant')
                   ->latest()
                   ->paginate(15);

        return view('admin.qcms.index', compact('qcms'));
    }

    /**
     * Delete QCM and all associated data
     */
    public function destroyQcm($id)
    {
        $qcm = Qcm::findOrFail($id);
        
        // Cascade delete questions and options
        $qcm->questions()->with('options')->delete(); 
        
        // Delete all results linked to this QCM
        $qcm->resultats()->delete(); 
        
        $qcm->delete();

        return back()->with('success', 'QCM supprimé avec succès et tous ses contenus détruits.');
    }

    /**
     * Display all results
     */
    public function results()
    {
        $resultats = Resultat::with(['etudiant', 'qcm'])
                             ->latest()
                             ->paginate(20);

        return view('admin.results.index', compact('resultats'));
    }
}
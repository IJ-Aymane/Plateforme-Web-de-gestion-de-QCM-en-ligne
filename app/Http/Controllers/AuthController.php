<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController 
{
    /**
     * Display the login view.
     */
    public function showLogin(): View
    {
        return view('login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
             $user = Auth::user();

        return match ($user->role) {
            'etudiant' => redirect()->route('dashboard.student'),
            'enseignant' => redirect()->route('dashboard.Enseignant'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('welcome')->with('error', 'Rôle non reconnu.'),
        };
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Déconnexion réussie.');
    }

    /**
     * Display the registration view.
     */
    public function showRegister(Request $request): View
    {
        $role = $request->get('role', 'etudiant');
        return view('register', compact('role'));
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:enseignant,etudiant'],
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);
        
       
        
    return match ($user->role) {
        'etudiant' => redirect()->route('dashboard.student')->with('success', 'Compte créé avec succès.'),
        'enseignant' => redirect()->route('dashboard.Enseignant')->with('success', 'Compte créé avec succès.'),
        'enseignant' => redirect()->route('dashboard.Enseignant')->with('success', 'Compte créé avec succès.'),
        default => redirect()->route('welcome')->with('error', 'Rôle non reconnu.'),
    };

    }
}
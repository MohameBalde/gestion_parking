<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }
        $utilisateurs = \App\Models\User::all();
        return view('utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Valide un utilisateur (admin only)
     */
    public function approve($id)
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }
        $user = \App\Models\User::findOrFail($id);
        $user->is_approved = true;
        $user->save();
        // Log activité
        if(auth()->check()) {
            Activity::create([
                'user_id' => auth()->id(),
                'action' => 'validation utilisateur',
                'description' => 'Validation du compte utilisateur ID ' . $user->id . ' (' . $user->email . ')',
            ]);
        }
        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur validé avec succès.');
    }

    /**
     * Refuse un utilisateur (admin only)
     */
    public function reject($id)
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }
        $user = \App\Models\User::findOrFail($id);
        if (!$user->is_approved) {
            $user->delete();
            // Log activité
            if(auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'refus utilisateur',
                    'description' => 'Refus/suppression du compte utilisateur ID ' . $user->id . ' (' . $user->email . ')',
                ]);
            }
            return redirect()->route('utilisateurs.index')->with('success', 'Compte refusé et supprimé.');
        }
        return redirect()->route('utilisateurs.index')->with('error', 'Impossible de refuser un compte déjà validé.');
    }

    /**
     * Active ou désactive un utilisateur (admin only)
     */
    public function toggleActive($id)
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }
        $user = \App\Models\User::findOrFail($id);
        // L'admin ne peut pas se désactiver lui-même
        if ($user->is_admin && auth()->user()->id === $user->id) {
            return redirect()->route('utilisateurs.index')->with('error', 'Vous ne pouvez pas désactiver votre propre compte administrateur.');
        }
        $user->is_active = !$user->is_active;
        $user->save();
        // Log activité
        if(auth()->check()) {
            Activity::create([
                'user_id' => auth()->id(),
                'action' => ($user->is_active ? 'réactivation utilisateur' : 'désactivation utilisateur'),
                'description' => (($user->is_active ? 'Réactivation' : 'Désactivation') . ' du compte utilisateur ID ' . $user->id . ' (' . $user->email . ')'),
            ]);
        }
        return redirect()->route('utilisateurs.index')->with('success', 'Statut du compte mis à jour.');
    }

    /**
     * Affiche l'historique des activités d'un utilisateur (admin only)
     */
    public function activities($id)
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }
        $user = \App\Models\User::findOrFail($id);
        $activities = $user->activities()->latest()->get();
        return view('utilisateurs.activities', compact('user', 'activities'));
    }
}

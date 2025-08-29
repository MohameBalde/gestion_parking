<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\Activity;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Vehicule::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('plaque')) {
            $query->where('plaque', 'like', '%' . $request->plaque . '%');
        }

        $vehicules = $query->get();
        return view('vehicules.index', compact('vehicules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehicules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'plaque' => 'required|unique:vehicules,plaque',
            'date_entree' => 'nullable|date',
            'statut_paiement' => 'required',
        ]);
        $vehicule = Vehicule::create($request->all());

        // Ajout à l'historique
        \App\Models\HistoriqueVehicule::create([
            'vehicule_id' => $vehicule->id,
            'type' => $vehicule->type,
            'plaque' => $vehicule->plaque,
            'date_entree' => $vehicule->date_entree,
            'action' => 'ajout',
            'date_action' => now(),
        ]);

        // Log activité
        if(auth()->check()) {
            Activity::create([
                'user_id' => auth()->id(),
                'action' => 'ajout véhicule',
                'description' => 'Ajout du véhicule ID ' . $vehicule->id . ' (plaque: ' . $vehicule->plaque . ')',
            ]);
        }

        return redirect()->route('vehicules.index')->with('success', 'Véhicule ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        return view('vehicules.show', compact('vehicule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        return view('vehicules.edit', compact('vehicule'));
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
        $vehicule = Vehicule::findOrFail($id);
        $request->validate([
            'type' => 'required',
            'plaque' => 'required|unique:vehicules,plaque,' . $vehicule->id,
            'date_entree' => 'nullable|date',
            'statut_paiement' => 'required',
        ]);
        $vehicule->update($request->all());

        // Ajout à l'historique
        \App\Models\HistoriqueVehicule::create([
            'vehicule_id' => $vehicule->id,
            'type' => $vehicule->type,
            'plaque' => $vehicule->plaque,
            'date_entree' => $vehicule->date_entree,
            'date_sortie' => $vehicule->date_sortie ?? null,
            'action' => 'modification',
            'date_action' => now(),
        ]);

        // Log activité
        if(auth()->check()) {
            Activity::create([
                'user_id' => auth()->id(),
                'action' => 'modification véhicule',
                'description' => 'Modification du véhicule ID ' . $vehicule->id . ' (plaque: ' . $vehicule->plaque . ')',
            ]);
        }

        return redirect()->route('vehicules.index')->with('success', 'Véhicule modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        // Ajout à l'historique avant suppression
        \App\Models\HistoriqueVehicule::create([
            'vehicule_id' => $vehicule->id,
            'type' => $vehicule->type,
            'plaque' => $vehicule->plaque,
            'date_entree' => $vehicule->date_entree,
            'date_sortie' => $vehicule->date_sortie ?? null,
            'action' => 'suppression',
            'date_action' => now(),
        ]);
        $vehicule->delete();

        // Log activité
        if(auth()->check()) {
            Activity::create([
                'user_id' => auth()->id(),
                'action' => 'suppression véhicule',
                'description' => 'Suppression du véhicule ID ' . $vehicule->id . ' (plaque: ' . $vehicule->plaque . ')',
            ]);
        }

        return redirect()->route('vehicules.index')->with('success', 'Véhicule supprimé avec succès.');
    }
}

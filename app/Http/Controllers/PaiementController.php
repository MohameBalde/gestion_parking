<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = \App\Models\Paiement::query();
        if ($request->filled('vehicule_id')) {
            $query->where('vehicule_id', $request->vehicule_id);
        }
        if ($request->filled('plaque')) {
            $query->whereHas('vehicule', function($q) use ($request) {
                $q->where('plaque', 'like', '%' . $request->plaque . '%');
            });
        }
        // Filtrage par mois
        $mois = $request->input('mois');
        if ($mois) {
            $query->whereMonth('date_paiement', substr($mois, 5, 2))
                  ->whereYear('date_paiement', substr($mois, 0, 4));
        }
        $paiements = $query->orderBy('date_paiement', 'desc')->get();

        // Liste des mois disponibles dans les paiements
        $mois_disponibles = \App\Models\Paiement::selectRaw('DATE_FORMAT(date_paiement, "%Y-%m") as mois')
            ->groupBy('mois')
            ->orderBy('mois', 'desc')
            ->pluck('mois');

        // Calcul du total par mois (pour tous les mois présents dans la liste filtrée)
        $totaux_par_mois = \App\Models\Paiement::selectRaw('DATE_FORMAT(date_paiement, "%Y-%m") as mois, SUM(montant) as total')
            ->groupBy('mois')
            ->orderBy('mois', 'desc')
            ->pluck('total', 'mois');

        return view('paiements.index', compact('paiements', 'mois_disponibles', 'mois', 'totaux_par_mois'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicules = \App\Models\Vehicule::all();
        return view('paiements.create', compact('vehicules'));
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
            'vehicule_id' => 'required|exists:vehicules,id',
            'montant' => 'required|numeric',
            'date_paiement' => 'required|date',
            'statut' => 'required|string',
        ]);

        $paiement = \App\Models\Paiement::create($request->all());

        // Log activité
        if(auth()->check()) {
            Activity::create([
                'user_id' => auth()->id(),
                'action' => 'ajout paiement',
                'description' => 'Ajout du paiement ID ' . $paiement->id . ' pour véhicule ID ' . $paiement->vehicule_id,
            ]);
        }

        // Ajout à l'historique
        \App\Models\HistoriquePaiement::create([
            'paiement_id' => $paiement->id,
            'vehicule_id' => $paiement->vehicule_id,
            'montant' => $paiement->montant,
            'date_paiement' => $paiement->date_paiement,
            'statut' => $paiement->statut,
            'action' => 'ajout',
            'date_action' => now(),
        ]);

        return redirect()->route('paiements.index')->with('success', 'Paiement ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paiement = \App\Models\Paiement::findOrFail($id);
        return view('paiements.show', compact('paiement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paiement = \App\Models\Paiement::findOrFail($id);
        return view('paiements.edit', compact('paiement'));
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
        $paiement = \App\Models\Paiement::findOrFail($id);
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'montant' => 'required|numeric',
            'date_paiement' => 'required|date',
            'statut' => 'required|string',
        ]);
        $paiement->update($request->all());

        // Log activité
        if(auth()->check()) {
            Activity::create([
                'user_id' => auth()->id(),
                'action' => 'modification paiement',
                'description' => 'Modification du paiement ID ' . $paiement->id . ' pour véhicule ID ' . $paiement->vehicule_id,
            ]);
        }

        // Ajout à l'historique
        \App\Models\HistoriquePaiement::create([
            'paiement_id' => $paiement->id,
            'vehicule_id' => $paiement->vehicule_id,
            'montant' => $paiement->montant,
            'date_paiement' => $paiement->date_paiement,
            'statut' => $paiement->statut,
            'action' => 'modification',
            'date_action' => now(),
        ]);

        return redirect()->route('paiements.index')->with('success', 'Paiement modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paiement = \App\Models\Paiement::findOrFail($id);
        // Log activité
        if(auth()->check()) {
            Activity::create([
                'user_id' => auth()->id(),
                'action' => 'suppression paiement',
                'description' => 'Suppression du paiement ID ' . $paiement->id . ' pour véhicule ID ' . $paiement->vehicule_id,
            ]);
        }
        // Ajout à l'historique avant suppression
        \App\Models\HistoriquePaiement::create([
            'paiement_id' => $paiement->id,
            'vehicule_id' => $paiement->vehicule_id,
            'montant' => $paiement->montant,
            'date_paiement' => $paiement->date_paiement,
            'statut' => $paiement->statut,
            'action' => 'suppression',
            'date_action' => now(),
        ]);
        $paiement->delete();
        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès.');
    }
}

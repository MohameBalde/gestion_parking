<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoriquePaiementController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\HistoriquePaiement::query();
        if ($request->filled('paiement_id')) {
            $query->where('paiement_id', $request->paiement_id);
        }
        if ($request->filled('vehicule_id')) {
            $query->where('vehicule_id', $request->vehicule_id);
        }
        if ($request->filled('plaque')) {
            $query->whereHas('vehicule', function($q) use ($request) {
                $q->where('plaque', 'like', '%' . $request->plaque . '%');
            });
        }
        $historiques = $query->get();
        return view('historiques_paiements.index', compact('historiques'));
    }

    public function show($id)
    {
        $historique = \App\Models\HistoriquePaiement::findOrFail($id);
        return view('historiques_paiements.show', compact('historique'));
    }
}

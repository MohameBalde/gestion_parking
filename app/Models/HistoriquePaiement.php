<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriquePaiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'paiement_id', 'vehicule_id', 'montant', 'date_paiement', 'statut', 'action', 'date_action'
    ];
}

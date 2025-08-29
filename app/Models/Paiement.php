<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicule_id', 'montant', 'date_paiement', 'statut'
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}

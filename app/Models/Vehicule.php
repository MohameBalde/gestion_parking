<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'plaque', 'date_entree', 'statut_paiement'
    ];

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function historiques()
    {
        return $this->hasMany(HistoriqueVehicule::class);
    }
}

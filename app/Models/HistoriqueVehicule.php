<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueVehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicule_id', 'type', 'plaque', 'date_entree', 'date_sortie', 'action', 'date_action'
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = [
        'commande_id',
        'facture_path',
        'montant_total',
        'date_emission',
    ];

    protected $casts = [
        'date_emission' => 'datetime',
    ];

    /**
     * La commande associée à cette facture.
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}

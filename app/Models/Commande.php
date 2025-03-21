<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    // Spécifie les attributs modifiables
    protected $fillable = [
        'user_id',
        'total',
        'statut',
    ];

    // Relation avec l'utilisateur (client)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les produits (avec la table pivot details_commandes)
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'details_commandes')
                    ->withPivot('quantite', 'prix', 'total');
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }

}
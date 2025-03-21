<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    // Définir les attributs que l'on peut remplir (mass assignment)
    protected $fillable = ['nom', 'prix', 'image', 'description', 'stock', 'archived', 'categorie'];

    /**
     * Récupérer l'URL de l'image du produit.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

    // Scope pour récupérer uniquement les produits actifs
    public function scopeActifs($query)
    {
        return $query->where('archived', false);
    }

    // Fonction pour archiver/désarchiver un produit
    public function toggleArchive()
    {
        $this->archived = !$this->archived;
        $this->save();
    }
}
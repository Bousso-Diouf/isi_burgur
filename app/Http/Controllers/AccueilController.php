<?php 

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index(Request $request)
    {
        // On commence par définir la requête
        $query = Produit::query();

        // Si une recherche par nom est effectuée
        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        // Si une recherche par prix minimum est effectuée
        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }

        // Si une recherche par prix maximum est effectuée
        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        // Récupération des produits après application des filtres
        $produits = $query->orderBy('created_at', 'desc')->get();

        // Retour à la vue avec les produits filtrés
        return view('accueil', compact('produits'));
    }
}

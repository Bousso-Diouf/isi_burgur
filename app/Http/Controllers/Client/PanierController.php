<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    // Afficher le panier
    public function index()
    {
        // Récupérer les produits du panier stockés dans la session
        $panier = session()->get('panier', []);

        // Vérification pour éviter l'erreur "undefined array key"
        if (empty($panier)) {
            return view('client.panier', ['panier' => []]);
        }

        return view('client.panier', compact('panier'));
    }

    // Ajouter un produit au panier
    public function ajouter(Produit $produit)
    {
        // Récupérer le panier existant
        $panier = session()->get('panier', []);

        // Vérifier si le produit est déjà dans le panier
        if (isset($panier[$produit->id])) {
            $panier[$produit->id]['quantite']++;
        } else {
            // Ajouter le produit au panier avec une quantité de 1 et l'id du produit
            $panier[$produit->id] = [
                'id' => $produit->id, // Ajouter l'ID du produit
                'nom' => $produit->nom,
                'prix' => $produit->prix,
                'quantite' => 1,
            ];
        }

        // Sauvegarder le panier dans la session
        session()->put('panier', $panier);

        return redirect()->route('accueil')->with('success', 'Produit ajouté au panier');
    }

    // Supprimer un produit du panier
    public function supprimer($id)
    {
        // Vérifier si le panier existe dans la session
        $panier = session()->get('panier', []);

        // Si le produit existe dans le panier, le supprimer
        if (isset($panier[$id])) {
            unset($panier[$id]);
        }

        // Re-enregistrer le panier dans la session
        session()->put('panier', $panier);

        return redirect()->route('panier.index')->with('success', 'Produit supprimé du panier.');
    }

    // Mettre à jour la quantité d'un produit dans le panier
    public function mettreAJour($id, Request $request)
    {
        // Valider la quantité
        $validated = $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        // Récupérer le panier depuis la session
        $panier = session()->get('panier', []);

        // Vérifier si le produit est dans le panier
        if (isset($panier[$id])) {
            // Mettre à jour la quantité du produit
            $panier[$id]['quantite'] = $validated['quantite'];

            // Réactualiser le panier dans la session
            session()->put('panier', $panier);
        }

        return redirect()->route('panier.index')->with('success', 'Quantité mise à jour.');
    }

    public function valider(Request $request)
    {
        $panier = session('panier', []);
        
        if (empty($panier)) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        // Vérifier si tous les produits ont un stock suffisant AVANT d'enregistrer la commande
        foreach ($panier as $produit) {
            $produitModel = Produit::find($produit['id']);

            if (!$produitModel) {
                return redirect()->route('panier.index')->with('error', 'Produit introuvable : ' . $produit['nom']);
            }

            if ($produitModel->stock < $produit['quantite']) {
                return redirect()->route('panier.index')->with('error', 'Stock insuffisant pour : ' . $produit['nom']);
            }
        }

        // Maintenant qu'on est sûr que tous les produits sont disponibles, on peut créer la commande
        $commande = new Commande();
        $commande->user_id = Auth::user()->id;
        $commande->total = array_sum(array_map(function ($produit) {
            return $produit['prix'] * $produit['quantite'];
        }, $panier));
        $commande->statut = 'En attente';
        $commande->save();

        // Ajouter les produits à la table 'details_commandes'
        foreach ($panier as $produit) {
            $produitModel = Produit::find($produit['id']);

            // Insérer les détails de la commande
            $commande->produits()->attach($produit['id'], [
                'quantite' => $produit['quantite'],
                'prix' => $produit['prix'],
                'total' => $produit['prix'] * $produit['quantite'],
                'prix_unitaire' => $produit['prix'],
            ]);

            // Réduire le stock après validation de la commande
            $produitModel->stock -= $produit['quantite'];
            $produitModel->save();
        }

        // Vider le panier
        session()->forget('panier');

        return redirect()->route('client.dashboard')->with('success', 'Votre commande a été passée avec succès.');
    }
}
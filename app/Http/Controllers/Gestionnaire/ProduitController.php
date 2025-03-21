<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Exception;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::query();

        // Si l'utilisateur est un gestionnaire, il peut voir tous les produits
        if (Auth::user()->role === 'gestionnaire') {
            // Le gestionnaire voit tous les produits (archivés ou non)
            $produits = $query->orderBy('created_at', 'desc')->get();
        } else {
            // Les clients ne voient que les produits non archivés
            $produits = $query->where('archived', false)
                            ->orderBy('created_at', 'desc')
                            ->get();
        }

        // Si une recherche est effectuée
        if ($request->filled('search')) {
            $produits = $produits->filter(function ($produit) use ($request) {
                return str_contains(strtolower($produit->nom), strtolower($request->search));
            });
        }

        $count = $produits->count();

        // Si une recherche a été faite, afficher le nombre de résultats
        if ($request->filled('search') && !session()->has('info')) {
            session()->flash('info', "$count résultats obtenus pour \"{$request->input('search')}\"");
        }

        return view('gestionnaire.produits.index', compact('produits'));
    }


    // Afficher le formulaire de création
    public function create()
    {
        return view('gestionnaire.produits.create');
    }

    // Sauvegarder un produit dans la base de données
    public function store(Request $request)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'categorie' => 'required|string|in:Burgers,Boissons,Desserts',
                'prix' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096', // Image valide avec taille max 4Mo
                'description' => 'required|string|max:1000',
            ]);

            // Gestion de l'image
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension(); // Nom unique pour l'image
                $request->image->move(public_path('produits'), $imageName); // Déplacement dans le répertoire public/produits
                $validatedData['image'] = 'produits/' . $imageName; // Enregistrement du chemin
            }

            // Créer le produit
            Produit::create($validatedData);

            // Rediriger après la création avec un message de succès
            return redirect()->route('gestionnaire.produits.index')->with('success', 'Produit ajouté avec succès.');
        } catch (Exception $e) {
            // Gestion des erreurs
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    // Afficher le formulaire de modification
    public function edit(Produit $produit)
    {
        return view('gestionnaire.produits.edit', compact('produit'));
    }

    // Mettre à jour un produit existant
    public function update(Request $request, Produit $produit)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'categorie' => 'required|string|in:Burgers,Boissons,Desserts',
                'prix' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096', // Image valide avec taille max 4Mo
                'description' => 'required|string|max:1000',
            ]);

            // Gestion de l'image
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image si elle existe
                if ($produit->image) {
                    unlink(public_path($produit->image)); // Supprimer l'image existante
                }

                // Déplacer la nouvelle image
                $imageName = time() . '.' . $request->image->extension(); // Nom unique pour l'image
                $request->image->move(public_path('produits'), $imageName); // Déplacer dans public/produits
                $validatedData['image'] = 'produits/' . $imageName; // Enregistrer le chemin de la nouvelle image
            } else {
                // Si aucune nouvelle image n'est téléchargée, garder l'ancienne
                $validatedData['image'] = $produit->image;
            }

            // Mettre à jour le produit
            $produit->update($validatedData);

            // Rediriger après la mise à jour avec un message de succès
            return redirect()->route('gestionnaire.produits.index')->with('success', 'Produit mis à jour avec succès.');
        } catch (Exception $e) {
            // Gestion des erreurs
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    // Supprimer un produit
    public function destroy(Produit $produit)
    {
        try {
            // Supprimer l'image du produit si elle existe
            if ($produit->image) {
                unlink(public_path($produit->image)); // Supprimer l'image existante
            }

            // Supprimer le produit de la base de données
            $produit->delete();

            // Rediriger après la suppression avec un message de succès
            return redirect()->route('gestionnaire.produits.index')->with('success', 'Produit supprimé avec succès.');
        } catch (Exception $e) {
            // Gestion des erreurs
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $produit = Produit::findOrFail($id); // Récupère le produit par son ID

        return view('produits.show', compact('produit')); // Passe le produit à la vue
    }

    // Archiver un produit
    public function archiver(Produit $produit)
    {
        // Si le produit est déjà archivé, on le réactive, sinon on l'archive
        $produit->archived = !$produit->archived;
        $produit->save();

        // Retourner avec un message de succès
        return redirect()->route('gestionnaire.produits.index')->with('success', 'Produit mis à jour avec succès.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Facture;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\FactureMail;

class CommandeController extends Controller
{
    // Affichage des commandes du client
    public function index()
    {
        $commandes = Commande::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('client.commandes', compact('commandes'));
    }

    // Affichage de toutes les commandes pour le gestionnaire
    public function gestionnaireIndex()
    {
        $commandes = Commande::orderBy('created_at', 'desc')->get();
        return view('gestionnaire.commandes.index', compact('commandes'));
    }

    public function show($id)
    {
        $commande = Commande::with('produits')->findOrFail($id);
        return view('client.commande_details', compact('commande'));
    }

    // Mise à jour du statut de la commande
    public function updateStatut(Request $request, Commande $commande)
    {
        $nouveauStatut = $request->input('statut');

        // Vérification si la commande est déjà payée
        if ($commande->statut === 'Payée') {
            return redirect()->back()->with('error', 'Impossible de modifier une commande payée.');
        }

        // Mise à jour du statut de la commande
        $commande->update(['statut' => $nouveauStatut]);

        // Si le statut passe à "Prête", générer et envoyer la facture
        if ($nouveauStatut === 'Prête') {
            // Générer et enregistrer la facture en BD
            $this->genererFacturePDF($commande);

            // Générer le PDF de la facture
            $pdf = PDF::loadView('factures.facture', compact('commande'));

            // Enregistrer le PDF dans le dossier storage
            $fileName = 'facture_' . $commande->id . '.pdf';
            $path = storage_path('app/public/factures/' . $fileName);
            $pdf->save($path);

            try {
                // Envoyer la facture par email au client
                Mail::to($commande->user->email)->send(new FactureMail($commande, $path));
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Erreur lors de l\'envoi du mail, verifiez votre email!');
            }
        }

        return redirect()->back()->with('success', 'Statut mis à jour.');
    }

    // Annuler une commande
    public function annuler(Commande $commande)
    {
        if ($commande->statut === 'Payée') {
            return redirect()->back()->with('error', 'Impossible d’annuler une commande déjà payée.');
        }

        if ($commande->statut === 'Annulée') {
            return redirect()->back()->with('info', 'Cette commande est déjà annulée.');
        }

        // Mise à jour du statut de la commande
        $commande->update(['statut' => 'Annulée']);

        // Rendre les produits disponibles à nouveau
        foreach ($commande->produits as $produit) {
            $produit->increment('stock', $produit->pivot->quantite);
        }

        return redirect()->back()->with('success', 'La commande a été annulée avec succès.');
    }

    // Dans CommandeController.php
    public function gestionnaireShow(Commande $commande)
    {
        // Vérifier si la commande appartient au gestionnaire ou si l'utilisateur est un gestionnaire
        if (Auth::user()->role !== 'gestionnaire') {
            abort(403, 'Accès interdit');
        }

        // Retourner la vue pour afficher la commande
        return view('gestionnaire.commandes.show', compact('commande'));
    }

    public function genererFacturePDF(Commande $commande)
    {
        // Générer le PDF avec les détails de la commande
        $pdf = PDF::loadView('factures.facture', compact('commande'));

        // Enregistrer le PDF dans le répertoire public
        $facturePath = public_path('factures/facture_' . $commande->id . '.pdf'); // ✅ Met dans "public/factures/"
        $pdf->save($facturePath);

        // Créer un enregistrement de la facture dans la base de données
        Facture::create([
            'commande_id' => $commande->id,
            'facture_path' => 'factures/facture_' . $commande->id . '.pdf', // ✅ Chemin public
            'montant_total' => $commande->total,
            'date_emission' => now(),
        ]);
        
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactureController extends Controller
{
    public function index()
    {
        // Vérifier que l'utilisateur est un client
        if (Auth::user()->role !== 'client') {
            abort(403, 'Accès interdit');
        }

        // Récupérer toutes les commandes du client avec la facture associée
        $factures = Facture::whereHas('commande', function ($query) {
            $query->where('user_id', Auth::id());
        })->orderBy('created_at', 'desc')->get();

        return view('client.factures.index', compact('factures'));
    }

    public function gestionnaireIndex()
    {
        // Vérification du rôle de l'utilisateur
        if (Auth::user()->role !== 'gestionnaire') {
            abort(403, 'Accès interdit');
        }

        // Pour le gestionnaire : afficher toutes les factures avec pagination
        $factures = Facture::paginate(10); // Pagination pour le gestionnaire
        return view('gestionnaire.factures.index', compact('factures'));
    }
}
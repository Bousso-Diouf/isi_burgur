<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardGestionnaireController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        // Nombre total de commandes du jour (hors annulées)
        $nombreCommandesDuJour = Commande::whereDate('created_at', Carbon::today())
            ->count();

        // Nombre de commandes payées du jour
        $nombreCommandesPayees = Commande::whereDate('created_at', Carbon::today())
            ->where('statut', 'payée')
            ->count();

        // Recettes totales de la journée (somme des montants des commandes payées)
        $recettesJournalieres = Commande::whereDate('created_at', Carbon::today())
            ->where('statut', 'payée')
            ->sum('total');

        
        // Récupérer le nombre de commandes par mois pour l'année en cours
        $commandesParMois = Commande::whereYear('created_at', Carbon::now()->year)
            ->selectRaw('MONTH(created_at) as mois, count(*) as total_commandes')
            ->groupBy('mois')
            ->orderBy('mois')
            ->pluck('total_commandes', 'mois');

        // Préparer les labels (mois) et les données pour Chart.js
        $moisLabels = [];
        $commandesData = [];

        for ($i = 1; $i <= 12; $i++) {
            $moisLabels[] = Carbon::create()->month($i)->format('F');
            $commandesData[] = $commandesParMois[$i] ?? 0;
        }


        #########

        // Récupérer les commandes par catégorie et par mois
        $produitsParCategorieMois = Commande::whereYear('commandes.created_at', Carbon::now()->year)
        ->where('commandes.statut', 'payée')
        ->join('details_commandes', 'commandes.id', '=', 'details_commandes.commande_id') // Jointure avec la table pivot
        ->join('produits', 'details_commandes.produit_id', '=', 'produits.id') // Jointure avec la table produits
        ->selectRaw('MONTH(commandes.created_at) as mois, produits.categorie, SUM(details_commandes.quantite) as total')
        ->groupBy('mois', 'produits.categorie')
        ->orderBy('mois')
        ->get();


        // Initialisation des données pour le graphique
        $categories = ['Burgers', 'Boissons', 'Desserts'];
        $moisLabel = [];
        $chartData = [];

        // Initialisation du tableau des valeurs pour chaque catégorie
        foreach ($categories as $categorie) {
            $chartData[$categorie] = array_fill(0, 12, 0);
        }

        // Stocker les données de la base
        foreach ($produitsParCategorieMois as $data) {
            $chartData[$data->categorie][$data->mois - 1] = $data->total;
        }

        for ($i = 1; $i <= 12; $i++) {
            $moisLabel[] = Carbon::create()->month($i)->format('F');
        }

        
        return view('gestionnaire.dashboard', compact(
            'nombreCommandesDuJour',
            'nombreCommandesPayees',
            'recettesJournalieres',
            'moisLabels',
            'commandesData',
            'moisLabel',
            'chartData'
        ));
    }
}
<?php

use App\Http\Controllers\Gestionnaire\ProduitController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\GestionnaireMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\Client\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DashboardClientController;
use App\Http\Controllers\DashboardGestionnaireController;
use App\Http\Controllers\GestionnaireController;
use App\Http\Controllers\FactureController;

use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    if(Auth::user()->role === 'gestionnaire'){
        return redirect()->route('gestionnaire.dashboard');
    }else{
        return redirect()->route('client.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Produit : Gestionnaire
Route::middleware(['auth', GestionnaireMiddleware::class])
    ->prefix('gestionnaire')
    ->name('gestionnaire.')
    ->group(function () {
        Route::resource('produits', ProduitController::class)->except(['show']);
    });
Route::post('/gestionnaire/produits/{produit}/archiver', [ProduitController::class, 'archiver'])
    ->name('gestionnaire.produits.archiver')
    ->middleware('auth');


// Accueil
Route::get('/', [AccueilController::class, 'index'])->name('accueil');


// Route Pour Dashboard Gestionnaire
Route::middleware(['auth'])->group(function () {
    Route::get('/gestionnaire/dashboard', [DashboardGestionnaireController::class, 'index'])
        ->name('gestionnaire.dashboard');
});


// Route Pour Dashboard Client
Route::middleware(['auth'])->group(function () {
    Route::get('/client/dashboard', [DashboardClientController::class, 'index'])->name('client.dashboard');
});

// Route pour ajouter un produit au panier
Route::middleware('auth')->post('/panier/ajouter/{produit}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
// Route pour afficher le panier
Route::middleware(['auth'])->get('/panier', [PanierController::class, 'index'])->name('panier.index');
Route::delete('/panier/supprimer/{id}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
Route::patch('panier/mettre-a-jour/{id}', [PanierController::class, 'mettreAJour'])->name('panier.mettre_a_jour');
Route::post('/panier/valider', [PanierController::class, 'valider'])->name('panier.valider');

// Commandes : client
Route::get('/client/commandes', [CommandeController::class, 'index'])->name('client.commandes');
Route::get('/client/commandes/{commande}', [CommandeController::class, 'show'])->name('client.commande.details');

// Route : Produit
Route::get('/produit/{id}', [ProduitController::class, 'show'])->name('produit.show');

// Commandes : Gestionnaire
Route::middleware(['auth'])->prefix('gestionnaire')->name('gestionnaire.')->group(function () {
    Route::get('/commandes', [CommandeController::class, 'gestionnaireIndex'])->name('commandes.index');
    Route::get('/commandes/{commande}', [CommandeController::class, 'gestionnaireShow'])->name('commandes.show');
    Route::patch('/commandes/{commande}/statut', [CommandeController::class, 'updateStatut'])->name('commandes.update_statut');
    Route::patch('/commandes/{commande}/annuler', [CommandeController::class, 'annuler'])->name('commandes.annuler');
    Route::get('gestionnaire/commandes/{commande}', [CommandeController::class, 'gestionnaireShow'])->name('gestionnaire.commandes.show');
});

// Routes pour le client
Route::prefix('client')->middleware('auth')->name('client.')->group(function () {
    Route::get('/factures', [FactureController::class, 'index'])->name('factures');
    // Autres routes pour le client
});

// Routes pour le gestionnaire
Route::prefix('gestionnaire')->middleware('auth')->name('gestionnaire.')->group(function () {
    Route::get('/factures', [FactureController::class, 'gestionnaireIndex'])->name('factures.index');
    // Autres routes pour le gestionnaire
});

require __DIR__.'/auth.php';

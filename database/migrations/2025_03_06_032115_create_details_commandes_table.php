<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('details_commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained()->onDelete('cascade'); // Clé étrangère vers la table commandes
            $table->foreignId('produit_id')->constrained()->onDelete('cascade'); // Clé étrangère vers la table produits
            $table->integer('quantite'); // Quantité du produit
            $table->decimal('prix_unitaire', 8, 2); // Prix unitaire du produit
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_commandes');
    }
};

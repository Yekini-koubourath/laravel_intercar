<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création des lignes de retour.
     */
    public function up(): void
    {
        Schema::create('sale_return_items', function (Blueprint $table) {

            $table->id();

            // Retour
            $table->foreignId('sale_return_id')
                ->constrained('sale_returns')
                ->cascadeOnDelete();

            // Ligne de vente d'origine
            $table->foreignId('sale_item_id')
                ->constrained('sale_items')
                ->restrictOnDelete();

            // Produit
            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();

            // Quantité retournée
            $table->unsignedInteger('quantity');

            // Prix utilisé lors de la vente
            $table->decimal('unit_price', 15, 2);

            // Total retourné
            $table->decimal('total', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Suppression de la table.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_return_items');
    }
};
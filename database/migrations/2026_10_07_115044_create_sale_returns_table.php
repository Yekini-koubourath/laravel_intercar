<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création des retours.
     */
    public function up(): void
    {
        Schema::create('sale_returns', function (Blueprint $table) {

            $table->id();

            // Numéro du retour
            // Exemple : RET-2026-0001
            $table->string('number')->unique();

            // Vente concernée
            $table->foreignId('sale_id')
                ->constrained('sales')
                ->cascadeOnDelete();

            // Utilisateur ayant enregistré le retour
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Date du retour
            $table->date('return_date');

            // Montant total retourné
            $table->decimal('total', 15, 2)->default(0);

            // Motif
            $table->text('reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Suppression de la table.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_returns');
    }
};
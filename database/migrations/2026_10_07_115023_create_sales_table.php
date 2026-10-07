<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création de la table des ventes.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {

            $table->id();

            // Numéro unique de la vente
            // Exemple : VEN-2026-0001
            $table->string('number')->unique();

            // Date de la vente
            $table->date('sale_date');

            // Client
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();

            // Utilisateur qui a enregistré la vente
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Mode de paiement
            $table->enum('payment_method', [
                'especes',
                'mobile_money',
                'virement',
                'carte',
                'autre'
            ])->default('especes');

            // Montants
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);

            // Statut
            $table->enum('status', [
                'terminee',
                'partiellement_retournee',
                'retournee',
                'annulee'
            ])->default('terminee');

            // Observation
            $table->text('observation')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Suppression de la table.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
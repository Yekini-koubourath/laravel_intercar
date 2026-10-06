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
        Schema::create('products', function (Blueprint $table) {

            // =====================================================
            // IDENTIFICATION COMMUNE
            // =====================================================

            $table->id();

            $table->string('reference')->unique();

            $table->string('name');

            $table->string('brand')->nullable();

            $table->string('category');

            $table->text('description')->nullable();

            $table->enum('type', [
                'vehicule',
                'piece'
            ]);


            // =====================================================
            // PRIX
            // =====================================================

            $table->decimal('selling_price', 15, 2)->default(0);

            $table->decimal('purchase_price', 15, 2)
                ->nullable();


            // =====================================================
            // STOCK
            // =====================================================

            $table->integer('quantity')->default(0);

            $table->integer('stock_minimum')->default(0);

            $table->string('location')->nullable();


            // =====================================================
            // STATUT
            // =====================================================

            $table->enum('status', [
                'actif',
                'inactif',
                'brouillon'
            ])->default('actif');


            // =====================================================
            // INFORMATIONS VEHICULE
            // =====================================================

            $table->string('vehicle_model')->nullable();

            $table->year('vehicle_year')->nullable();

            $table->enum('fuel', [
                'essence',
                'diesel',
                'hybride',
                'electrique'
            ])->nullable();

            $table->enum('transmission', [
                'manuelle',
                'automatique',
                'cvt'
            ])->nullable();

            $table->integer('mileage')->nullable();

            $table->integer('doors')->nullable();

            $table->string('color')->nullable();

            $table->enum('condition', [
                'neuf',
                'occasion',
                'reconditionne'
            ])->nullable();

            $table->enum('availability', [
                'disponible',
                'reserve',
                'vendu'
            ])->nullable();


            // =====================================================
            // INFORMATIONS PIECE DETACHEE
            // =====================================================

            $table->string('manufacturer_reference')->nullable();

            $table->string('piece_category')->nullable();

            $table->text('compatibility')->nullable();

            $table->string('piece_brand')->nullable();

            $table->enum('condition_piece', [
                'neuf',
                'occasion',
                'reconditionne'
            ])->nullable();

            $table->enum('warranty', [
                'sans',
                '3_mois',
                '6_mois',
                '12_mois',
                '24_mois'
            ])->nullable();

            $table->enum('unit', [
                'piece',
                'kit',
                'lot',
                'paire'
            ])->nullable();


            // =====================================================
            // DATES
            // =====================================================

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
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
        Schema::create('product_images', function (Blueprint $table) {

            // =====================================================
            // IDENTIFICATION
            // =====================================================

            $table->id();


            // =====================================================
            // PRODUIT ASSOCIÉ
            // =====================================================

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();


            // =====================================================
            // INFORMATIONS DE L'IMAGE
            // =====================================================

            $table->string('path');

            $table->string('original_name')->nullable();

            $table->unsignedInteger('sort_order')->default(0);


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
        Schema::dropIfExists('product_images');
    }
};
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
    $table->id();

    $table->string('reference')->unique();
    $table->string('name');
    $table->string('category');
    $table->enum('type', ['vehicule', 'piece']);
    $table->integer('quantity')->default(0);
    $table->integer('stock_minimum')->default(0);
    $table->enum('status', ['actif', 'inactif'])->default('actif');

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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fournisseurs
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        // Historique des taux de change (traçabilité)
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('base_currency', 3)->default('NGN');
            $table->string('target_currency', 3)->default('XOF');
            $table->decimal('rate', 18, 8);
            $table->string('source')->nullable();
            $table->date('rate_date');
            $table->timestamps();

            $table->index(['base_currency', 'target_currency', 'rate_date'], 'idx_exchange_rates');
        });

        // Achats = entrées de stock
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->date('purchase_date');

            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->string('supplier_reference')->nullable();

            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('stock_movement_id')->nullable()->constrained('stock_movements')->nullOnDelete();
            $table->foreignId('exchange_rate_id')->nullable()->constrained('exchange_rates')->nullOnDelete();

            $table->unsignedInteger('quantity');
            $table->string('unit', 20)->default('piece');

            // Prix d'achat dans la devise d'origine
            $table->string('currency', 3);
            $table->decimal('unit_price', 15, 2);

            // Taux utilisé (NGN -> XOF), conservé pour la traçabilité
            $table->decimal('exchange_rate', 18, 8)->nullable();
            $table->string('exchange_rate_source')->nullable();

            // Montants consolidés en XOF
            $table->decimal('purchase_total_original', 15, 2);
            $table->decimal('purchase_total_xof', 15, 2);
            $table->decimal('expenses_total_xof', 15, 2)->default(0);
            $table->decimal('total_cost_xof', 15, 2);
            $table->decimal('unit_cost_xof', 15, 2);

            // Tarification
            $table->decimal('selling_price', 15, 2);
            $table->decimal('unit_margin', 15, 2);
            $table->decimal('margin_percent', 10, 2);

            $table->text('observation')->nullable();
            $table->timestamps();
        });

        // Frais annexes d'un achat
        Schema::create('purchase_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases')->cascadeOnDelete();
            $table->string('type', 30);
            $table->string('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3);
            $table->decimal('amount_xof', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_expenses');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('exchange_rates');
        Schema::dropIfExists('suppliers');
    }
};
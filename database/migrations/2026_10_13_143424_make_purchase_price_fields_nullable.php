<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('currency', 3)->nullable()->change();

            $table->decimal('unit_price', 15, 2)->nullable()->change();
            $table->decimal('purchase_total_original', 15, 2)
                ->nullable()->change();

            $table->decimal('purchase_total_xof', 15, 2)
                ->nullable()->change();

            $table->decimal('total_cost_xof', 15, 2)
                ->nullable()->change();

            $table->decimal('unit_cost_xof', 15, 2)
                ->nullable()->change();

            $table->decimal('selling_price', 15, 2)
                ->nullable()->change();

            $table->decimal('unit_margin', 15, 2)
                ->nullable()->change();

            $table->decimal('margin_percent', 10, 2)
                ->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('currency', 3)->nullable(false)->change();

            $table->decimal('unit_price', 15, 2)->nullable(false)->change();

            $table->decimal('purchase_total_original', 15, 2)
                ->nullable(false)->change();

            $table->decimal('purchase_total_xof', 15, 2)
                ->nullable(false)->change();

            $table->decimal('total_cost_xof', 15, 2)
                ->nullable(false)->change();

            $table->decimal('unit_cost_xof', 15, 2)
                ->nullable(false)->change();

            $table->decimal('selling_price', 15, 2)->nullable(false)->change();

            $table->decimal('unit_margin', 15, 2)->nullable(false)->change();

            $table->decimal('margin_percent', 10, 2)->nullable(false)->change();
        });
    }
};
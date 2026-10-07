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
        /*
        |--------------------------------------------------------------------------
        | INFORMATIONS COMMUNES
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('products', 'category')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('category')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'description')) {
            Schema::table('products', function (Blueprint $table) {
                $table->text('description')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'type')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('type', [
                    'vehicule',
                    'piece',
                ])->default('vehicule');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | PRIX
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('products', 'selling_price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->decimal('selling_price', 15, 2)->default(0);
            });
        }

        if (!Schema::hasColumn('products', 'purchase_price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->decimal('purchase_price', 15, 2)->nullable();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | STOCK
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('products', 'quantity')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('quantity')->default(0);
            });
        }

        if (!Schema::hasColumn('products', 'stock_minimum')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('stock_minimum')->default(0);
            });
        }

        if (!Schema::hasColumn('products', 'location')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('location')->nullable();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | STATUT
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('products', 'status')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('status', [
                    'actif',
                    'inactif',
                    'brouillon',
                ])->default('actif');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | INFORMATIONS VEHICULE
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('products', 'vehicle_model')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('vehicle_model')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'vehicle_year')) {
            Schema::table('products', function (Blueprint $table) {
                $table->year('vehicle_year')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'fuel')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('fuel', [
                    'essence',
                    'diesel',
                    'hybride',
                    'electrique',
                ])->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'transmission')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('transmission', [
                    'manuelle',
                    'automatique',
                    'cvt',
                ])->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'mileage')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('mileage')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'doors')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('doors')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'color')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('color')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'condition')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('condition', [
                    'neuf',
                    'occasion',
                    'reconditionne',
                ])->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'availability')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('availability', [
                    'disponible',
                    'reserve',
                    'vendu',
                ])->nullable();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | INFORMATIONS PIECE DETACHEE
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('products', 'manufacturer_reference')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('manufacturer_reference')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'piece_category')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('piece_category')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'compatibility')) {
            Schema::table('products', function (Blueprint $table) {
                $table->text('compatibility')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'piece_brand')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('piece_brand')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'condition_piece')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('condition_piece', [
                    'neuf',
                    'occasion',
                    'reconditionne',
                ])->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'warranty')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('warranty', [
                    'sans',
                    '3_mois',
                    '6_mois',
                    '12_mois',
                    '24_mois',
                ])->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'unit')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('unit', [
                    'piece',
                    'kit',
                    'lot',
                    'paire',
                ])->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columns = [
            'category',
            'description',
            'type',
            'selling_price',
            'purchase_price',
            'quantity',
            'stock_minimum',
            'location',
            'status',
            'vehicle_model',
            'vehicle_year',
            'fuel',
            'transmission',
            'mileage',
            'doors',
            'color',
            'condition',
            'availability',
            'manufacturer_reference',
            'piece_category',
            'compatibility',
            'piece_brand',
            'condition_piece',
            'warranty',
            'unit',
        ];

        foreach ($columns as $column) {
            if (Schema::hasColumn('products', $column)) {
                Schema::table('products', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
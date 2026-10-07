<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Auto Nigeria Ltd',
            'Lagos Auto Parts',
            'Benin Auto Distribution',
            'Fournisseur local',
        ] as $name) {
            Supplier::firstOrCreate(['name' => $name]);
        }
    }
}
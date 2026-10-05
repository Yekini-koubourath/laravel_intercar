<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    if (! env('ADMIN_EMAIL') || ! env('ADMIN_PASSWORD')) {
        $this->command->error('Définissez ADMIN_EMAIL et ADMIN_PASSWORD dans le .env');
        return;
    }

    User::where('email', '!=', env('ADMIN_EMAIL'))->delete();

    User::updateOrCreate(
        ['email' => env('ADMIN_EMAIL')],
        [
            'name'     => env('ADMIN_NAME', 'Administrateur'),
            'password' => env('ADMIN_PASSWORD'), // hashé automatiquement par le modèle User
        ]
    );
}
}

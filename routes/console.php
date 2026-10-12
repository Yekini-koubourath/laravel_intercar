<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Mise à jour automatique des taux de change
|--------------------------------------------------------------------------
| La commande récupère les taux auprès de l'API.
| Elle est programmée une seule fois par jour.
*/

Schedule::command('rates:update')->daily();

/*
|--------------------------------------------------------------------------
| Commande de démonstration Laravel
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
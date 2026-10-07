<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
  Schedule::command('rates:update')->daily();

Schedule::command('rates:update')->daily();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

<?php

namespace App\Console\Commands;

use App\Models\ExchangeRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateExchangeRate extends Command
{
    protected $signature = 'rates:update';

    protected $description = 'Récupère le taux NGN → XOF et l\'ajoute à l\'historique';

    public function handle(): int
    {
        $rate = null;

        try {
            $response = Http::timeout(15)->retry(2, 500)
                ->get('https://open.er-api.com/v6/latest/NGN');

            if ($response->successful()) {
                $rate = data_get($response->json(), 'rates.XOF');
            }
        } catch (\Throwable $e) {
            Log::warning('Taux de change : ' . $e->getMessage());
        }

        if (! $rate) {
            // On conserve le dernier taux connu (il sera signalé "non à jour")
            $this->warn('API indisponible : le dernier taux connu est conservé.');
            return self::FAILURE;
        }

        ExchangeRate::create([
            'base_currency'   => 'NGN',
            'target_currency' => 'XOF',
            'rate'            => $rate,
            'source'          => 'open.er-api.com',
            'rate_date'       => now()->toDateString(),
        ]);

        $this->info("1 NGN = {$rate} XOF enregistré.");

        return self::SUCCESS;
    }
}
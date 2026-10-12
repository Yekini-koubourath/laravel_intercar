<?php

namespace App\Console\Commands;

use App\Models\ExchangeRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateExchangeRate extends Command
{
    protected $signature = 'rates:update';

    protected $description = 'Met à jour les taux NGN, EUR et USD vers XOF';

    public function handle(): int
    {
        // Devises dont nous voulons récupérer le taux vers le franc CFA.
        $currencies = ['NGN', 'EUR', 'USD'];

        $hasError = false;

        foreach ($currencies as $currency) {
            try {
                $response = Http::timeout(15)
                    ->retry(2, 500)
                    ->get("https://open.er-api.com/v6/latest/{$currency}");

                if (! $response->successful()) {
                    throw new \RuntimeException(
                        "Erreur HTTP {$response->status()} pour {$currency}."
                    );
                }

                $data = $response->json();

                if (data_get($data, 'result') !== 'success') {
                    throw new \RuntimeException(
                        "La réponse de l'API est invalide pour {$currency}."
                    );
                }

                $rate = data_get($data, 'rates.XOF');

                if (! is_numeric($rate) || (float) $rate <= 0) {
                    throw new \RuntimeException(
                        "Taux XOF absent ou invalide pour {$currency}."
                    );
                }

                // Une seule valeur par devise et par date.
                // Une nouvelle exécution le même jour actualise la ligne.
                ExchangeRate::updateOrCreate(
                    [
                        'base_currency'   => $currency,
                        'target_currency' => 'XOF',
                        'rate_date'       => now()->toDateString(),
                    ],
                    [
                        'rate'   => $rate,
                        'source' => 'open.er-api.com',
                    ]
                );

                $this->info(
                    "1 {$currency} = "
                    . number_format((float) $rate, 6, '.', '')
                    . ' XOF enregistré.'
                );
            } catch (\Throwable $e) {
                $hasError = true;

                Log::warning(
                    "Mise à jour du taux {$currency} vers XOF : "
                    . $e->getMessage()
                );

                $this->error(
                    "Échec pour {$currency} → XOF. "
                    . 'Le dernier taux enregistré est conservé.'
                );
            }
        }

        if ($hasError) {
            return self::FAILURE;
        }

        $this->info('Tous les taux de change ont été mis à jour.');

        return self::SUCCESS;
    }
}
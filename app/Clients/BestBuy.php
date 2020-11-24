<?php


namespace App\Clients;


use App\Models\Stock;
use Illuminate\Support\Facades\Http;

/**
 * Class BestBuy
 * @group api
 */
class BestBuy implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {
        $results = Http::get($this->endpoint($stock->sku))->json();

        return  new StockStatus(
            $results['onlineAvailability'],
            $this->dolarsToCents($results['salePrice'])
        );

    }


    public function endpoint($sku): string
    {
        $key = config('services.clients.bestBuy.key');
        return "https://api.bestbuy.com/v1/products/{$sku}.json?apiKey={$key}";
    }

    private function dolarsToCents($salePrice)
    {
        return (int)($salePrice*100);
    }
}

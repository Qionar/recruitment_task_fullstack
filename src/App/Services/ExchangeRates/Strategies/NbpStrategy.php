<?php

namespace App\Services\ExchangeRates\Strategies;

use App\DTO\ExchangeRateDTO;
use App\Services\ExchangeRates\ExchangeRatesStrategyInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NbpStrategy implements ExchangeRatesStrategyInterface
{
    /**
     * @var HttpClientInterface
     */
    private $client;
    /**
     * @var string
     */
    private $baseUrl;

    public function __construct(
        HttpClientInterface $client,
        string $baseUrl
    ) {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }

    public function getExchangeRates(?string $byDate = null): array
    {
        $url = $this->baseUrl . '/exchangerates/tables/A';

        if($byDate) {
            $url .= '/' . $byDate;
        }

        $url .= '?format=json';

        $response = $this->client->request('GET', $url);
        $data = json_decode($response->getContent(), true);

        return array_map(function(array $item) {
            return new ExchangeRateDTO(
                $item['currency'],
                $item['code'],
                $item['mid']
            );
        }, $data[0]['rates']);
    }
}
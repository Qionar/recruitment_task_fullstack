<?php

namespace App\Services\ExchangeRates;

use App\DTO\ExchangeRateDTO;

class ExchangeRatesService
{
    /**
     * @var ExchangeRatesStrategyInterface
     */
    private $strategy;
    /**
     * @var array
     */
    private $availableCodes;

    /**
     * @var int
     */
    private const DEFAULT_ROUND_PRECISION = 2;

    /**
     * @var string
     */
    public const MINIMUM_ALLOWED_DATE = '2023-01-01';

    public function __construct(
        ExchangeRatesStrategyInterface $strategy,
        array $availableCodes
    ) {
        $this->strategy = $strategy;
        $this->availableCodes = $availableCodes;
    }

    public function fetchRates(?\DateTime $byDate = null): array
    {
        $rates = $this->strategy->getExchangeRates($byDate);

        $rates = array_filter($rates, function (ExchangeRateDTO $item) {
            return in_array($item->getCode(), array_keys($this->availableCodes));
        });

        return array_values(
            array_map(function(ExchangeRateDTO $item) {
                $exchangeProvisions = $this->availableCodes[$item->getCode()];

                $buyRate = $this->calculateRate($item->getRate(), $exchangeProvisions['buy']);
                $sellRate = $this->calculateRate($item->getRate(), $exchangeProvisions['sell']);

                return [
                    'code' => $item->getCode(),
                    'currency' => $item->getCurrency(),
                    'buyRate' => $buyRate,
                    'sellRate' => $sellRate,
                ];
            }, $rates)
        );
    }

    private function calculateRate(float $baseRate, ?float $provision): ?float
    {
        if($provision === false) {
            return null;
        }

        return round($baseRate + $provision, self::DEFAULT_ROUND_PRECISION);
    }

}
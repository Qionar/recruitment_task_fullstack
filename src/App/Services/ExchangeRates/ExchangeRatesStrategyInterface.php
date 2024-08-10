<?php

namespace App\Services\ExchangeRates;

interface ExchangeRatesStrategyInterface
{

    /**
     * @param string|null $byDate
     * @return array
     */
    public function getExchangeRates(?string $byDate = null): array;

}
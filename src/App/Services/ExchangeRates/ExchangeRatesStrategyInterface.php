<?php

namespace App\Services\ExchangeRates;

use DateTime;

interface ExchangeRatesStrategyInterface
{

    /**
     * @param DateTime|null $byDate
     * @return array
     */
    public function getExchangeRates(?DateTime $byDate = null): array;

}
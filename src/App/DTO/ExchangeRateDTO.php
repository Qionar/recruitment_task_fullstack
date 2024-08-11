<?php

namespace App\DTO;

class ExchangeRateDTO
{
    private $code;

    private $currency;

    private $rate;

    public function __construct(string $currency, string $code, float $rate)
    {
        $this->currency = $currency;
        $this->code = $code;
        $this->rate = $rate;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'currency' => $this->currency,
            'rate' => $this->rate,
        ];
    }
}
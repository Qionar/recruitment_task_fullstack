<?php

namespace Tests\Unit;

use App\Services\ExchangeRates\ExchangeRatesService;
use App\Services\ExchangeRates\Strategies\NbpStrategy;
use PHPUnit\Framework\MockObject\Rule\InvokedCount as InvokedCountMatcher;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\ExchangeRatesFixture;

class ExchangeRatesServiceTest extends TestCase
{

    private $availableRates = [
        'USD' => [
            'buy' => -0.05,
            'sell' => 0.07
        ],
        'EUR' => [
            'buy' => -0.05,
            'sell' => 0.07
        ],
        'IDR' => [
            'buy' => false,
            'sell' => 0.15
        ]
    ];

    public function test_that_service_correctly_filter_values()
    {
        $strategyMock = $this->mockStrategy(NbpStrategy::class);
        $service = new ExchangeRatesService($strategyMock, $this->availableRates);

        $result = $service->fetchRates();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
    }

    public function test_that_service_return_valid_structure()
    {
        $strategyMock = $this->mockStrategy(NbpStrategy::class);
        $service = new ExchangeRatesService($strategyMock, $this->availableRates);

        $result = $service->fetchRates();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);

        [$rate] = $result;

        $this->assertArrayHasKey('code', $rate);
        $this->assertArrayHasKey('currency', $rate);
        $this->assertArrayHasKey('buyRate', $rate);
        $this->assertArrayHasKey('sellRate', $rate);
    }

    public function test_that_service_return_correct_calculated_buy_and_sell_prices()
    {
        $strategyMock = $this->mockStrategy(NbpStrategy::class);
        $service = new ExchangeRatesService($strategyMock, $this->availableRates);

        $result = $service->fetchRates();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);

        [$firstRate] = $result;
        $originalRateData = $this->getOriginalRateByCode($firstRate['code']);

        $expectedBuyRate = $this->calculateExpectedPrice($originalRateData['rate'], $this->availableRates[$firstRate['code']]['buy']);
        $expectedSellRate = $this->calculateExpectedPrice($originalRateData['rate'], $this->availableRates[$firstRate['code']]['sell']);

        $this->assertEquals($expectedBuyRate, $firstRate['buyRate']);
        $this->assertEquals($expectedSellRate, $firstRate['sellRate']);
    }

    private function mockStrategy(string $strategyReference)
    {
        $strategyMock = $this->createMock($strategyReference);

        $strategyMock
            ->expects(self::once())
            ->method('getExchangeRates')
            ->willReturn(ExchangeRatesFixture::getRatesDTO());

        return $strategyMock;
    }

    private function getOriginalRateByCode(string $code): array
    {
        $rates = ExchangeRatesFixture::getRates();
        $originalRateIndex = array_search($code, array_column($rates, 'code'));

        return $rates[$originalRateIndex];
    }

    private function calculateExpectedPrice(float $originalRate, $provision): float
    {
        $defaultRound = 2;
        return round($originalRate + $provision, $defaultRound);
    }

}
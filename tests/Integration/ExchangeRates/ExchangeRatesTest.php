<?php

namespace Tests\Integration\ExchangeRates;

use App\DTO\ExchangeRateDTO;
use App\Services\ExchangeRates\Strategies\NbpStrategy;
use PHPUnit\Framework\MockObject\Rule\InvokedCount as InvokedCountMatcher;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Fixtures\ExchangeRatesFixture;

class ExchangeRatesTest extends WebTestCase
{
    public function test_index_that_return_exchange_rates_with_nbp_provider()
    {
        [$client] = $this->initializeClient(NbpStrategy::class, self::once());

        $client->request('GET', '/api/exchange-rates');

        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();

        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('data', $json);
        $this->assertCount(3, $json['data']);
    }

    public function test_index_that_return_error_when_receive_invalid_datetime_format()
    {
        [$client] = $this->initializeClient(NbpStrategy::class, self::never());

        $client->request('GET', '/api/exchange-rates?byDate=' . 'test-string');

        $this->assertResponseStatusCodeSame(422);

        $response = $client->getResponse();

        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('error', $json);
        $this->assertStringStartsWith('Invalid date format. Expected valid ISO 8601 format.', $json['error']);
    }

    public function test_index_that_return_exchange_rates_when_receive_valid_datetime_format()
    {
        [$client] = $this->initializeClient(NbpStrategy::class, self::once());

        $dateParam = (new \DateTime())
            ->format(\DateTime::ISO8601);

        $client->request(
            'GET',
            '/api/exchange-rates?byDate=' . urlencode($dateParam)
        );

        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();

        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('data', $json);
        $this->assertCount(3, $json['data']);
    }

    private function initializeClient(string $strategyReference, InvokedCountMatcher $invokedCount): array
    {
        $strategyMock = $this->mockStrategy($strategyReference, $invokedCount);

        $client = static::createClient();
        $container = $client->getContainer();
        $container->set($strategyReference, $strategyMock);

        return [ $client, $strategyMock, $container ];
    }

    private function mockStrategy(string $strategyReference, InvokedCountMatcher $invokedCount)
    {
        $strategyMock = $this->createMock($strategyReference);

        $strategyMock
            ->expects($invokedCount)
            ->method('getExchangeRates')
            ->willReturn(ExchangeRatesFixture::getRatesDTO());

        return $strategyMock;
    }
}
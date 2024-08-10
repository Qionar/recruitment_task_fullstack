<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\ExchangeRates\ExchangeRatesService;
use App\Support\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExchangeRatesController extends AbstractController
{

    /**
     * @var ExchangeRatesService
     */
    private $service;

    public function __construct(ExchangeRatesService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $byDate = $request->query->get('byDate');

        if($byDate && !Date::validateByFormat($byDate)) {
            return new JsonResponse([
                'error' => 'Invalid date format. Expected valid ISO 8601 format.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $rates = $this->service->fetchRates($byDate);

            return new JsonResponse([
                'data' => $rates
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

}

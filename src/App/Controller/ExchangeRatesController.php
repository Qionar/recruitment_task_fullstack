<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\ExchangeRates\ExchangeRatesService;
use App\Support\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

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
        $date = $this->extractDateFromRequest($request);

        if($date && !$this->validateDate($date)) {
            return new JsonResponse([
                'error' => "Invalid date {$date->format('Y-m-d')}. Expected to be valid timestamp after 01.01.2023 and before today.",
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $rates = $this->service->fetchRates($date ?? null);

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

    private function extractDateFromRequest(Request $request): ?DateTime
    {
        $timestamp = $request->get('byDate', '');
        $date = DateTime::createFromFormat(
            Date::DATE_TIMESTAMP_FORMAT,
            $timestamp
        );

        return $date ?: null;
    }

    private function validateDate($date): bool
    {
        if(!$date instanceof DateTime) {
            return false;
        }

        $isDateAfterMinimumAllowed = $date > new DateTime($this->service::MINIMUM_ALLOWED_DATE);
        $isDateAfterOrEqualToday = $date >= new DateTime();

        return $isDateAfterMinimumAllowed === true && $isDateAfterOrEqualToday === false;
    }

}

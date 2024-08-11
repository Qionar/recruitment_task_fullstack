<?php

namespace Tests\Fixtures;

use App\DTO\ExchangeRateDTO;

class ExchangeRatesFixture
{

    public static function getRatesDTO()
    {
        return array_map(function(array $item) {
            return new ExchangeRateDTO(
                $item['currency'],
                $item['code'],
                $item['rate']
            );
        }, self::getRates());
    }

    public static function getRates(): array
    {
        return [
            [
                "code" => "THB",
                "currency" => "bat (Tajlandia)",
                "rate" => 0.1118
            ],
            [
                "code" => "USD",
                "currency" => "dolar amerykański",
                "rate" => 3.952
            ],
            [
                "code" => "AUD",
                "currency" => "dolar australijski",
                "rate" => 2.5913
            ],
            [
                "code" => "HKD",
                "currency" => "dolar Hongkongu",
                "rate" => 0.5074
            ],
            [
                "code" => "CAD",
                "currency" => "dolar kanadyjski",
                "rate" => 2.8782
            ],
            [
                "code" => "NZD",
                "currency" => "dolar nowozelandzki",
                "rate" => 2.3704
            ],
            [
                "code" => "SGD",
                "currency" => "dolar singapurski",
                "rate" => 2.9846
            ],
            [
                "code" => "EUR",
                "currency" => "euro",
                "rate" => 4.3225
            ],
            [
                "code" => "HUF",
                "currency" => "forint (Węgry)",
                "rate" => 0.010885
            ],
            [
                "code" => "CHF",
                "currency" => "frank szwajcarski",
                "rate" => 4.604
            ],
            [
                "code" => "GBP",
                "currency" => "funt szterling",
                "rate" => 5.0195
            ],
            [
                "code" => "UAH",
                "currency" => "hrywna (Ukraina)",
                "rate" => 0.0963
            ],
            [
                "code" => "JPY",
                "currency" => "jen (Japonia)",
                "rate" => 0.027032
            ],
            [
                "code" => "CZK",
                "currency" => "korona czeska",
                "rate" => 0.1712
            ],
            [
                "code" => "DKK",
                "currency" => "korona duńska",
                "rate" => 0.5793
            ],
            [
                "code" => "ISK",
                "currency" => "korona islandzka",
                "rate" => 0.028645
            ],
            [
                "code" => "NOK",
                "currency" => "korona norweska",
                "rate" => 0.3651
            ],
            [
                "code" => "SEK",
                "currency" => "korona szwedzka",
                "rate" => 0.3774
            ],
            [
                "code" => "RON",
                "currency" => "lej rumuński",
                "rate" => 0.8685
            ],
            [
                "code" => "BGN",
                "currency" => "lew (Bułgaria)",
                "rate" => 2.21
            ],
            [
                "code" => "TRY",
                "currency" => "lira turecka",
                "rate" => 0.118
            ],
            [
                "code" => "ILS",
                "currency" => "nowy izraelski szekel",
                "rate" => 1.0436
            ],
            [
                "code" => "CLP",
                "currency" => "peso chilijskie",
                "rate" => 0.004184
            ],
            [
                "code" => "PHP",
                "currency" => "peso filipińskie",
                "rate" => 0.0689
            ],
            [
                "code" => "MXN",
                "currency" => "peso meksykańskie",
                "rate" => 0.2055
            ],
            [
                "code" => "ZAR",
                "currency" => "rand (Republika Południowej Afryki)",
                "rate" => 0.2148
            ],
            [
                "code" => "BRL",
                "currency" => "real (Brazylia)",
                "rate" => 0.701
            ],
            [
                "code" => "MYR",
                "currency" => "ringgit (Malezja)",
                "rate" => 0.8831
            ],
            [
                "code" => "IDR",
                "currency" => "rupia indonezyjska",
                "rate" => 0.00024864
            ],
            [
                "code" => "INR",
                "currency" => "rupia indyjska",
                "rate" => 0.047068
            ],
            [
                "code" => "KRW",
                "currency" => "won południowokoreański",
                "rate" => 0.002874
            ],
            [
                "code" => "CNY",
                "currency" => "yuan renminbi (Chiny)",
                "rate" => 0.5513
            ],
            [
                "code" => "XDR",
                "currency" => "SDR (MFW)",
                "rate" => 5.2771
            ]
        ];
    }
}
<?php

namespace Tests\Integration;


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class GetProductUnitPriceTest
 * @package Tests\Integration
 * @group integration
 */
class GetProductUnitPriceTest extends TestCase
{
    /**
     * @var Client
     */
    private $http;

    protected function setUp(): void
    {
        $this->http = new Client(['base_uri' => 'http://localhost:8080', 'http_errors' => false]);
    }

    public function test_unit_price()
    {
        $response = $this->http->request('GET', '/api/v1/products/BA-04/prices/single');
        $actualPrice = json_decode($response->getBody()->getContents(), true);
        $expectedPrice = [
            'value' => 212.31,
            'currency' => 'EUR',
        ];
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expectedPrice, $actualPrice);
    }

    public function test_missing_unit()
    {
        $response = $this->http->request('GET', '/api/v1/products/BA-04/prices');
        $this->assertEquals(400, $response->getStatusCode());
    }
}

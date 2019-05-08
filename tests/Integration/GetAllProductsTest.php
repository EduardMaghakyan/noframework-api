<?php

namespace Tests\Integration;


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class GetAllProductsTest
 * @package Tests\Integration
 * @group integration
 */
class GetAllProductsTest extends TestCase
{
    /**
     * @var Client
     */
    private $http;

    protected function setUp(): void
    {
        $this->http = new Client(['base_uri' => 'http://localhost:8080', 'http_errors' => false]);
    }

    public function test_it_gets_all_products()
    {
        $response = $this->http->request('GET', '/api/v1/products');
        $this->assertEquals(2, count(json_decode($response->getBody()->getContents())));
        $this->assertEquals(200, $response->getStatusCode());
    }
}

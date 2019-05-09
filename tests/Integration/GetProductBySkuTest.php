<?php

namespace Tests\Integration;


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\FakeProductRepository;

/**
 * Class GetProductBySkuTest
 * @package Tests\Integration
 * @group integration
 */
class GetProductBySkuTest extends TestCase
{
    /**
     * @var Client
     */
    private $http;

    /**
     * @var FakeProductRepository
     */
    private $fakeRepo;

    protected function setUp(): void
    {
        $this->http = new Client(['base_uri' => 'http://localhost:8081', 'http_errors' => false]);
        $this->fakeRepo = new FakeProductRepository();
    }

    public function test_it_gets_product_by_sku()
    {
        $response = $this->http->request('GET', '/api/v1/products/BA-01');
        $this->assertEquals(200, $response->getStatusCode());
        $product = json_decode($response->getBody()->getContents(), true);
        $this->assertEquals($this->fakeRepo->fakeProductWithPricesDto('BA-01')->toArray(), $product);
    }

    public function test_invalid_formatted_sku()
    {
        $response = $this->http->request('GET', '/api/v1/products/AAA-SS');
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_missing_sku()
    {
        $response = $this->http->request('GET', '/api/v1/products/');
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_item_not_found_status()
    {
        $response = $this->http->request('GET', '/api/v1/products/DA-00');
        $this->assertEquals(404, $response->getStatusCode());
    }
}

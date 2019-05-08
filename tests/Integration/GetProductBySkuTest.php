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
        $this->http = new Client(['base_uri' => 'http://localhost:8080', 'http_errors' => false]);
        $this->fakeRepo = new FakeProductRepository();
    }

    public function test_it_gets_product_by_sku()
    {
        $response = $this->http->request('GET', '/api/v1/products/BA-04');
        $this->assertEquals(200, $response->getStatusCode());
        $product = json_decode($response->getBody()->getContents(), true);
        $this->assertEquals($this->fakeRepo->fakeProductWithPricesDto()->toArray(), $product);
    }

    public function test_missing_sku()
    {
        $response = $this->http->request('GET', '/api/v1/products/');
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_item_not_found_status()
    {
        $response = $this->http->request('GET', '/api/v1/products/not-existing-sku');
        $this->assertEquals(404, $response->getStatusCode());
    }
}

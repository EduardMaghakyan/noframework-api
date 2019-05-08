<?php

namespace Tests\DemoApi\Application;


use DemoApi\Application\Dto\ProductDto;
use DemoApi\Application\Dto\ProductWithPriceDto;
use DemoApi\Application\Dto\UnitPriceDto;
use DemoApi\Application\Exceptions\ProductNotFoundException;
use DemoApi\Application\Exceptions\ProductUnitPriceNotFoundException;
use DemoApi\Application\ProductService;
use DemoApi\Domain\Price;
use DemoApi\Domain\Product;
use DemoApi\Domain\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var Product[]
     */
    private $products;

    /**
     * @var ProductService
     */
    private $subject;

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->products = $this->generateDummyProducts();
        $this->productRepo = $this->createMock(ProductRepositoryInterface::class);
        $this->productRepo->method('findAllProducts')->willReturn($this->getProducts());
        $this->productRepo->method('findProductBySku')->willReturnMap([
            ['BA-01', $this->getProducts()[0]],
            ['BA-02', null]
        ]);

        $this->subject = new ProductService($this->productRepo);
    }

    public function test_it_gets_all_available_products()
    {
        /** @var ProductDto[] $expectedResult */
        $expectedResult = array_map(function (Product $product) {
            return new ProductDto($product->getSku(), $product->getName(), $product->getDescription());
        }, $this->getProducts());

        /** @var ProductDto[] $actual */
        $actual = $this->subject->getAllProducts();
        $this->assertEquals(count($this->getProducts()), count($actual));
        $this->assertEquals($expectedResult, $actual);
        foreach ($expectedResult as $index => $expected) {
            $this->assertEquals($expected->toArray(), $actual[$index]->toArray());
        }
    }

    public function test_it_gets_product_by_sku()
    {
        $product = $this->getProducts()[0];
        $expected = new ProductWithPriceDto($product->getSku(), $product->getName(), $product->getDescription(),
            $product->getPrices());
        /** @var ProductWithPriceDto[] $actual */
        $actual = $this->subject->getProductBySku('BA-01');

        $this->assertEquals($expected, $actual);
        $this->assertEquals($expected->toArray(), $actual->toArray());
    }

    public function test_it_throws_exception_if_product_sku_is_missing()
    {
        $this->expectException(ProductNotFoundException::class);
        $this->subject->getProductBySku('BA-02');
    }

    public function test_it_returns_unit_price()
    {
        /** @var UnitPriceDto[] $actual */
        $actual = $this->subject->getProductUnitPrice('BA-01', 'single');
        $testProduct = $this->getProducts()[0];
        $expected = null;
        foreach ($testProduct->getPrices() as $price) {
            if ($price->getUnit() === 'single') {
                $expected = new UnitPriceDto($price->getValue(), $price->getCurrency());
            }
        }

        $this->assertEquals($expected, $actual);
        $this->assertEquals($expected->toArray(), $actual->toArray());

    }

    public function test_it_throws_exception_if_sku_is_not_available()
    {
        $this->expectException(ProductNotFoundException::class);
        $this->subject->getProductUnitPrice('BA-02', 'single');
    }

    public function test_it_throws_exception_if_unit_is_not_available()
    {
        $this->expectException(ProductUnitPriceNotFoundException::class);
        $this->subject->getProductUnitPrice('BA-01', 'double');
    }

    private function generateDummyProducts()
    {
        $products = [];
        $count = mt_rand(1, 5);
        while ($count) {
            $product = new Product();
            $product->setId('uuid' . $count);
            $product->setSku(sprintf('BA-0' . $count));
            $product->setDescription('<p>The <b>banana</b> is an edible <a href="/wiki/Fruit" title="Fruit">fruit</a> – botanically a <a href="/wiki/Berry_(botany)" title="Berry (botany)">berry</a><sup id="cite_ref-purdue1_1-0" class="reference"><a href="#cite_note-purdue1-1">[1]</a></sup><sup id="cite_ref-Armstrong_2-0" class="reference"><a href="#cite_note-Armstrong-2">[2]</a></sup> – produced by several kinds of large <a href="/wiki/Herbaceous" class="mw-redirect" title="Herbaceous">herbaceous</a> <a href="/wiki/Flowering_plant" title="Flowering plant">flowering plants</a> in the <a href="/wiki/Genus" title="Genus">genus</a> <i><a href="/wiki/Musa_(genus)" title="Musa (genus)">Musa</a></i>.<sup id="cite_ref-MW_3-0" class="reference"><a href="#cite_note-MW-3">[3]</a></sup> In some countries, bananas used for cooking may be called <a href="/wiki/Cooking_banana" title="Cooking banana">plantains</a>, in contrast to <b>dessert bananas</b>. The fruit is variable in size, color and firmness, but is usually elongated and curved, with soft flesh rich in <a href="/wiki/Starch" title="Starch">starch</a> covered with a rind which may be green, yellow, red, purple, or brown when ripe. The fruits grow in clusters hanging from the top of the plant. Almost all modern edible <a href="/wiki/Parthenocarpy" title="Parthenocarpy">parthenocarpic</a> (seedless) bananas come from two wild species&nbsp;– <i><a href="/wiki/Musa_acuminata" title="Musa acuminata">Musa acuminata</a></i> and <i><a href="/wiki/Musa_balbisiana" title="Musa balbisiana">Musa balbisiana</a></i>. The <a href="/wiki/Binomial_nomenclature" title="Binomial nomenclature">scientific names</a> of most cultivated bananas are <i>Musa acuminata</i>, <i>Musa balbisiana</i>, and <i>Musa</i> × <i>paradisiaca</i> for the hybrid <i>Musa acuminata</i> × <i>M.&nbsp;balbisiana</i>, depending on their <a href="/wiki/Genome" title="Genome">genomic</a> constitution. The old scientific name <i>Musa sapientum</i> is no longer used.</p>');
            $product->setName('Some Name');

            $prices = [];
            foreach (array('bundle', 'single') as $unit) {
                $price = new Price();
                $price->setCurrency("EUR");
                $price->setUnit($unit);
                $price->setValue(mt_rand(1, 100) * pi());
                $prices[] = $price;
                $product->setPrices($prices);
            }
            $products[] = $product;
            $count--;
        }

        return $products;
    }
}

<?php
declare(strict_types=1);

namespace Tests\Mocks;

use DemoApi\Application\Dto\ProductWithPriceDto;
use DemoApi\Domain\Price;
use DemoApi\Domain\Product;
use DemoApi\Domain\ProductRepositoryInterface;

class FakeProductRepository implements ProductRepositoryInterface
{
    /**
     * @var Product[]
     */
    private $products;

    public function __construct()
    {
        $product = new Product();
        $product->setId('43b105a0-b5da-401b-a91d-32237ae418e4');
        $product->setSku('BA-04');
        $product->setDescription('<p>The <b>banana</b> is an edible <a href="/wiki/Fruit" title="Fruit">fruit</a> – botanically a <a href="/wiki/Berry_(botany)" title="Berry (botany)">berry</a><sup id="cite_ref-purdue1_1-0" class="reference"><a href="#cite_note-purdue1-1">[1]</a></sup><sup id="cite_ref-Armstrong_2-0" class="reference"><a href="#cite_note-Armstrong-2">[2]</a></sup> – produced by several kinds of large <a href="/wiki/Herbaceous" class="mw-redirect" title="Herbaceous">herbaceous</a> <a href="/wiki/Flowering_plant" title="Flowering plant">flowering plants</a> in the <a href="/wiki/Genus" title="Genus">genus</a> <i><a href="/wiki/Musa_(genus)" title="Musa (genus)">Musa</a></i>.<sup id="cite_ref-MW_3-0" class="reference"><a href="#cite_note-MW-3">[3]</a></sup> In some countries, bananas used for cooking may be called <a href="/wiki/Cooking_banana" title="Cooking banana">plantains</a>, in contrast to <b>dessert bananas</b>. The fruit is variable in size, color and firmness, but is usually elongated and curved, with soft flesh rich in <a href="/wiki/Starch" title="Starch">starch</a> covered with a rind which may be green, yellow, red, purple, or brown when ripe. The fruits grow in clusters hanging from the top of the plant. Almost all modern edible <a href="/wiki/Parthenocarpy" title="Parthenocarpy">parthenocarpic</a> (seedless) bananas come from two wild species&nbsp;– <i><a href="/wiki/Musa_acuminata" title="Musa acuminata">Musa acuminata</a></i> and <i><a href="/wiki/Musa_balbisiana" title="Musa balbisiana">Musa balbisiana</a></i>. The <a href="/wiki/Binomial_nomenclature" title="Binomial nomenclature">scientific names</a> of most cultivated bananas are <i>Musa acuminata</i>, <i>Musa balbisiana</i>, and <i>Musa</i> × <i>paradisiaca</i> for the hybrid <i>Musa acuminata</i> × <i>M.&nbsp;balbisiana</i>, depending on their <a href="/wiki/Genome" title="Genome">genomic</a> constitution. The old scientific name <i>Musa sapientum</i> is no longer used.</p>');
        $product->setName('Some Name');
        $price = new Price();
        $price->setCurrency("EUR");
        $price->setUnit('single');
        $price->setValue(212.31);

        $price1 = new Price();
        $price1->setCurrency("EUR");
        $price1->setUnit('bundle');
        $price1->setValue(212.31);
        $prices = [
            $price,
            $price1
        ];
        $product->setPrices($prices);

        $product1 = new Product();
        $product1->setId('43b105a0-b5da-401b-a91d-32237ae418e4');
        $product1->setSku('BA-02');
        $product1->setDescription('<p>The <b>banana</b> is an edible <a href="/wiki/Fruit" title="Fruit">fruit</a> – botanically a <a href="/wiki/Berry_(botany)" title="Berry (botany)">berry</a><sup id="cite_ref-purdue1_1-0" class="reference"><a href="#cite_note-purdue1-1">[1]</a></sup><sup id="cite_ref-Armstrong_2-0" class="reference"><a href="#cite_note-Armstrong-2">[2]</a></sup> – produced by several kinds of large <a href="/wiki/Herbaceous" class="mw-redirect" title="Herbaceous">herbaceous</a> <a href="/wiki/Flowering_plant" title="Flowering plant">flowering plants</a> in the <a href="/wiki/Genus" title="Genus">genus</a> <i><a href="/wiki/Musa_(genus)" title="Musa (genus)">Musa</a></i>.<sup id="cite_ref-MW_3-0" class="reference"><a href="#cite_note-MW-3">[3]</a></sup> In some countries, bananas used for cooking may be called <a href="/wiki/Cooking_banana" title="Cooking banana">plantains</a>, in contrast to <b>dessert bananas</b>. The fruit is variable in size, color and firmness, but is usually elongated and curved, with soft flesh rich in <a href="/wiki/Starch" title="Starch">starch</a> covered with a rind which may be green, yellow, red, purple, or brown when ripe. The fruits grow in clusters hanging from the top of the plant. Almost all modern edible <a href="/wiki/Parthenocarpy" title="Parthenocarpy">parthenocarpic</a> (seedless) bananas come from two wild species&nbsp;– <i><a href="/wiki/Musa_acuminata" title="Musa acuminata">Musa acuminata</a></i> and <i><a href="/wiki/Musa_balbisiana" title="Musa balbisiana">Musa balbisiana</a></i>. The <a href="/wiki/Binomial_nomenclature" title="Binomial nomenclature">scientific names</a> of most cultivated bananas are <i>Musa acuminata</i>, <i>Musa balbisiana</i>, and <i>Musa</i> × <i>paradisiaca</i> for the hybrid <i>Musa acuminata</i> × <i>M.&nbsp;balbisiana</i>, depending on their <a href="/wiki/Genome" title="Genome">genomic</a> constitution. The old scientific name <i>Musa sapientum</i> is no longer used.</p>');
        $product1->setName('Some Name');
        $price = new Price();
        $price->setCurrency("EUR");
        $price->setUnit('single');
        $price->setValue(212.31);

        $price1 = new Price();
        $price1->setCurrency("EUR");
        $price1->setUnit('bundle');
        $price1->setValue(212.31);
        $prices = [
            $price,
            $price1
        ];
        $product1->setPrices($prices);

        $this->products = [
            $product,
            $product1
        ];
    }

    public function findAllProducts(): array
    {
        return $this->products;
    }

    public function findProductBySku(string $sku): ?Product
    {
        if ($sku === 'BA-04') {
            return $this->products[0];
        }
        return null;
    }

    public function fakeProductWithPricesDto(): ProductWithPriceDto
    {
        $selectedProduct = $this->products[0];
        return new ProductWithPriceDto($selectedProduct->getSku(), $selectedProduct->getName(),
            $selectedProduct->getDescription(), $selectedProduct->getPrices());
    }
}

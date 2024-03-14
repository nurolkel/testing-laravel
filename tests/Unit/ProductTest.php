<?php

namespace Tests\Unit;

use App\Product;

class ProductTest extends \PHPUnit\Framework\TestCase
{
    protected $product;
    public function setUp(): void
    {
        $this->product = new Product('Fallout 4', 59);
    }

    /** @test  */
    function a_product_has_a_cost()
    {
        $this->assertEquals(59, $this->product->cost());
    }

    /** @test */
    function a_product_has_name()
    {
        $this->assertEquals('Fallout 4', $this->product->name());
    }
}

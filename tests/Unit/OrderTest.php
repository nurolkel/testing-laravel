<?php

use App\Product;
use App\Order;

class OrderTest extends PHPUnit\Framework\TestCase
{
    /** @test */
    function an_order_consists_of_products()
    {
        $this->assertCount(2, ($this->createOrderWithProducts())->products());
    }

    /** @test */
    function an_order_can_determine_the_total_cost_of_all_its_products()
    {
        $this->assertEquals(66 , ($this->createOrderWithProducts())->total());
    }

    protected function createOrderWithProducts()
    {
        $order = new Order;

        $product = new Product('Fallout 4', 59);
        $product2 = new Product('Pillowcase', 7);

        $order->add($product);
        $order->add($product2);

        return $order;
    }
}

<?php

use App\Product;
use App\Order;

class OrderTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    function an_order_consists_of_products()
    {
        $order = $this->createOrderWithProducts();
        $this->assertEquals(2, count($order->products()));
    }
    /**
     * @test
     */
    function an_order_can_determine_the_total_cost_of_all_its_products()
    {
        $order = $this->createOrderWithProducts();
        $this->assertEquals(80, $order->total());
    }
    protected function createOrderWithProducts()
    {
        $order = new Order;
        $product = new Product('1', 50);
        $product2 = new Product('2', 30);
        $order->add($product);
        $order->add($product2);
        return $order;
    }
}

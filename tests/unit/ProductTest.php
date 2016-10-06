<?php

use App\Product;


class ProductTest extends PHPUnit_Framework_TestCase
{
    protected $product;

    function setUp()
    {
        $this->product = new Product('fallout', 4);
    }

    /**
     * @test
     */
    function a_product_has_a_name()
    {
        $this->assertEquals('fallout', $this->product->name());
    }

    /**
     * @test
     */
    function a_product_has_a_cost()
    {
        $this->assertEquals('4', $this->product->cost());
    }

}

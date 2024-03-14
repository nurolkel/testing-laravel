<?php

namespace App;
class Product
{
    protected $name;

    protected $cost;

    protected $product = [];
    public function __construct($name, $cost)
    {
        $this->name = $name;
        $this->cost = $cost;
    }

    public function name()
    {
        return $this->name;
    }

    public function cost()
    {
        return $this->cost;
    }
}

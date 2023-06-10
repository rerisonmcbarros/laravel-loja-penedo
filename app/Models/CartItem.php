<?php

namespace App\Models;

use JsonSerializable;

class CartItem implements JsonSerializable
{
    private Product $product;
    private $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getSubTotal()
    {
        return $this->product->sale_price * $this->quantity;
    }

    public function jsonSerialize()
    {
        return $this;
    }
}

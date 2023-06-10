<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

class Cart
{
    private array $items;

    public function __construct()
    {
        if (!Session::has('cart')) {
            Session::put('cart', []);
        }
        $this->restore();
    }

    public function addItem(Product $product, int $quantity)
    {
        $this->items[$product->id] = new CartItem($product, $quantity);
        Session::put('cart', $this->items);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function hasItem($id)
    {
        if (isset($this->items[$id])) {
            return true;
        }

        return false;
    }

    public function removeItem($id): void
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
            Session::put('cart', $this->items);
        }
    }

    public function getTotal()
    {
        $total = 0;

        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                $total += $item->getSubTotal();
            }
        }

        return $total;
    }

    public function restore()
    {
        $this->items = Session::get('cart');
    }

    public function __destruct()
    {
        Session::put('cart', $this->items);
    }

    public function reset()
    {
        $this->items = [];
        Session::forget(['cart']);
    }
}

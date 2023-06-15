<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

class PurchaseSessionHandler
{
    private array $items;

    public function __construct()
    {
        if (!Session::has('purchase')) {
            Session::put('purchase', []);
        }
        $this->restore();
    }

    public function addItem(PurchaseItemSessionHandler $item)
    {
        $this->items[$item->getCode()] = $item;
        Session::put('purchase', $this->items);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function hasItem($code)
    {
        if (isset($this->items[$code])) {
            return true;
        }

        return false;
    }

    public function removeItem($id): void
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
            Session::put('purchase', $this->items);
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
        $this->items = Session::get('purchase');
    }

    public function reset()
    {
        $this->items = [];
        Session::forget(['purchase']);
    }

    public function __destruct()
    {
        Session::put('purchase', $this->items);
    } 
}

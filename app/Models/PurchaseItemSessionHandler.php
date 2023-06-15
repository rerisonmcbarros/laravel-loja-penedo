<?php

namespace App\Models;

class PurchaseItemSessionHandler 
{   
    private $code;
    private $description;
    private $price;
    private $quantity;

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     */ 
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     */ 
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     */ 
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getSubTotal()
    {
        return $this->price * $this->quantity;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function purchasePrice(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                return $value / 100;
            },

            set: function ($value) {
                return $value * 100;
            }
        );
    }

    public function salePrice(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                return $value / 100;
            },

            set: function ($value) {
                return $value * 100;
            }
        );
    }
}

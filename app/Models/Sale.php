<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function totalValue(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                return  $value / 100;
            },
            set: function ($value) {
                return $value * 100;
            }
        );
    }
}

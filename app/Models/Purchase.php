<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    public function totalValue(): Attribute
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

    public function items(): HasMany 
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id', 'id');
    }
}

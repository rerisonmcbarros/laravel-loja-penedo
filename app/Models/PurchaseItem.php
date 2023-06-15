<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function price(): Attribute
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
    
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

    public function getSubTotal()
    {
        return $this->price * $this->quantity;
    }
}

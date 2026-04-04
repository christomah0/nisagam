<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = ['type', 'product_id', 'quantity', 'unit_price', 'note'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

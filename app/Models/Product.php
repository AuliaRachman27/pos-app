<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TransactionItem;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'price',
        'stock'
    ];

    public function transactionItems()
    {
    return $this->hasMany(TransactionItem::class);
    }
}



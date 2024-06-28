<?php

namespace App\Models;

use App\Traits\WithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    use HasFactory, WithUuid;

    protected $fillable = ['amount'];

    public function items()
    {
        return $this->hasMany(TransactionItem::class)
            ->leftJoin('products', function ($join) {
                $join->on('transaction_items.item_id', '=', 'products.id')
                    ->where('transaction_items.item_type', '=', 'App\Models\Product');
            })
            ->select('transaction_items.*', 'products.quantity as quantity_available');
        ;
    }
}

<?php

namespace App\Models;

use App\Traits\WithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model {
    use HasFactory, WithUuid;
    protected $fillable = ['transaction_id', 'item_id', 'item_name', 'item_type', 'quantity', 'price'];

}

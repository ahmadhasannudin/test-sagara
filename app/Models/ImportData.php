<?php

namespace App\Models;

use App\Traits\WithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportData extends Model {
    use HasFactory, WithUuid;
    protected $table = 'import_data';
    protected $fillable = [
        'pc',
        'trx_id',
        'trx_date',
        'produk_name',
        'product_code',
        'qty',
        'no_tujuan',
        'reseller_code',
        'reseller_name',
        'modul',
        'status',
        'status_date',
        'supplier_name',
        'supplier_stock',
        'buy_price',
        'sell_price',
        'commission',
        'profit',
        'poin',
        'reply_provide',
        'serial_number',
        'ref_id',
        'rate_tp',
        'rate',
        'shell',
        'hbfix',
        'notes',
        'provider_code',
        'provider_name',
    ];
}

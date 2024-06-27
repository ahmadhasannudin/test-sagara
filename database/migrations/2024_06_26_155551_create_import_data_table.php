<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('import_data', function (Blueprint $t) {
            $t->string('pc');
            $t->string('trx_id');
            $t->date('trx_date');
            $t->string('produk_name');
            $t->string('product_code');
            $t->decimal('qty', 18, 2);
            $t->integer('no_tujuan');
            $t->string('reseller_code');
            $t->string('reseller_name');
            $t->string('modul');
            $t->string('status');
            $t->date('status_date');
            $t->string('supplier_name');
            $t->decimal('supplier_stock', 18, 2);
            $t->decimal('buy_price', 18, 2);
            $t->decimal('sell_price', 18, 2);
            $t->decimal('commission', 18, 2);
            $t->decimal('profit', 18, 2);
            $t->integer('poin');
            $t->string('reply_provide');
            $t->string('serial_number');
            $t->string('ref_id');
            $t->decimal('rate_tp', 18, 2);
            $t->decimal('rate', 18, 2);
            $t->decimal('shell', 18, 2);
            $t->string('hbfix');
            $t->string('notes');
            $t->string('provider_code');
            $t->string('provider_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_data');
    }
};

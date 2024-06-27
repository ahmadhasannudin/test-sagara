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
            $t->uuid('id')->primary();
            $t->string('pc')->nullable();
            $t->string('trx_id')->nullable();
            $t->date('trx_date')->nullable();
            $t->string('produk_name')->nullable();
            $t->string('product_code')->nullable();
            $t->decimal('qty', 18, 2)->nullable();
            $t->string('no_tujuan')->nullable();
            $t->string('reseller_code')->nullable();
            $t->string('reseller_name')->nullable();
            $t->string('modul')->nullable();
            $t->string('status')->nullable();
            $t->date('status_date')->nullable();
            $t->string('supplier_name')->nullable();
            $t->decimal('supplier_stock', 18, 2)->nullable();
            $t->decimal('buy_price', 18, 2)->nullable();
            $t->decimal('sell_price', 18, 2)->nullable();
            $t->decimal('commission', 18, 2)->nullable();
            $t->decimal('profit', 18, 2)->nullable();
            $t->integer('poin')->nullable();
            $t->string('reply_provide')->nullable();
            $t->string('serial_number')->nullable();
            $t->string('ref_id')->nullable();
            $t->decimal('rate_tp', 18, 2)->nullable();
            $t->decimal('rate', 18, 2)->nullable();
            $t->decimal('shell', 18, 2)->nullable();
            $t->string('hbfix')->nullable();
            $t->string('notes')->nullable();
            $t->string('provider_code')->nullable();
            $t->string('provider_name')->nullable();
            $t->timestamps();
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

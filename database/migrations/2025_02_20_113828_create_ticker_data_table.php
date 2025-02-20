<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ticker_data', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->decimal('open', 20, 10)->nullable();
            $table->decimal('close', 20, 10)->nullable();
            $table->decimal('high', 20, 10)->nullable();
            $table->decimal('low', 20, 10)->nullable();
            $table->decimal('mark_price', 20, 10)->nullable();
            $table->decimal('mark_change_24h', 10, 5)->nullable();
            $table->decimal('oi', 20, 10)->nullable();
            $table->integer('product_id')->nullable();
            $table->decimal('spot_price', 20, 10);
            $table->bigInteger('volume');
            $table->decimal('turnover', 20, 10)->nullable();
            $table->string('turnover_symbol')->nullable();
            $table->decimal('turnover_usd', 20, 10);
            $table->bigInteger('timestamp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticker_data');
    }
};

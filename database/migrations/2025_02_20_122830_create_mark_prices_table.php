<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mark_prices', function (Blueprint $table) {
            $table->id();
            $table->string('symbol', 50);
            $table->decimal('best_bid', 20, 10)->nullable();
            $table->decimal('best_ask', 20, 10)->nullable();
            $table->decimal('bid_iv', 10, 5)->nullable();
            $table->decimal('ask_iv', 10, 5)->nullable();
            $table->integer('bid_qty')->nullable();
            $table->integer('ask_qty')->nullable();
            $table->decimal('price', 20, 10);
            $table->decimal('delta', 20, 10)->nullable();
            $table->decimal('gamma', 20, 10)->nullable();
            $table->decimal('vega', 20, 10)->nullable();
            $table->decimal('rho', 20, 10)->nullable();
            $table->decimal('implied_volatility', 10, 5)->nullable();
            $table->decimal('lower_limit', 30, 15)->nullable();
            $table->decimal('upper_limit', 30, 15)->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->bigInteger('timestamp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mark_prices');
    }
};

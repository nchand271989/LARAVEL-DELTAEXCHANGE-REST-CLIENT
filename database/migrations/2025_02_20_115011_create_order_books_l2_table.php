<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_books_l2', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->integer('product_id')->nullable();
            $table->json('buy_orders');  // JSON field for buy orders
            $table->json('sell_orders'); // JSON field for sell orders
            $table->bigInteger('last_sequence_no')->nullable();
            $table->bigInteger('last_updated_at')->nullable();
            $table->bigInteger('timestamp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_books_l2');
    }
};

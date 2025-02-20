<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_books', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->decimal('best_bid', 20, 10);
            $table->decimal('best_ask', 20, 10);
            $table->bigInteger('bid_qty');
            $table->bigInteger('ask_qty');
            $table->bigInteger('last_sequence_no')->nullable();
            $table->bigInteger('last_updated_at')->nullable();
            $table->integer('product_id')->nullable();
            $table->bigInteger('timestamp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_books');
    }
};

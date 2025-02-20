<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_books_l2_updates', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->json('asks');
            $table->json('bids');
            $table->bigInteger('sequence_no');
            $table->bigInteger('timestamp');
            $table->bigInteger('checksum')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_books_l2_updates');
    }
};

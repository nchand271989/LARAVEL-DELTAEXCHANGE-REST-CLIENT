<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->string('symbol', 50);
            $table->string('buyer_role', 10); // 'maker' or 'taker'
            $table->string('seller_role', 10); // 'maker' or 'taker'
            $table->unsignedInteger('size'); // Number of contracts
            $table->decimal('price', 20, 10); // Trade price with precision
            $table->bigInteger('timestamp'); // Trade timestamp
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trades');
    }
};

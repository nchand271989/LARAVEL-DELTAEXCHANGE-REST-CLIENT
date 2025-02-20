<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('candlesticks', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->string('type');
            $table->unsignedBigInteger('candle_start_time');
            $table->decimal('open', 20, 8);
            $table->decimal('high', 20, 8);
            $table->decimal('low', 20, 8);
            $table->decimal('close', 20, 8);
            $table->decimal('volume', 20, 8);
            $table->string('resolution');
            $table->unsignedBigInteger('timestamp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('candlesticks');
    }
};

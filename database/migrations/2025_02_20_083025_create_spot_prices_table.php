<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('spot_prices', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->decimal('price', 16, 8);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spot_prices');
    }
};

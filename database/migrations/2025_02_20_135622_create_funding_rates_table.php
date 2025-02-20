<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('funding_rates', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->decimal('funding_rate', 18, 10);
            $table->decimal('funding_rate_8h', 18, 10)->nullable();
            $table->unsignedBigInteger('next_funding_realization')->nullable();
            $table->decimal('predicted_funding_rate', 18, 10)->nullable();
            $table->unsignedBigInteger('timestamp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funding_rates');
    }
};

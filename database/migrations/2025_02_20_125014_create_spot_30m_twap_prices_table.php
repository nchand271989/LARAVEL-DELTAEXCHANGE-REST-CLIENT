<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('spot_30m_twap_prices', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');  // e.g., ".DEXBTUSDT"
            $table->decimal('price', 20, 10);  // Handle precise decimal values
            $table->bigInteger('timestamp');  // Store timestamp in microseconds
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spot_30m_twap_prices');
    }
};

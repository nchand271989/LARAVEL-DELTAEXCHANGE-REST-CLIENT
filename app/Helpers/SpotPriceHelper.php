<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpotPriceHelper
{
    public static function handleSpotPrice($data)
    {
        // Determine the correct keys
        $symbol = $data['symbol'] ?? $data['s'] ?? null;
        $price = $data['price'] ?? $data['p'] ?? null;

        // Validate response structure
        if (!$symbol || !$price) {
            Log::error("Invalid Spot Price response", ['data' => $data]);
            return;
        }

        // Insert into the database
        DB::table('spot_prices')->insert([
            'symbol' => $symbol,
            'price' => $price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("Stored Spot Price: Symbol - {$symbol}, Price - {$price}");
    }


    public static function handleSpot30mTwapPrice($data)
    {
        // Validate response structure
        if (!isset($data['symbol']) || !isset($data['price']) || !isset($data['timestamp'])) {
            Log::error("Invalid Spot 30m TWAP Price response", ['data' => $data]);
            return;
        }

        // Insert Spot 30m TWAP price data into the database
        DB::table('spot_30m_twap_prices')->insert([
            'symbol' => $data['symbol'],
            'price' => $data['price'],
            'timestamp' => $data['timestamp'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("Stored Spot 30m TWAP Price: Symbol - {$data['symbol']}, Price - {$data['price']}");
    }
    
}

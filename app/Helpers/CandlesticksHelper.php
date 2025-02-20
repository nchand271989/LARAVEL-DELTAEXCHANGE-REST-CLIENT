<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CandlesticksHelper
{
    public static function handleCandlesticks($data)
    {
        // Validate response structure
        if (!isset($data['symbol']) || !isset($data['type']) || !isset($data['candle_start_time'])) {
            Log::error("Invalid Candlestick response", ['data' => $data]);
            return;
        }

        // Insert candlestick data into the database
        DB::table('candlesticks')->insert([
            'symbol' => $data['symbol'],
            'type' => $data['type'],
            'candle_start_time' => $data['candle_start_time'],
            'open' => $data['open'],
            'high' => $data['high'],
            'low' => $data['low'],
            'close' => $data['close'],
            'volume' => $data['volume'],
            'resolution' => $data['resolution'],
            'timestamp' => $data['timestamp'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("Stored Candlestick Data: Symbol - {$data['symbol']}, Open - {$data['open']}, Close - {$data['close']}");
    }
    
}

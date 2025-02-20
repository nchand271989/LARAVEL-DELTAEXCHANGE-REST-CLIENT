<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TickerDataHelper
{
    public static function handleTickerData($data)
    {
        if (!isset($data['symbol']) || !isset($data['spot_price']) || !isset($data['volume']) || !isset($data['turnover_usd']) || !isset($data['timestamp'])) {
            Log::error("Invalid ticker response", ['data' => $data]);
            return;
        }

        DB::table('ticker_data')->insert([
            'symbol' => $data['symbol'],
            'open' => $data['open'] ?? null,
            'close' => $data['close'] ?? null,
            'high' => $data['high'] ?? null,
            'low' => $data['low'] ?? null,
            'mark_price' => $data['mark_price'] ?? null,
            'mark_change_24h' => $data['mark_change_24h'] ?? null,
            'oi' => $data['oi'] ?? null,
            'product_id' => $data['product_id'] ?? null,
            'spot_price' => $data['spot_price'],
            'volume' => $data['volume'],
            'turnover' => $data['turnover'] ?? null,
            'turnover_symbol' => $data['turnover_symbol'] ?? null,
            'turnover_usd' => $data['turnover_usd'],
            'timestamp' => $data['timestamp'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("Stored Ticker Data: Symbol - {$data['symbol']}, Spot Price - {$data['spot_price']}, Volume - {$data['volume']}");
    }
    
}

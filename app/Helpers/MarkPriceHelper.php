<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MarkPriceHelper
{
    public static function handleMarkPrice($data)
    {
        // Validate response structure
        if (!isset($data['symbol']) || !isset($data['type']) || !isset($data['price'])) {
            Log::error("Invalid Mark Price response", ['data' => $data]);
            return;
        }

        // Ensure we are handling the correct type of data
        if ($data['type'] !== "mark_price") {
            Log::warning("Ignoring non-Mark Price data: {$data['type']}");
            return;
        }

        // Insert mark price data into the database
        DB::table('mark_prices')->insert([
            'symbol' => $data['symbol'],
            'best_bid' => $data['best_bid'] ?? null,
            'best_ask' => $data['best_ask'] ?? null,
            'bid_iv' => $data['bid_iv'] ?? null,
            'ask_iv' => $data['ask_iv'] ?? null,
            'bid_qty' => $data['bid_qty'] ?? null,
            'ask_qty' => $data['ask_qty'] ?? null,
            'price' => $data['price'],
            'delta' => $data['delta'] ?? null,
            'gamma' => $data['gamma'] ?? null,
            'vega' => $data['vega'] ?? null,
            'rho' => $data['rho'] ?? null,
            'implied_volatility' => $data['implied_volatility'] ?? null,
            'lower_limit' => $data['price_band']['lower_limit'] ?? null,
            'upper_limit' => $data['price_band']['upper_limit'] ?? null,
            'product_id' => $data['product_id'] ?? null,
            'timestamp' => $data['timestamp'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("Stored Mark Price Data: Symbol - {$data['symbol']}, Price - {$data['price']}");
    }
    
}

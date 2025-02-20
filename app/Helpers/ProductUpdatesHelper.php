<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductUpdatesHelper
{
    public static function handleProductUpdates($data)
    {
        // Validate response structure
        if (!isset($data['type']) || !isset($data['event']) || !isset($data['product'])) {
            Log::error("Invalid Product Updates response", ['data' => $data]);
            return;
        }

        // Extract product details
        $product = $data['product'];
        $productId = $product['id'] ?? null;
        $symbol = $product['symbol'] ?? null;
        $tradingStatus = $product['trading_status'] ?? null;
        $event = $data['event'];
        $timestamp = $data['timestamp'] ?? null;

        // Ensure required fields are present
        if (!$productId || !$symbol || !$tradingStatus) {
            Log::error("Missing required product update fields", ['data' => $data]);
            return;
        }

        // Insert into the database
        DB::table('product_updates')->insert([
            'product_id' => $productId,
            'symbol' => $symbol,
            'event' => $event,
            'trading_status' => $tradingStatus,
            'timestamp' => $timestamp,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("Stored Product Update: Symbol - {$symbol}, Event - {$event}, Status - {$tradingStatus}");
    }

}

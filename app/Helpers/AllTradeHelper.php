<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AllTradeHelper
{
    public static function handleAllTrades($data)
    {
        // Validate response structure
        if (!isset($data['symbol']) || !isset($data['type']) || !isset($data['trades'])) {
            Log::error("Invalid All Trades response", ['data' => $data]);
            return;
        }

        // Ensure we are handling the correct type of data
        if ($data['type'] !== "all_trades_snapshot") {
            Log::warning("Ignoring non-snapshot trade data: {$data['type']}");
            return;
        }

        // Process each trade in the snapshot
        $tradesToInsert = [];
        foreach ($data['trades'] as $trade) {
            if (!isset($trade['buyer_role'], $trade['seller_role'], $trade['size'], $trade['price'], $trade['timestamp'])) {
                Log::error("Invalid trade data in All Trades response", ['trade' => $trade]);
                continue;
            }

            $tradesToInsert[] = [
                'symbol' => $data['symbol'],
                'buyer_role' => $trade['buyer_role'],
                'seller_role' => $trade['seller_role'],
                'size' => $trade['size'],
                'price' => $trade['price'],
                'timestamp' => $trade['timestamp'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert trades into the database
        if (!empty($tradesToInsert)) {
            DB::table('trades')->insert($tradesToInsert);
            Log::info("Inserted " . count($tradesToInsert) . " trades for symbol {$data['symbol']}.");
        } else {
            Log::warning("No valid trades found in All Trades snapshot for symbol {$data['symbol']}.");
        }
    }
    
}

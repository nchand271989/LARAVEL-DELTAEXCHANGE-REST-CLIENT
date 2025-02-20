<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderBookHelper
{
    public static function handleOrderBook1($data)
    {
        if (!isset($data['symbol']) || !isset($data['best_bid']) || !isset($data['best_ask']) || !isset($data['bid_qty']) || !isset($data['ask_qty'])) {
            Log::error("Invalid L1 order book response", ['data' => $data]);
            return;
        }

        DB::table('order_books')->insert([
            'symbol' => $data['symbol'],
            'best_bid' => $data['best_bid'],
            'best_ask' => $data['best_ask'],
            'bid_qty' => $data['bid_qty'],
            'ask_qty' => $data['ask_qty'],
            'last_sequence_no' => $data['last_sequence_no'] ?? null,
            'last_updated_at' => $data['last_updated_at'] ?? null,
            'product_id' => $data['product_id'] ?? null,
            'timestamp' => $data['timestamp'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("Stored L1 Order Book: Symbol - {$data['symbol']}, Best Bid - {$data['best_bid']}, Best Ask - {$data['best_ask']}, Bid Qty - {$data['bid_qty']}, Ask Qty - {$data['ask_qty']}");
    }


    public static function handleOrderBook2($data)
    {
        if (!isset($data['symbol']) || !isset($data['buy']) || !isset($data['sell'])) {
            Log::error("Invalid L2 order book response", ['data' => $data]);
            return;
        }

        DB::table('order_books_l2')->insert([
            'symbol' => $data['symbol'],
            'product_id' => $data['product_id'] ?? null,
            'buy_orders' => json_encode($data['buy']),  // Store as JSON
            'sell_orders' => json_encode($data['sell']), // Store as JSON
            'last_sequence_no' => $data['last_sequence_no'] ?? null,
            'last_updated_at' => $data['last_updated_at'] ?? null,
            'timestamp' => $data['timestamp'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("Stored L2 Order Book: Symbol - {$data['symbol']}, Buy Orders - " . count($data['buy']) . ", Sell Orders - " . count($data['sell']));
    }


    public static function handleUpdates($data)
    {
        if (!isset($data['symbol']) || !isset($data['type']) || !isset($data['action'])) {
            Log::error("Invalid L2 update response", ['data' => $data]);
            return;
        }

        // Handle Error Response
        if ($data['action'] === 'error') {
            Log::error("L2 Updates Error: {$data['msg']}");
            return;
        }

        // Process Snapshot Response
        if ($data['action'] === 'snapshot') {
            DB::table('order_books_l2_updates')->insert([
                'symbol' => $data['symbol'],
                'asks' => json_encode($data['asks']),  // Store Asks as JSON
                'bids' => json_encode($data['bids']),  // Store Bids as JSON
                'sequence_no' => $data['sequence_no'],
                'timestamp' => $data['timestamp'],
                'checksum' => $data['cs'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info("Stored L2 Order Book Snapshot: Symbol - {$data['symbol']}, Bids - " . count($data['bids']) . ", Asks - " . count($data['asks']));
        }

        // Process Incremental Update Response
        elseif ($data['action'] === 'update') {
            DB::table('order_books_l2_updates')->insert([
                'symbol' => $data['symbol'],
                'asks' => json_encode($data['asks']),  // Updated Asks
                'bids' => json_encode($data['bids']),  // Updated Bids
                'sequence_no' => $data['sequence_no'],
                'timestamp' => $data['timestamp'],
                'checksum' => $data['cs'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info("Updated L2 Order Book: Symbol - {$data['symbol']}, Updated Bids - " . count($data['bids']) . ", Updated Asks - " . count($data['asks']));
        }
    }
    
}

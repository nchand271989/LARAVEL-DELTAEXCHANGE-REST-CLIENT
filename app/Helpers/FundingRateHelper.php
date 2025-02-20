<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FundingRateHelper
{
    public static function handleFundingRate($data)
    {
        // Validate response structure
        if (!isset($data['symbol']) || !isset($data['type']) || !isset($data['funding_rate'])) {
            Log::error("Invalid Funding Rate response", ['data' => $data]);
            return;
        }

        // Ensure we are handling the correct type of data
        if ($data['type'] !== "funding_rate") {
            Log::warning("Ignoring non-Funding Rate data: {$data['type']}");
            return;
        }

        // Insert funding rate data into the database
        DB::table('funding_rates')->insert([
            'symbol' => $data['symbol'],
            'product_id' => $data['product_id'] ?? null,
            'funding_rate' => $data['funding_rate'],
            'funding_rate_8h' => $data['funding_rate_8h'] ?? null,
            'next_funding_realization' => $data['next_funding_realization'] ?? null,
            'predicted_funding_rate' => $data['predicted_funding_rate'] ?? null,
            'timestamp' => $data['timestamp'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("Stored Funding Rate: Symbol - {$data['symbol']}, Rate - {$data['funding_rate']}");
    }
    
}

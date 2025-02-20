<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeltaExchangeService
{
    protected $baseUrl;
    protected $apiKey;
    protected $apiSecret;

    public function __construct()
    {
        $this->baseUrl = config('app.delta_base_url', 'https://api.india.delta.exchange/v2');
        $this->apiKey = config('app.delta_api_key');
        $this->apiSecret = config('app.delta_api_secret');
    }

    /**
     * Generate HMAC-SHA256 Signature for Authentication
     */
    private function generateSignature($method, $path, $queryParams = '', $body = '')
    {
        $timestamp = round(microtime(true) * 1000); // Current time in milliseconds
        $prehash = $method . $timestamp . $path . $queryParams . $body;
        $signature = hash_hmac('sha256', $prehash, $this->apiSecret);

        return [
            'signature' => $signature,
            'timestamp' => $timestamp
        ];
    }

    /**
     * Send an authenticated request to Delta Exchange API
     */
    private function sendRequest($method, $endpoint, $queryParams = [], $body = [])
    {
        $queryString = http_build_query($queryParams);
        $url = $this->baseUrl . $endpoint . ($queryString ? '?' . $queryString : '');
        
        // Generate Signature
        $authData = $this->generateSignature($method, $endpoint, $queryString, json_encode($body));
        
        // Set Headers
        $headers = [
            'Accept' => 'application/json',
            'api-key' => $this->apiKey,
            'signature' => $authData['signature'],
            'timestamp' => $authData['timestamp'],
            'Content-Type' => 'application/json',
        ];

        // Make HTTP Request
        $response = Http::withHeaders($headers)->$method($url, $body);
        
        // Log errors if any
        if (!$response->successful()) {
            Log::error("Delta Exchange API Error: ", $response->json());
        }

        return $response->json();
    }

    /**
     * Get List of Assets (No Authentication Required)
     */
    public function getAssets()
    {
        return Http::acceptJson()->get("{$this->baseUrl}/assets")->json();
    }

    /**
     * Get List of Indices (No Authentication Required)
     */
    public function getIndices()
    {
        return Http::acceptJson()->get("{$this->baseUrl}/indices")->json();
    }

    /**
     * Get Account Balance (Requires Authentication)
     */
    public function getAccountBalance()
    {
        return $this->sendRequest('get', '/wallet/balances');
    }

    /**
     * Place an Order (Requires Authentication)
     */
    public function placeOrder($symbol, $size, $price, $side)
    {
        $body = [
            "product_id" => $symbol,
            "size" => $size,
            "price" => $price,
            "side" => $side
        ];

        return $this->sendRequest('post', '/orders', [], $body);
    }
}

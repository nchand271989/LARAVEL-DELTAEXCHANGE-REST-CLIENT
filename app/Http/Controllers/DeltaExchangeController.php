<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeltaExchangeService;

class DeltaExchangeController extends Controller
{
    protected $deltaService;

    public function __construct(DeltaExchangeService $deltaService)
    {
        $this->deltaService = $deltaService;
    }

    /**
     * Fetch and return the list of assets
     */
    public function assets()
    {
        return response()->json($this->deltaService->getAssets());
    }

    /**
     * Fetch and return the list of indices
     */
    public function indices()
    {
        return response()->json($this->deltaService->getIndices());
    }

    /**
     * Fetch account balance (Requires Authentication)
     */
    public function accountBalance()
    {
        return response()->json($this->deltaService->getAccountBalance());
    }

    /**
     * Place an order
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'symbol' => 'required|string',
            'size' => 'required|numeric',
            'price' => 'required|numeric',
            'side' => 'required|string|in:buy,sell',
        ]);

        return response()->json($this->deltaService->placeOrder(
            $request->symbol,
            $request->size,
            $request->price,
            $request->side
        ));
    }
}

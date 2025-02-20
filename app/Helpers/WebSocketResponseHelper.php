<?php

namespace App\Helpers;

use App\Helpers\SpotPriceHelper;
use App\Helpers\TickerDataHelper;
use App\Helpers\OrderBookHelper;
use App\Helpers\AllTradeHelper;
use App\Helpers\MarkPriceHelper;
use App\Helpers\FundingRateHelper;
use App\Helpers\ProductUpdatesHelper;
use App\Helpers\AnnouncementsHelper;
use App\Helpers\CandlesticksHelper;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebSocketResponseHelper
{
    public static function handleResponse($channel, $data)
    {
        switch ($channel) {
            
            case 'v2/ticker':
                TickerDataHelper::handleTickerData($data);
                break;

            case 'l1_orderbook':
                OrderBookHelper::handleOrderBook1($data);
                break;
            
            case 'l2_orderbook':
                OrderBookHelper::handleOrderBook2($data);
                break;

            case 'l2_updates':
                OrderBookHelper::handleUpdates($data);
                break;

            case 'all_trades':
                AllTradeHelper::handleAllTrades($data);
                break;

            case 'mark_price':
                MarkPriceHelper::handleMarkPrice($data);
                break;

            case 'spot_price':
                SpotPriceHelper::handleSpotPrice($data);
                break;
            
            case 'v2/spot_price':
                SpotPriceHelper::handleSpotPrice($data);
                break;

            case 'spot_30mtwap_price':
                SpotPriceHelper::handleSpot30mTwapPrice($data);
                break;

            case 'funding_rate':
                FundingRateHelper::handleFundingRate($data);
                break;

            case 'product_updates':
                ProductUpdatesHelper::handleProductUpdates($data);
                break;

            case 'announcements':
                AnnouncementsHelper::handleAnnouncements($data);
                break;

            case 'candlesticks':
                CandlesticksHelper::handleCandlesticks($data);
                break;

            default:
                Log::warning("Unhandled WebSocket response for channel: {$channel}", ['data' => $data]);
                break;
        }
    }
    
}

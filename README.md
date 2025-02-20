# Delta Exchange WebSocket Client for Laravel

This repository provides a WebSocket client for the Delta Exchange API built using Laravel. It simplifies real-time data fetching and market updates, making it easier to integrate with trading and portfolio management systems.

The client utilizes Laravel's command structure and ReactPHP for handling WebSocket connections, ensuring efficient and persistent data streaming.

## 📌 Features

-   **Real-time WebSocket Data Streaming**: Fetch live market data directly from Delta Exchange.
-   **Multiple Subscription Channels**: Support for various market data feeds.
-   **Automatic Reconnection**: Ensures persistent connections even after disconnects.
-   **Efficient Event Handling**: Parses and processes incoming WebSocket messages.

## 🚀 Installation

To install the required dependencies, run:

```sh
composer require ratchet/pawl react/event-loop react/socket
```

## 📡 WebSocket Subscription Commands

Use the following Artisan commands to subscribe to different WebSocket channels:

```sh
php artisan websocket:subscribe v2/ticker BTCUSD
php artisan websocket:subscribe l1_orderbook ETHUSD
php artisan websocket:subscribe l2_orderbook ETHUSD
php artisan websocket:subscribe l2_updates BTCUSD
php artisan websocket:subscribe all_trades BTCUSD
php artisan websocket:subscribe mark_price BTCUSD
php artisan websocket:subscribe spot_price .DEETHUSDT
php artisan websocket:subscribe v2/spot_price .DEETHUSDT
php artisan websocket:subscribe spot_30mtwap_price .DEXBTUSDT
php artisan websocket:subscribe funding_rate BTCUSD
php artisan websocket:subscribe product_updates
php artisan websocket:subscribe announcements
php artisan websocket:subscribe candlestick_1m BTCUSD
```

## 🔧 Configuration

-   Ensure that your Laravel project is correctly set up and dependencies are installed.
-   Update the WebSocket connection URL if necessary in the `WebSocketSubscriber.php` file.
-   Implement the required data handling logic inside `WebSocketResponseHelper.php`.

## 🤖 Handling WebSocket Responses

Each WebSocket message is processed and stored accordingly. Ensure that your Laravel migrations are set up for storing the data.

## 🛠️ Contributing

Feel free to contribute by submitting issues or pull requests!

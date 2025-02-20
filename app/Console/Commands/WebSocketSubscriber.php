<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function Ratchet\Client\connect;
use Illuminate\Support\Facades\Log;
use React\EventLoop\Factory;
use React\EventLoop\TimerInterface;
use App\Helpers\WebSocketResponseHelper;

class WebSocketSubscriber extends Command
{
    protected $signature = 'websocket:subscribe {channel} {symbols?*}';
    protected $description = 'Subscribe to WebSocket and fetch real-time data';

    private $webSocketUrl = "wss://socket.india.delta.exchange";

    public function handle()
    {
        $channel = $this->argument('channel');
        $symbols = $this->argument('symbols')?? null;

        $this->info("Connecting to WebSocket: {$this->webSocketUrl} for channel: {$channel}");

        $loop = Factory::create(); 

        connect($this->webSocketUrl, [], [], $loop)->then(
            function ($conn) use ($loop, $channel, $symbols) {
                $this->info("Connected to WebSocket!");

                $channelData = ["name" => $channel]; // Base channel structure

                // Add "symbols" only if it is provided and not empty
                if (!empty($symbols)) {
                    $channelData["symbols"] = $symbols;
                }

                $subscribeMessage = json_encode([
                    "type" => "subscribe",
                    "payload" => [
                        "channels" => [$channelData]
                    ]
                ]);

                $conn->send($subscribeMessage);
                $this->info("Subscription request sent: " . $subscribeMessage);

                // Handle incoming messages
                $conn->on('message', function ($msg) use ($channel) {
                    $this->info("Raw Message Received: " . $msg);
                    $data = json_decode($msg, true);

                    if (isset($data['type']) && $data['type'] === $channel) {
                        WebSocketResponseHelper::handleResponse($channel, $data);
                    } else {
                        Log::warning("Unexpected message format", ['message' => $msg]);
                    }
                });

                // Periodic ping
                $loop->addPeriodicTimer(30, function (TimerInterface $timer) use ($conn) {
                    $conn->send(json_encode(["type" => "ping"]));
                    $this->info("Ping sent.");
                });

                // Handle disconnection
                $conn->on('close', function ($code = null, $reason = null) use ($loop) {
                    $this->warn("WebSocket closed! Code: $code, Reason: $reason");
                    $loop->stop();
                    sleep(5);
                    $this->handle();
                });
            },
            function ($e) use ($loop) {
                $this->error("WebSocket Error: " . $e->getMessage());
                $loop->stop();
                sleep(5);
                $this->handle();
            }
        );

        $loop->run();
    }
}

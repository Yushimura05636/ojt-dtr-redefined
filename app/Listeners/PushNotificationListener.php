<?php

namespace App\Listeners;

use App\Events\PushNotificationEvent;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PushNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */

     protected $instance_id;
     protected $secret_key;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PushNotificationEvent  $event
     * @return void
     */
    public function handle(PushNotificationEvent $event)
    {
        // $this->instance_id = 'af05fccf-1db1-431e-a840-f6f2fbee9ff2';
        // $this->secret_key = 'Bearer EF97716DF23703055D43A5B1CC8450F63A73C56877D44C5B3090E82406CDD882';

        $this->instance_id = env('PUSHER_APP_ID');
        $this->secret_key = env('PUSHER_APP_SECRET');


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->secret_key,
        ])->post("https://$this->instance_id.pushnotifications.pusher.com/publish_api/v1/instances/af05fccf-1db1-431e-a840-f6f2fbee9ff2/publishes", [
            "interests" => ["hello"],
            "web" => [
                "notification" => [
                    "title" => "Hello",
                    "body" => "Hello, world!",
                ]
            ]
        ]);
    }
}

<?php

namespace App\Events;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

use Illuminate\Queue\SerializesModels;
use Pusher\Pusher;
use Symfony\Component\HttpFoundation\Request;

class PushNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $month;
    public $year;
    public $from_user_id;
    public $to_user_id;

    protected $pusher;

    protected $role;

    /**
     * Create a new event instance.
     */
    public function __construct(Request $request, $type = null)
    {

        $this->pusher = new Pusher(
            env("PUSHER_APP_KEY"),
            env("PUSHER_APP_SECRET"),
            env("PUSHER_APP_ID"),
            ["cluster" => env("PUSHER_APP_CLUSTER"), "useTLS" => true]
        );

        switch ($type) {
            case 'send-download-approval-dtr':
                $this->month = $request->month;
                $this->year = $request->year;
                $this->message = $request->message;
                $this->from_user_id = $request->from_user_id;
                $this->role = $request->role;
        
                $this->sendDtrApprovalPushNotification();
                break;
            case 'send-response-download-dtr':
                $this->to_user_id = $request->to_user_id;
                $this->message = $request->message;

                $this->sendDtrResponsePushNotification();
                break;
            case 'send-chat-message':
                $this->from_user_id = $request->from_user_id;
                $this->to_user_id = $request->to_user_id;
                $this->message = $request->message;

                $this->sendChatMessagePushNotification();

                break;
        }
    }

    /**
     * Manually trigger Pusher.
     */

    public function sendChatMessagePushNotification()
    {

    }
    public function sendDtrResponsePushNotification()
    {
        $this->pusher->trigger("public-notifications", "user-notification-{$this->to_user_id}", [
            'message' => $this->message,
            'success' => true,
        ]);
    }
    public function sendDtrApprovalPushNotification()
    {

        //if the user has role admin and is more than 1 use forloop
        $users = User::where('role', $this->role)->get();

        if(isset($user) || $users != null)
        {
            foreach($users as $user){
                // ✅ Send event to a PUBLIC CHANNEL
                $this->pusher->trigger("public-notifications", "user-notification-{$user->id}", [
                    'message' => $this->message,
                    'success' => true,
                ]);
            }
        }


        // // Send only to a private channel for user 1
        // $pusher->trigger('private-notifications.' . $this->user_id, 'form-submitted', $data);
    }

    public function broadCastOn()
    {
        return new PrivateChannel('private-notifications.' . $this->user_id);
    }

    public function broadCastAs()
    {
        return 'chat-message';
    }

    public function broadCastWith(){
        return [
            'message' => $this->message,
        ];
    }
}

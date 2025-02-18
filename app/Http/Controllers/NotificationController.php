<?php

namespace App\Http\Controllers;

use App\Events\PushNotificationEvent;
use App\Models\DtrDownloadRequest;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class NotificationController extends Controller
{
    // public function sendNotification(Request $request)
    // {
    //     $userId = $request->user_id;
    //     $title = "New Notification!";
    //     $body = "You have a new message.";
    
    //     event(new PushNotificationEvent($title, $body, $userId));

    //     return response()->json(['message' => 'Notification sent to user ' . $userId]);
    // }

    public function sendAdminNotification(Request $request)
    {

        $from_user_id = Auth::id();
        
        $message = "User " . User::where('id', $from_user_id)->first()->firstname . 
        'has requested to download the dtr: ' . Carbon::createFromDate($request->year, $request->month, 1)->format('M Y');
        
        $data = [
            "from_user_id" => $from_user_id,
            "to_user_id" => $request->to_user_id,
            "month" => $request->month,
            "year" => $request->year,
            "message" => $message,
        ];

        $request = new Request($data);

        event(new PushNotificationEvent($request, 'send-download-approval-dtr'));

        Notification::create([
            'user_id' => $request->to_user_id,
            'message' => $message,
            'is_read' => false,
            'is_archive' => false,
        ]);

        DtrDownloadRequest::create([
            'user_id' => $from_user_id,
            'month' => $request->month,
            'year' => $request->year,
        ]);

        return response()->json(['message' => 'success!', 'success' => true]);
    }

    public function receiveNotificationIndex()
    {
        $notificationIndex = Notification::where('user_id', Auth::id())->get();

        //return view('receive.notification', compact('notificationIndex'));
        return view('receive.notification', [
            'notificationIndex' => $notificationIndex,
        ]);
    }

    public function readUserNotification()
    {
        $notifications = Notification::where('user_id', Auth::id())->get();

        foreach ($notifications as $notification) {
            $notification->is_read = true;
            $notification->save(); // Save each notification update
        }

        //return view('receive.notification', compact('notificationIndex'));
        return view('admin-test-notification-page', [
            'notificationIndex' => $notifications,
        ]);
    }

    public function readAdminNotification($id)
    {
        $notification = Notification::where('id', $id)->first();

        $notification->is_read = true;
        $notification->save(); // Save each notification update

        // $dtrRequestIndex = DtrDownloadRequest::get();

        return response()->json(['success' => true, 'message' => 'The message has been mark as read!']);

        // //return view('receive.notification', compact('notificationIndex'));
        // return view('notifications', [
        //     'notificationIndex' => $notifications,
        //     'dtrRequestIndex' => $dtrRequestIndex,
        // ]);
    }

    public function archiveAdminNotification($id)
    {
        
        $notification = Notification::where('id', $id)
        ->first();

        if ($notification) {
            $notification->is_archive = 1;
            $notification->is_read = 1;
            $notification->save(); // Correct way to save changes
        } else {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        return back()->with(['success' => 'The message has been archived!']);
    }
}

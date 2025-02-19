<?php

namespace App\Http\Controllers;

use App\Events\PushNotificationEvent;
use App\Models\DtrDownloadRequest;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $Fullname = User::where('id', $from_user_id)->first();

        $dateMessage = Carbon::createFromDate($request->year, $request->month, 1)->format('M Y');
        
        $message = ucwords(strtolower($Fullname->firstname . ' ' . substr($Fullname->middlename, 0, 1) . '. ' . $Fullname->lastname)) .
            ' has requested to download the DTR. ' . $dateMessage;
        
        $data = [
            "from_user_id" => $from_user_id,
            "to_user_id" => $request->to_user_id,
            "month" => $request->month,
            "year" => $request->year,
            "message" => $message,
            'role' => $request->to_user_role,
        ];

        $request = new Request($data);

        event(new PushNotificationEvent($request, 'send-download-approval-dtr'));

        //@dd($request->all(), $dtr_download_request);
        $users_role = User::where('role', $request->role)->get();

        if(isset($users_role)){
            foreach($users_role as $usr){
                Notification::create([
                    'user_id' => $usr->id,
                    'message' => $message,
                    'is_read' => false,
                    'is_archive' => false,
                ]);
            }
        }

        // Notification::create([
        //     'user_id' => $request->to_user_id,
        //     'message' => $message,
        //     'is_read' => false,
        //     'is_archive' => false,
        // ]);

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
        DB::beginTransaction();

        try {
            $notification = Notification::find($id);

            if (!$notification) {
                return response()->json(['error' => 'Notification not found'], 404);
            }

            $notification->is_archive = 1;
            $notification->save();

            DB::commit();
            return back()->with(['success' => 'The message has been archived!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}

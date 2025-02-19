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

class DtrDownloadRequestController extends Controller
{
    public function approve(Request $request)
    {
        //send the download request
        $validator = Validator::make($request->all(), [
            'month' => 'required',
            'year' => 'required',
            'to_user_id' => 'required',
            'from_user_id' => 'required',
        ]);

        
        if ($validator->fails()) {
            return back()->with(['invalid' => $validator->errors()]);
        }
        
        //get the current user who push the approve
        $from_user_id = Auth::id();
        
        $dtr_download_request = DtrDownloadRequest::where('id', $request->id)
        ->where('user_id', $request->to_user_id)
        ->where('month', $request->month)
        ->where('year', $request->year)
        ->first();
        
        if(!isset($dtr_download_request))
        {
            return back()->with('invalid', 'The request does not exists!');
        }
        
        //this will save the date_approved and approved_by
        $dtr_download_request->status = 'approved';
        $dtr_download_request->date_approved = Carbon::now();
        $dtr_download_request->approved_by = $from_user_id;
        $dtr_download_request->created_at = Carbon::now();
        $dtr_download_request->save();
        $dtr_download_request->fresh();
        
        //@dd($dtr_download_request, $request->to_user_id, $request->all());
        $message = 'Your download request dtr date: ' . Carbon::createFromDate($request->year, $request->month, 1)->format('M Y') . ' has been approved!';
        
        //@dd($request->all(), $dtr_download_request);
        Notification::create([
            'user_id' => $request->to_user_id,
            'message' => $message,
            'is_read' => false,
            'is_archive' => false,
        ]);

        $data = [
            'from_user_id' => $from_user_id,
            'to_user_id' => $request->to_user_id,
            'month' => $request->month,
            'year' => $request->year,
            'message' => $message,
            'role' => $request->to_user_role,
        ];

    
        $request = new Request($data);
        
        //send notification to user that the request is approved
        event(new PushNotificationEvent($request, 'send-response-download-dtr'));

        return back()->with(['success' => 'The dtr request has been approved!', 'status' => 'approved']);
    }

    public function batchApprove(Request $request)
    {
        try {
            DB::beginTransaction();
            //send the download request
            $validator = Validator::make($request->all(), [
                'selectedIds' => 'required',
            ]);
            
            if ($validator->fails()) {
                return back()->with(['invalid' => $validator->errors()]);
            }
            
            //get the current user who push the approve
            $from_user_id = Auth::id();

            foreach($request->selectedIds as $id)
            {
                $dtr_download_request = DtrDownloadRequest::where('id', $id)
                ->first();

                
                $dtr_download_request->status = 'approved';
                $dtr_download_request->created_at = Carbon::now();
                $dtr_download_request->date_approved = Carbon::now();
                $dtr_download_request->approved_by = $from_user_id;
                $dtr_download_request->save();
                $dtr_download_request->fresh();
                
                if(!isset($dtr_download_request))
                {
                    return back()->with('invalid', 'The request does not exists!');
                }
                
                //@dd($dtr_download_request, $request->to_user_id, $request->all());
                $message = 'Your download request dtr date: ' . Carbon::createFromDate($dtr_download_request->year, $dtr_download_request->month, 1)->format('M Y') . ' has been approved!';
                
                //@dd($request->all(), $dtr_download_request);
                $notification = Notification::create([
                    'user_id' => $dtr_download_request->user_id,
                    'message' => $message,
                    'is_read' => false,
                    'is_archive' => false,
                ]);
                
                $data = [
                    'from_user_id' => $from_user_id,
                    'to_user_id' => $dtr_download_request->user_id,
                    'month' => $dtr_download_request->month,
                    'year' => $dtr_download_request->year,
                    'message' => $message,
                ];
                
                
                $request = new Request($data);

                //send notification to user that the request is approved
                event(new PushNotificationEvent($request, 'send-response-download-dtr'));

                DB::commit();
            }
            
            return back()->with(['success' => 'All the dtr request has been approved!', 'status' => 'approved']);
        }
        catch(\Exception $ex){
            DB::rollBack();
            return back()->with(['invalid' => $ex->getMessage()]);
        }
    }

    public function decline(Request $request)
    {
        //send the download request
        $validator = Validator::make($request->all(), [
            'month' => 'required',
            'year' => 'required',
            'to_user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with(['invalid' => $validator->errors()]);
        }

        //get the current user who push the approve
        $from_user_id = Auth::id();

        $dtr_download_request = DtrDownloadRequest::where('id', $request->id)
        ->where('user_id', $request->to_user_id)
        ->where('month', $request->month)
        ->where('year', $request->year)
        ->first();
        
        if(!isset($dtr_download_request))
        {
            return back()->with('invalid', 'The request does not exists!');
        }
        
        $dtr_download_request->status = 'declined';
        $dtr_download_request->date_declined = Carbon::now();
        $dtr_download_request->declined_by = $from_user_id;
        $dtr_download_request->save();
        $dtr_download_request->fresh();

        $message = 'Your download request dtr date: ' . Carbon::createFromDate($request->year, $request->month, 1)->format('M Y') . ' has been declined!';

        Notification::create([
            'user_id' => $request->to_user_id,
            'message' => $message,
            'is_read' => false,
            'is_archive' => false,
        ]);

        $data = [
            'from_user_id' => $from_user_id,
            'to_user_id' => $request->to_user_id,
            'month' => $request->month,
            'year' => $request->year,
            'message' => $message,
        ];

        $request = new Request($data);

        //send notification to user that the request is approved
        event(new PushNotificationEvent($request, 'send-response-download-dtr'));

        return back()->with(['success' => 'The dtr request has been declined!', 'status' => 'declined']);
    }

    public function batchDecline(Request $request)
    {
        
        try {
            DB::beginTransaction();
            //send the download request
            $validator = Validator::make($request->all(), [
                'selectedIds' => 'required',
            ]);
            
            if ($validator->fails()) {
                return back()->with(['invalid' => $validator->errors()]);
            }
            
            //get the current user who push the approve
            $from_user_id = Auth::id();

            foreach($request->selectedIds as $id)
            {
                $dtr_download_request = DtrDownloadRequest::where('id', $id)
                ->first();

                $dtr_download_request->status = 'declined';
                $dtr_download_request->created_at = Carbon::now();
                $dtr_download_request->date_declined = Carbon::now();
                $dtr_download_request->declined_by = $from_user_id;
                $dtr_download_request->save();
                $dtr_download_request->fresh();

                if(!isset($dtr_download_request))
                {
                    return back()->with('invalid', 'The request does not exists!');
                }
                
                //@dd($dtr_download_request, $request->to_user_id, $request->all());
                $message = 'Your download request dtr date: ' . Carbon::createFromDate($dtr_download_request->year, $dtr_download_request->month, 1)->format('M Y') . ' has been declined!';

                //@dd($request->all(), $dtr_download_request);
                Notification::create([
                    'user_id' => $dtr_download_request->user_id,
                    'message' => $message,
                    'is_read' => false,
                    'is_archive' => false,
                ]);
        
                $data = [
                    'from_user_id' => $from_user_id,
                    'to_user_id' => $dtr_download_request->user_id,
                    'month' => $dtr_download_request->month,
                    'year' => $dtr_download_request->year,
                    'message' => $message,
                ];
        
            
                $request = new Request($data);
                
                //send notification to user that the request is approved
                event(new PushNotificationEvent($request, 'send-response-download-dtr'));

                DB::commit();
            }
            
            return back()->with(['success' => 'All the dtr request has been declined!', 'status' => 'declined']);
        }
        catch(\Exception $ex){
            DB::rollBack();
            return back()->with(['invalid' => $ex->getMessage()]);
        }
    }

    public function UserdownloadRequestStatusDashboard()
    {
        //user auth()
        $user = Auth::user();

        $downloadRequest = DtrDownloadRequest::with('users')->where('user_id', $user->id)->get()->sortByDesc('created_at');

        return $downloadRequest;
    }

    public function UserdownloadRequestPage()
    {
        $user = Auth::user();

$downloadRequest = DtrDownloadRequest::with('users')
    ->where('user_id', $user->id)
    ->get()
    ->map(function ($request) {
        return [
            'id' => $request->id,
            'title' => match ($request->status) {
                'approved' => 'Request for DTR Approval',
                'declined' => 'Request for DTR Approval',
                'pending'  => 'Request for DTR Approval',
                default    => 'Unknown status',
            },
            'statusKey' => $request->status,
            'statusText' => match ($request->status) {
                'pending'  => 'Waiting for approval',
                'approved' => 'Ready to download',
                'declined' => 'Declined',
                default    => 'Unknown',
            },
            'statusColor' => match ($request->status) {
                'approved' => 'text-green-500',
                'pending'  => 'text-blue-500',
                'declined' => 'text-red-500',
                default    => 'text-gray-500',
            },
            'user_id' => $request->user_id,
            'month' => $request->month,
            'year' => $request->year,
            'status' => $request->status,
            'date' => strtotime($request->created_at), // Convert to timestamp for sorting
            'formattedDate' => date('M d, Y', strtotime($request->created_at)), // Format as "Feb 16, 2025"
            'date_approved' => $request->date_approved ? Carbon::parse($request->date_approved)->format('M d, Y') : null, // Format as "Feb 16, 2025" ,
            'date_declined' => $request->date_declined ? Carbon::parse($request->date_declined)->format('M d, Y') : null, // Format as "Feb 16, 2025" ,
        ];
    })->sortByDesc('date');

    return $downloadRequest;

    }
}
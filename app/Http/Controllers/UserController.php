<?php

namespace App\Http\Controllers;

use App\Models\DtrDownloadRequest;
use App\Models\Histories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HistoryController;
use Carbon\Carbon;
use Illuminate\Http\Response;
use App\Mail\EmailShiftNotification;

class UserController extends Controller
{


    //this function will return all the users data in the database
    public function index()
    {
        //get all user data
        $users = User::all();

        //return the users data to the view
        return view('users.profile.index', compact('users'));
    }

    public function showSettings()
    {
        $user = Auth::user();
        return view('users.settings', [
            'user' => $user,
        ]);
    }

    public function AdminScannerTimeCheck(Request $request, EmailController $emailController)
{
    try {
        // initialized the success text
        $success_text = "";

        // get the user data from the qr code
        $userData = User::where('qr_code', $request->qr_code)->first();

        // Check if the user exists
        if (!$userData) {
            return back()->with('error', 'User not found.');
        }

        // initialized the histories object(table)
        $timeCheck = new Histories();

        // set the user id
        $timeCheck->user_id = $userData->id;

        // set the datetime
        // internet global time
        $timeCheck->datetime = Carbon::now()->timezone('Asia/Manila');

        // Validate the type of time check
        if (!in_array($request->type, ['time_in', 'time_out'])) {
            return response()->json(['success' => false, 'message' => 'Invalid time check type']);
        }

        // it will be depends if time in or time out
        if ($request->type == 'time_in') {
            // this will set the description to time in
            $timeCheck->description = 'time in';
            $success_text = "Time in checked successfully";
        } else if ($request->type == 'time_out') {
            // this will set the description to time out
            $timeCheck->description = 'time out';
            $success_text = "Time out checked successfully";
        }

        // save the data to the database
        $timeCheck->save();

        // send the shift notification email
        try {
            $sendShiftNotification = $emailController->EmailShiftNotification($userData, $timeCheck);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        // return the success text
        // return back()->with('success', $success_text);
        return response()->json(['success' => true, 'message' => $success_text]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Something went wrong.']);
    }
}


    // public function showDTR(DtrSummaryController $dtrSummaryController, Request $request)
    // {
    //     try {

    //         //initialize the local variables
    //         //this variables only to be used in this function so it wont conflict with the global variables 
    //         $users = null;
    //         $histories = null;
    //         $records = [];

    //         //get the user access that is currently logged in
    //         $user_access = Auth::user();

    //         //get the total hours of the user
    //         //the return of this function is an array
    //         //eaxmple
    //         //$groupedData
    //         //$groupedData['Time in']
    //         //$groupedData['Time out']
    //         //$groupedData['Hours worked']
    //         //$totalHours = $dtrSummaryController->ShowUserDtrSummary($request);

    //         //check if the auth user is admin which is based on their role
    //         if ($user_access->role == 'admin') {

    //             //get the user history data with history relation
    //             $users = User::with('history')->get();

    //             //get the history data with user relation
    //             $histories = Histories::with('user')->get();

    //             //this lopp will parse the history data and the user data
    //             //and will return the data in an array
    //             foreach ($histories as $history) {
    //                 $user = $users->firstWhere('id', $history->user_id);
    //                 $records[] = [
    //                     'user' => $user,
    //                     'history' => $history,
    //                 ];
    //             }
    //         }

    //         //if the role is admin it will go to this page
    //         if ($user_access->role == 'admin') {
    //             return view('dtr.index', [
    //                 'records' => $records,
    //                 'type' => 'admin',
    //             ]);
    //         } 
    //         else {

    //             //this data will be store in the requrest object
    //             if($request->month == null && $request->year == null){
    //                 $data = [
    //                     'year' => Carbon::now()->year,
    //                     'month' => Carbon::now()->month,
    //                 ];
    //             }
    //             else{
    //                 $data = [
    //                     'year' => $request->year,
    //                     'month' => $request->month,
    //                 ];
    //             }

    //             //this will return the total hours of the user
    //             $request = new Request($data);

    //             //then the $request will be passed to the DtrSummary function
    //             $totalHours = $dtrSummaryController->ShowUserDtrSummary($request);

    //             //then the $totalHours will be passed to the view dtr.index
    //             //with the data of array['type' => 'user', 'groupedData' => $totalHours]

    //             return redirect()->route('users.dtr', [
    //                 // 'type' => 'user',
    //                 // 'groupedData' => $totalHours,
    //                 // 'selectedMonth' => $totalHours['selectedMonth'],
    //                 // 'selectedYear' => $totalHours['selectedYear'],
    //                 // 'totalHoursPerMonth' => $totalHours['totalHoursPerMonth'],

    //             ]);
    //         }

    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage(), 'valid' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }


    // public function showDTR(DtrSummaryController $dtrSummaryController, Request $request)
    // {
    //     try {
    //         $totalHours = $dtrSummaryController->ShowUserDtrSummary($request);
    //         dd('stop');
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage(), 'valid' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }
    public function showAdminProfile(RankingController $rankingController, HistoryController $historyController)
    {
        $user = Auth::user();

        return view('admin.profile.index', [
            'user' => $user,
        ]);
    }

    public function showAdminUserProfile($id)
    {

        //access user with authenticated user
        $access_user = Auth::user();

        //this will find the user data with the id
        $users = User::find($id);

        //check if the role is either admin or anything else
        if ($access_user->role == 'admin') {

            //return response()->json(['users' => $users], Response::HTTP_INTERNAL_SERVER_ERROR);
            if (!(isset($users))) {
                return redirect()->route('admin.dashboard');
            }

            return view('users.profile.edit', [
                'user' => $users,
                'access_user' => $access_user,
            ]);
        } else {
            //check if the user is the same as the access user
            if ($access_user->id === $users->id) {
                return view('users.profile.edit', [
                    'user' => $users,
                    'access_user' => $access_user,
                ]);
            } else {
                return redirect()->route('users.profile.index');
            }
        }
    }

    public function AdminScannerValidation($qr_code)
    {
        try {
            $users = User::where('qr_code', $qr_code)->first();

            return response()->json([
                'user' => $users,
                'valid' => true
            ], Response::HTTP_OK);
            
            // return back()->with('success', 'User validated successfully')->with('user', $users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'valid' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return redirect()->route('users.profile.index');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function showUsers()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function showAdminDashboard(RankingController $rankingController)
    {
        $users = Auth::user();

        //dd($users);
        if ($users === null) {
            return back()->with('invalid', 'The user is invalid!');
        }

        $histories = Histories::all();
        $users = User::get();

        $rankingController = new RankingController();
        $ranking = $rankingController->getRankings();


        $history = new HistoryController();
        $totalScan = $history->TotalScan();
        $totalTimeIn = $history->TotalTimeIn();
        $totalTimeOut = $history->TotalTimeOut();
        $totalRegister = $history->TotalRegister();
        $dailyAttendance = $history->AllUserDailyAttendance();
        $recentlyAddedUser = $history->AllMonthlyUsers();

        return view('admin.dashboard', [
            'user' => $users,
            'totalScans' => $totalScan,
            'totalTimeIn' => $totalTimeIn,
            'totalTimeOut' => $totalTimeOut,
            'totalRegister' => $totalRegister,
            'array_daily' => $dailyAttendance,
            'histories' => $histories,
            'ranking' => $ranking,
            'recentlyAddedUser' => $recentlyAddedUser,
        ]);
    }

    public function showUserDashboard(RankingController $rankingController, DtrDownloadRequestController $dtrDownloadRequestController)
    {
        $users = Auth::user();

        if ($users === null) {
            return back()->with('invalid', 'The invalid user!');
        }

        if ($users->role === 'admin') {
            return back()->with('invalid', 'This user does not exists!');
        }

        try {
            //later if not admin
            //convert all the dateitme details
            $histories = $users->history()->latest()->get()->map(function ($history) {
                return [
                    'user' => $history->firstname . ' ' . $history->lastname,
                    'description' => $history->description,
                    'datetime' => Carbon::parse($history->datetime)->format('F j, Y'),
                    'timeFormat' => Carbon::parse($history->datetime)->format('g:i A'),
                ];
            })->toArray();

            $history = new HistoryController();
            $totalScan = $history->UserTotalScan();
            $totalTimeIn = $history->UserTotalTimeIn();
            $totalTimeOut = $history->UserTotalTimeOut();
            $totalRegister = $history->UserTotalRegister();
            $dailyAttendance = $history->AllUserDailyAttendance();

            //ranking controller
            $userRanking = $rankingController->getRankings();

            //get the download request list
            $downloadRequest = $dtrDownloadRequestController->UserdownloadRequestStatusDashboard();

            return view('users.dashboard', [
                'user' => $users,
                'userTimeStarted' => Carbon::parse($users->starting_date)->format('F j, Y'),
                'totalScan' => $totalScan,
                'totalTimeIn' => $totalTimeIn,
                'totalTimeOut' => $totalTimeOut,
                'totalRegister' => $totalRegister,
                'histories' => $histories,
                'array_daily' => $dailyAttendance,
                'downloadRequest' => $downloadRequest,
            ]);
        } catch (\Exception $ex) {
            return back()->with('invalid', 'Invalid user!');
        }
    }

    public function showAdminScanner()
    {
        //$users = User::all();

        //$histories = $users->history()->latest()->get();


    }

    public function showAdminHistory(RankingController $rankingController, HistoryController $historyController)
    {
        $histories = Histories::with('user')->get();
        $users = User::with('history')->get();

        //histories and users
        $records = [];

        foreach ($histories as $history) {
            $user = $users->firstWhere('id', $history->user_id);
            $records[] = [
                'user' => $user,
                'history' => $history,
            ];
        }

        $ranking = $rankingController->getRankings();
        $array_daily = $historyController->AllUserDailyAttendance();

        //dd($records);

        return view('admin.histories', [
            'records' => $records,
            'ranking' => $ranking,
            'array_daily' => $array_daily,
        ]);
    }

    public function showAdminUsers(RankingController $rankingController, HistoryController $historyController)
    {
        $users = User::get();

        $ranking = $rankingController->getRankings();
        $array_daily = $historyController->AllUserDailyAttendance();

        return view('admin.users.index', [
            'users' => $users,
            'ranking' => $ranking,
            'array_daily' => $array_daily,
        ]);

    }

    public function showUserDetails($id, DtrSummaryController $dtrSummaryController)
    {
        $user = User::find($id);

        $histories = $user->history()->latest()->get()->map(function ($history) {
            return [
                'user' => $history->firstname . ' ' . $history->lastname,
                'description' => $history->description,
                'datetime' => Carbon::parse($history->datetime)->format('F j, Y'),
                'timeFormat' => Carbon::parse($history->datetime)->format('g:i A'),
            ];
        })->toArray();

        // //convert $user to request
        // $request = [
        // //convert $user to request
        // $request = [
        //     'id' => $user->id,
        // ];

        // //convert $request to request object
        // $request = new Request($request);

        // //get the yearly totals
        // $yearlyTotals = $dtrSummaryController->showAdminUserDtrSummary($request);

        return view('admin.users.show', [
            'user' => $user,
            'histories' => $histories,
            //'yearlyTotals' => $yearlyTotals,
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        
        if (is_null($user)) {
            return back()->with('invalid', 'The input is invalid please try again!');
        }

        // Exclude user_id from the request data
        $data = $request->except('user_id');

        $user->update($data);
        return back()->with('update', 'Updated Successfully!');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.profile.index');
    }

    public function showDashboard()
    {
        if (Auth::user()->role === 'admin') {
            return $this->showAdminDashboard(new RankingController());
        }
        return $this->showUserDashboard(new RankingController());
    }

    public function showRequest(DtrDownloadRequestController $dtrDownloadRequestController)
    {

        //get the dtr request list
        $downloadRequest = $dtrDownloadRequestController->UserdownloadRequestPage();

        return view('users.request.index', ['downloadRequest' => $downloadRequest]);
    }

    public function showAdminApprovals()
    {
        $dtrDownloadRequest = DtrDownloadRequest::with('users')->get();

        $dtrDownloadRequest = collect($dtrDownloadRequest)->map(function ($user){
            return [
                'id' => $user->id,
                'name' => $user->users->firstname . ' ' . substr($user->users->middlename, 0, 1) . '. ' . $user->users->lastname,
                'title' => 'Request for DTR Approval',
                'month' => $user->month,
                'year' => $user->year,
                'user_id' => $user->user_id,
                'status' => $user->status,
                'date_requested' => Carbon::parse($user->created_at)->format('M d, Y'),
            ];
        })->sortByDesc('date_requested');
        
        return view('admin.approvals.index', [
            'approvals' => $dtrDownloadRequest,
        ]);
    }

    public function showEditUsers($id)
    {
        $user = User::where('id', $id)->first();

        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }


}
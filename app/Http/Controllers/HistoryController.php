<?php

namespace App\Http\Controllers;

use App\Models\Histories;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    //the functions for calculating the total scan, total time in, total time out, total register, 
    //and total hours in the current day from AM to PM
    
    //admin
    public function TotalScan()
    {
        //get the total scan from the database
        $history = Histories::count();
        return $history;
    }

    public function TotalTimeIn()
    {
        $history = Histories::where('description', 'time in')->count();
        return $history;
    }

    public function TotalTimeOut()
    {
        $history = Histories::where('description', 'time out')->count();
        return $history;
    }

    public function TotalRegister()
    {
        $user = User::count();  
        return $user;
    }

    public function TotalHours()
    {
        $history = Histories::all();
        return $history;
    }

    //user

    public function UserTotalScan()
    {
        $user = Auth::user()->history()->count();
        return $user;
    }

    //this function will calculate the total time
    public function UserTotalTimeIn()
    {
        //get the total time in from AM to PM
        $user = Auth::user()->history()->where('description', 'time in')->count();
        return $user;
    }

    //this function will calculate the total time out from AM to PM
    public function UserTotalTimeOut()
    {
        //get the total time out from AM to PM
        $user = Auth::user()->history()->where('description', 'time out')->count();
        return $user;
    }

    //this function will calculate the total register from AM to PM
    public function UserTotalRegister()
    {
        //get the total register from AM to PM
        $user = User::count();
        return $user;
    }

    public function UserTotalHours()
    {
        $user = Auth::user();

        // Get today's date
        $today = Carbon::today();

        // Get the first "time in" for today
        $timeIn = $user->history()
            ->where('description', 'time in')
            ->whereDate('created_at', $today) // Filter for today
            ->orderBy('created_at') // Earliest entry
            ->first();

        // Get the last "time out" for today
        $timeOut = $user->history()
            ->where('description', 'time out')
            ->whereDate('created_at', $today) // Filter for today
            ->orderBy('created_at', 'desc') // Latest entry
            ->first();

        if ($timeIn && $timeOut) {
            $totalHoursWork = $timeIn->created_at->diffInHours($timeOut->created_at);
        } else {
            $totalHoursWork = 0; // Handle missing records
        }

        return $totalHoursWork;
    }

    public function AllUserDailyAttendance()
    {
        try {

            $Today = Carbon::now()->timezone('Asia/Manila')->toDateString(); // Gets today's date (YYYY-MM-DD)

            $DailyAttendance = Histories::whereDate('datetime', $Today)->orderBy('datetime', 'desc')->get()->map(function ($daily){
                return [
                    'id' => $daily->user_id,
                    'name' => User::where('id', $daily->user_id)->first()->firstname .' ' . substr(User::where('id', $daily->user_id)->first()->middlename, 0, 1) . '. ' . User::where('id', $daily->user_id)->first()->lastname,   
                    'description' => $daily->description,
                    'datetime' => Carbon::parse($daily->datetime)->format('F j, Y'),
                    'timeFormat' => Carbon::parse($daily->datetime)->format('g:i A'),
                ];
            })->toArray();

            return $DailyAttendance;
        }
        catch(\Exception $ex)
        {
            return back()->with('invalid', $ex->getMessage());
        }
    }

    public function AllMonthlyUsers()
{
    try {
        $now = Carbon::now()->timezone('Asia/Manila');
        $month = $now->month;
        $year = $now->year;

        $users = User::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'fullname' => $user->firstname . ' ' . substr($user->middlename, 0, 1). '. ' . $user->lastname,
                    'ago' => Carbon::parse($user->created_at)->diffForHumans(),
                ];
            });

        return $users;
    }
    catch(\Exception $ex)
    {
        return back()->with('invalid', $ex->getMessage());
    }
}

}
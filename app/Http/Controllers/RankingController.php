<?php

namespace App\Http\Controllers;

use App\Models\Histories;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RankingController extends Controller
{
    public function getRankings()
    {
        $selectedMonth = request('month', Carbon::now()->month);
        $selectedYear = request('year', Carbon::now()->year);

        $groupedData = [];
        $hours_worked = 0;

        // Retrieve all users
        $users = User::all();

        foreach ($users as $user) {
            //echo "Retrieving logs for user: {$user->firstname}<br>"; // Echo user retrieval

            $userLogs = Histories::where('user_id', $user->id)
                ->whereYear('datetime', $selectedYear)
                ->whereMonth('datetime', $selectedMonth)
                ->orderBy('datetime', 'asc')
                ->get();

            $logsByDate = $userLogs->groupBy(function ($log) {
                return Carbon::parse($log->datetime)->format('Y-m-d');
            });

            $daysInMonth = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->daysInMonth;
            $totalHours = 0;
            $firstname = $user->firstname;

            // Loop through each day in the selected month
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dateKey = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->format('Y-m-d');

                // Check if the day has logs (time in and time out)
                if (isset($logsByDate[$dateKey])) {
                    //echo "Logs found for {$dateKey} - user: {$user->firstname}<br>"; // Echo log existence

                    $logs = $logsByDate[$dateKey];
                    $firstTimeIn = null;
                    $lastTimeOut = null;
                    $dailyHours = 0;

                    // Iterate through the logs for the day
                    foreach ($logs as $log) {
                        // Check for the first "time in" of the day
                        if ($log->description === 'time in' && !$firstTimeIn) {
                            $firstTimeIn = Carbon::parse($log->datetime);
                            //echo "First time in for {$dateKey}: {$firstTimeIn}<br>"; // Echo first time in
                        }

                        // Check for the last "time out" of the day
                        if ($log->description === 'time out') {
                            $lastTimeOut = Carbon::parse($log->datetime);
                            //echo "Last time out for {$dateKey}: {$lastTimeOut}<br>"; // Echo last time out
                        }
                    }

                    // Only calculate if both time in and time out are present
                    if ($firstTimeIn && $lastTimeOut) {
                        $dailyHours = $firstTimeIn->diffInMinutes($lastTimeOut) / 60;
                        //echo "Total hours for {$dateKey}: {$dailyHours} hours<br>"; // Echo daily total
                        $totalHours += $dailyHours;
                    } else {
                        //echo "Skipping {$dateKey} due to missing time in or time out.<br>"; // Echo if missing time
                    }
                } else {
                    //echo "No logs found for {$dateKey} for user {$user->firstname}.<br>"; // Echo no logs found
                }
            }

            // Store the total hours worked for each user
            $groupedData[$user->id] = [
                'schools' => $user->schools,
                'profiles' => $user->profiles,
                'role' => $user->role,
                'name' => $firstname,
                'user_id' => $user->id,
                'hours_worked' => floor($totalHours),
            ];

            //echo "Total hours worked by {$user->firstname}: {$totalHours} hours.<br><br>"; // Echo user total hours
        }

        // Sort the array by hours_worked in descending order and take the top 3
        $topUsers = collect($groupedData)
            ->sortByDesc('hours_worked') // Sort from highest to lowest
            ->take(3) // Get only top 3
            ->values() // Reset array keys
            ->toArray();

        //echo "Top 3 users based on hours worked:<br>";
        foreach ($topUsers as $user) {
            //echo "User: {$user['name']} - Hours Worked: {$user['hours_worked']}<br>"; // Echo top users
        }

        return $topUsers;
    }

}
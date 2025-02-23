<?php

namespace App\Http\Controllers;

use App\Models\DtrDownloadRequest;
use App\Models\File;
use App\Models\Histories;
use App\Models\Profile;
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DtrSummaryController extends Controller
{
    // public function ShowUserDtrSummary(Request $request)
    // {
    //     //check if the requerst is null it was used for year and month passing in the controller
    //     if(is_null($request)){
    //         return null;
    //     }

    //     // Get selected month and year (default to current month/year)
    //     $selectedMonth = request('month', Carbon::now()->month);
    //     $selectedYear = request('year', Carbon::now()->year);

    //     // Fetch logs for the selected month and year
    //     // Fetch logs for the selected month and year
    //     $userLogs = Histories::where('user_id', Auth::user()->id)
    //         ->whereYear('datetime', $selectedYear)
    //         ->whereMonth('datetime', $selectedMonth)
    //         ->orderBy('datetime', 'asc')
    //         ->get();
    //     // $userLogs = Auth::user()->history()
    //     //     ->whereYear('datetime', $request->year)
    //     //     ->whereMonth('datetime', $request->month)
    //     //     ->orderBy('datetime', 'asc')
    //     //     ->get();

    //     // Group logs by both month and day
    //     $logsByDate = $userLogs->groupBy(function ($log) {
    //         return Carbon::parse($log->datetime)->format('Y-m-d'); // Group by full date (YYYY-MM-DD)
    //     });

    //     // Get the total days in the selected month
    //     $daysInMonth = Carbon::createFromDate($request->year, $request->month, 1)->daysInMonth;

    //     //this will be the array
    //     //the content of this array will be the time in, time out, and hours worked
    //     $groupedData = [];

    //     //set the totalhours to 0
    //     //settings the totalhours at default value 0 since it will be used again in the dtr summary page
    //     $totalHours = 0;

    //     // Loop through all days of the selected month
    //     for ($day = 1; $day <= $daysInMonth; $day++) {
    //         $dateKey = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->format('Y-m-d');

    //         if (isset($logsByDate[$dateKey])) {
    //             // Process logs for this day
    //             $logs = $logsByDate[$dateKey];
    //             $firstTimeIn = null;
    //             $lastTimeOut = null;
    //             $dailyHours = 0;

    //             foreach ($logs as $log) {
    //                 if ($log->description === 'time in') {
    //                     $firstTimeIn = Carbon::parse($log->datetime);
    //                 } elseif ($log->description === 'time out' && $firstTimeIn) {
    //                     $lastTimeOut = Carbon::parse($log->datetime);
    //                     $dailyHours += $firstTimeIn->diffInHours($lastTimeOut);
    //                     $firstTimeIn = null;
    //                 }
    //             }

    //             // Store processed data
    //             $groupedData[$dateKey] = [
    //                 'time_in' => $logs->first()->datetime ? Carbon::parse($logs->first()->datetime)->format('h:i A') : '—',
    //                 'time_out' => $logs->last()->datetime ? Carbon::parse($logs->last()->datetime)->format('h:i A') : '—',
    //                 // 'hours_worked' => floor($dailyHours),
    //                 'hours_worked' => floor($logs->first()->datetime ? Carbon::parse($logs->first()->datetime)->diffInHours($logs->last()->datetime) : '—'),
    //             ];
    //             $totalHours += $dailyHours;
    //         } else {
    //             // If no logs exist for this day, store empty values
    //             $groupedData[$dateKey] = [
    //                 'time_in' => '—',
    //                 'time_out' => '—',
    //                 'hours_worked' => '—',
    //             ];
    //         }
    //     }

    //     $totalHoursPerMonth = 0;
    //     foreach ($groupedData as $key => $value) {
    //         if($value['hours_worked'] != '—'){
    //             $totalHoursPerMonth += $value['hours_worked'];
    //         }
    //     }

    //     $totalHoursPerMonth = floor($totalHoursPerMonth);

    //     dd($totalHoursPerMonth);

    //     //passing the grouped data to the dtr summary page 
    //     //this will be use in the later process of the system
    //     return [
    //         'user' => Auth::user(),
    //         'groupedData' => $groupedData,
    //         'totalHoursPerMonth' => $TotalHoursPerMonth,
    //     ];
    // }


    //post function
    public function ShowUserDtrPagination(Request $request)
    {
        
        $currentDate = Carbon::now();
        $selectedMonth = $request->input('month', $currentDate->month);
        $selectedYear = $request->input('year', $currentDate->year);

        if ($request->searchDate) {
            $selectedDate = Carbon::parse($request->searchDate);
            $selectedMonth = $selectedDate->month;
            $selectedYear = $selectedDate->year;
        }

        $selectedDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
        $previousMonth = (clone $selectedDate)->subMonth();
        $nextMonth = (clone $selectedDate)->addMonth();

        // Get all logs for the month
        $userLogs = Histories::where('user_id', Auth::user()->id)
            ->whereYear('datetime', $selectedYear)
            ->whereMonth('datetime', $selectedMonth)
            ->orderBy('datetime', 'asc')
            ->get();

        $logsByDate = $userLogs->groupBy(function ($log) {
            return Carbon::parse($log->datetime)->format('Y-m-d');
        });

        $daysInMonth = Carbon::createFromDate($request->year, $request->month, 1)->daysInMonth;

        $groupedData = [];
        $totalHours = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateKey = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->format('Y-m-d');
            //echo "\nProcessing date: $dateKey\n";

            if (isset($logsByDate[$dateKey])) {
                $logs = $logsByDate[$dateKey];
                //echo "Found " . $logs->count() . " logs for this date\n";

                // Get first time in and last time out for the day
                $timeInLogs = $logs->where('description', 'time in')->sortBy('datetime');
                $timeOutLogs = $logs->where('description', 'time out')->sortByDesc('datetime');

                $firstTimeIn = $timeInLogs->first();
                $lastTimeOut = $timeOutLogs->first(); // This gets the last time out since we sorted desc

                if ($firstTimeIn && $lastTimeOut) {
                    $timeIn = Carbon::parse($firstTimeIn->datetime);
                    $timeOut = Carbon::parse($lastTimeOut->datetime);

                    // Only calculate hours if time out is after time in
                    if ($timeOut->gt($timeIn)) {
                        $hoursWorked = floor($timeIn->diffInHours($timeOut));

                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => $hoursWorked,
                        ];

                        //echo "Valid time in/out found - First In: {$timeIn->format('h:i A')}, Last Out: {$timeOut->format('h:i A')}, Hours: $hoursWorked\n";
                    } else {
                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => '—',
                        ];
                        //echo "Invalid time range - Time out is before time in\n";
                    }
                } else {
                    $groupedData[$dateKey] = [
                        'time_in' => $firstTimeIn ? Carbon::parse($firstTimeIn->datetime)->format('h:i A') : '—',
                        'time_out' => $lastTimeOut ? Carbon::parse($lastTimeOut->datetime)->format('h:i A') : '—',
                        'hours_worked' => '—',
                    ];
                    //echo "Incomplete logs - Missing " . (!$firstTimeIn ? "time in" : "time out") . "\n";
                }
            } else {
                $groupedData[$dateKey] = [
                    'time_in' => '—',
                    'time_out' => '—',
                    'hours_worked' => '—',
                ];
                //echo "No logs found for this date\n";
            }
        }

        $totalHoursPerMonth = 0;
        foreach ($groupedData as $key => $value) {
            if ($value['hours_worked'] !== '—') {
                $totalHoursPerMonth += $value['hours_worked'];
                //echo "Adding hours for $key: {$value['hours_worked']}\n";
            }
        }

        //echo "\nFinal total hours for month: $totalHoursPerMonth\n";

        $records = [];
        foreach ($groupedData as $date => $data) {
            $records[] = [
                'date' => $date,
                'user' => Auth::user(),
                'time_in' => $data['time_in'],
                'time_out' => $data['time_out'],
                'hours_worked' => $data['hours_worked']
            ];
        }

        return redirect()->route('users.dtr', [
            'month' => $selectedMonth,
            'year' => $selectedYear
        ])->with('records', [
                    'user' => Auth::user(),
                    'records' => $groupedData,
                    'totalHoursPerMonth' => $totalHoursPerMonth,
                    'selectedMonth' => $selectedMonth,
                    'selectedYear' => $selectedYear,
                    'pagination' => [
                        'currentMonth' => [
                            'name' => $selectedDate->format('F Y'),
                            'month' => $selectedMonth,
                            'year' => $selectedYear
                        ],
                        'previousMonth' => [
                            'name' => $previousMonth->format('F Y'),
                            'month' => $previousMonth->month,
                            'year' => $previousMonth->year,
                            'url' => route('users.dtr', ['month' => $previousMonth->month, 'year' => $previousMonth->year])
                        ],
                        'nextMonth' => [
                            'name' => $nextMonth->format('F Y'),
                            'month' => $nextMonth->month,
                            'year' => $nextMonth->year,
                            'url' => route('users.dtr', ['month' => $nextMonth->month, 'year' => $nextMonth->year])
                        ]
                    ]
                ]);
    }

    public function showUserDtrSummary()
    {
        $user = Auth::user();
        $firstRecord = Histories::where('user_id', $user->id)
            ->orderBy('datetime', 'asc')
            ->first();
        $lastRecord = Histories::where('user_id', $user->id)
            ->orderBy('datetime', 'desc')
            ->first();

        if (!$firstRecord || !$lastRecord) {
            return view('users.dtr-summary', [
                'yearlyTotals' => []
            ]);
        }

        $startDate = Carbon::parse($firstRecord->datetime)->startOfMonth();
        $endDate = Carbon::parse($lastRecord->datetime)->endOfMonth();
        $yearlyTotals = [];

        while ($startDate->lte($endDate)) {
            $currentYear = $startDate->year;
            $currentMonth = $startDate->format('m');

            // Get all logs for the current month
            $monthLogs = Histories::where('user_id', $user->id)
                ->whereYear('datetime', $currentYear)
                ->whereMonth('datetime', $currentMonth)
                ->orderBy('datetime', 'asc')
                ->get();

            // Group logs by date
            $logsByDate = $monthLogs->groupBy(function ($log) {
                return Carbon::parse($log->datetime)->format('Y-m-d');
            });

            $monthlyHours = 0;

            // Calculate total hours for the month
            foreach ($logsByDate as $dateKey => $logs) {
                $timeInLogs = $logs->where('description', 'time in')->sortBy('datetime');
                $timeOutLogs = $logs->where('description', 'time out')->sortByDesc('datetime');

                $firstTimeIn = $timeInLogs->first();
                $lastTimeOut = $timeOutLogs->first();

                if ($firstTimeIn && $lastTimeOut) {
                    $timeIn = Carbon::parse($firstTimeIn->datetime);
                    $timeOut = Carbon::parse($lastTimeOut->datetime);

                    if ($timeOut->gt($timeIn)) {
                        $hoursWorked = $timeIn->diffInMinutes($timeOut);
                        $monthlyHours += $hoursWorked;
                    }
                }
            }

            // Only add months that have hours
            if ($monthlyHours > 0) {
                if (!isset($yearlyTotals[$currentYear])) {
                    $yearlyTotals[$currentYear] = [
                        'year' => $currentYear,
                        'total_hours' => 0,
                        'months' => []
                    ];
                }

                $yearlyTotals[$currentYear]['months'][$startDate->format('Y-m')] = [
                    'month_name' => $startDate->format('F Y'),
                    'total_hours' => $monthlyHours
                ];

                $yearlyTotals[$currentYear]['total_hours'] += $monthlyHours;
            }

            $startDate->addMonth();
        }

        // Sort years in descending order
        krsort($yearlyTotals);

        // Sort months in descending order within each year
        foreach ($yearlyTotals as &$yearData) {
            krsort($yearData['months']);
        }

        return ['yearlyTotals' => $yearlyTotals];

        // return view('users.dtr-summary', [
        //     'user' => $user,
        //     'yearlyTotals' => $yearlyTotals
        // ]);
    }

    //get function
    public function showUserDtr(Request $request, DtrSummaryController $dtrSummaryController)
    {

        $currentDate = Carbon::now();
        $selectedMonth = $request->input('month', $currentDate->month);
        $selectedYear = $request->input('year', $currentDate->year);

        $selectedDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
        $previousMonth = (clone $selectedDate)->subMonth();
        $nextMonth = (clone $selectedDate)->addMonth();

        // Get all logs for the month
        $userLogs = Histories::where('user_id', Auth::user()->id)
            ->whereYear('datetime', $selectedYear)
            ->whereMonth('datetime', $selectedMonth)
            ->orderBy('datetime', 'asc')
            ->get();

        $logsByDate = $userLogs->groupBy(function ($log) {
            return Carbon::parse($log->datetime)->format('Y-m-d');
        });

        $daysInMonth = Carbon::createFromDate($request->year, $request->month, 1)->daysInMonth;

        $groupedData = [];
        $totalHours = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateKey = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->format('Y-m-d');
            //echo "\nProcessing date: $dateKey\n";

            if (isset($logsByDate[$dateKey])) {
                $logs = $logsByDate[$dateKey];
                //echo "Found " . $logs->count() . " logs for this date\n";

                // Get first time in and last time out for the day
                $timeInLogs = $logs->where('description', 'time in')->sortBy('datetime');
                $timeOutLogs = $logs->where('description', 'time out')->sortByDesc('datetime');

                $firstTimeIn = $timeInLogs->first();
                $lastTimeOut = $timeOutLogs->first(); // This gets the last time out since we sorted desc

                if ($firstTimeIn && $lastTimeOut) {
                    $timeIn = Carbon::parse($firstTimeIn->datetime);
                    $timeOut = Carbon::parse($lastTimeOut->datetime);

                    // Only calculate hours if time out is after time in
                    if ($timeOut->gt($timeIn)) {
                        //$hoursWorked = floor($timeIn->diffInHours($timeOut));
                        $hoursWorked = $timeIn->diffInMinutes($timeOut);

                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => $hoursWorked,
                        ];

                        //echo "Valid time in/out found - First In: {$timeIn->format('h:i A')}, Last Out: {$timeOut->format('h:i A')}, Hours: $hoursWorked\n";
                    } else {
                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => '—',
                        ];
                        //echo "Invalid time range - Time out is before time in\n";
                    }
                } else {
                    $groupedData[$dateKey] = [
                        'time_in' => $firstTimeIn ? Carbon::parse($firstTimeIn->datetime)->format('h:i A') : '—',
                        'time_out' => $lastTimeOut ? Carbon::parse($lastTimeOut->datetime)->format('h:i A') : '—',
                        'hours_worked' => '—',
                    ];
                    //echo "Incomplete logs - Missing " . (!$firstTimeIn ? "time in" : "time out") . "\n";
                }
            } else {
                $groupedData[$dateKey] = [
                    'time_in' => '—',
                    'time_out' => '—',
                    'hours_worked' => '—',
                ];
                //echo "No logs found for this date\n";
            }
        }

        $totalHoursPerMonth = 0;
        foreach ($groupedData as $key => $value) {
            if ($value['hours_worked'] !== '—') {
                $totalHoursPerMonth += $value['hours_worked'];
                //echo "Adding hours for $key: {$value['hours_worked']}\n";
            }
        }

        //echo "\nFinal total hours for month: $totalHoursPerMonth\n";

        $records = [];
        foreach ($groupedData as $date => $data) {
            $records[] = [
                'date' => $date,
                'user' => Auth::user(),
                'time_in' => $data['time_in'],
                'time_out' => $data['time_out'],
                'hours_worked' => $data['hours_worked']
            ];
        }

        //I remove the user becausue its just redundant to Auth::user();
        $yearlyTotals = $dtrSummaryController->showUserDtrSummary()['yearlyTotals'];

        return view('users.dtr', [
            'user' => Auth::user(),
            'yearlyTotals' => $yearlyTotals,
            'records' => $records,
            'totalHoursPerMonth' => $totalHoursPerMonth,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'pagination' => [
                'currentMonth' => [
                    'name' => $selectedDate->format('F Y'),
                    'month' => $selectedMonth,
                    'year' => $selectedYear
                ],
                'previousMonth' => [
                    'name' => $previousMonth->format('F Y'),
                    'month' => $previousMonth->month,
                    'year' => $previousMonth->year,
                    'url' => route('users.dtr', ['month' => $previousMonth->month, 'year' => $previousMonth->year])
                ],
                'nextMonth' => [
                    'name' => $nextMonth->format('F Y'),
                    'month' => $nextMonth->month,
                    'year' => $nextMonth->year,
                    'url' => route('users.dtr', ['month' => $nextMonth->month, 'year' => $nextMonth->year])
                ]
            ]
        ]);
    }

    public function showUserRequestedDtr($id, Request $request, DtrSummaryController $dtrSummaryController)
    {
        $user = optional(DtrDownloadRequest::with('users')->where('id', $id)->first())->users;
        $downloadRequest = DtrDownloadRequest::where('id', $id)->first();
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.users.approvals.view', [
                'id' => $id,
                'type' => 'view',
            ]);
        }
        if(Auth::user()->role != 'admin')
        {
            if(Auth::id() != $user->id)
            {
                return back()->with('invalid', 'You do not have permission to see this!');
            }
        }

        //get the user based on the id sent
        $currentDate = Carbon::now();
        $selectedMonth = $downloadRequest->month ?? $currentDate->format('m'); // Default to current month
        $selectedYear = $downloadRequest->year ?? $currentDate->format('Y'); // Default to current year

        // $selectedMonth = $request->input('month', $currentDate->month);
        // $selectedYear = $request->input('year', $currentDate->year);

        $selectedDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
        $previousMonth = (clone $selectedDate)->subMonth();
        $nextMonth = (clone $selectedDate)->addMonth();

        // Get all logs for the month
        $userLogs = Histories::where('user_id', $user->id)
            ->whereYear('datetime', $selectedYear)
            ->whereMonth('datetime', $selectedMonth)
            ->orderBy('datetime', 'asc')
            ->get();
            
            $logsByDate = $userLogs->groupBy(function ($log) {
            return Carbon::parse($log->datetime)->format('Y-m-d');
        });

        $daysInMonth = Carbon::createFromDate($request->year, $request->month, 1)->daysInMonth;

        $groupedData = [];
        $totalHours = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateKey = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->format('Y-m-d');
            //echo "\nProcessing date: $dateKey\n";
            
            if (isset($logsByDate[$dateKey])) {
                $logs = $logsByDate[$dateKey];
                //echo "Found " . $logs->count() . " logs for this date\n";
                
                // Get first time in and last time out for the day
                $timeInLogs = $logs->where('description', 'time in')->sortBy('datetime');
                $timeOutLogs = $logs->where('description', 'time out')->sortByDesc('datetime');

                $firstTimeIn = $timeInLogs->first();
                $lastTimeOut = $timeOutLogs->first(); // This gets the last time out since we sorted desc

                if ($firstTimeIn && $lastTimeOut) {
                    $timeIn = Carbon::parse($firstTimeIn->datetime);
                    $timeOut = Carbon::parse($lastTimeOut->datetime);
                    
                    // Only calculate hours if time out is after time in
                    if ($timeOut->gt($timeIn)) {
                        $hoursWorked = $timeIn->diffInMinutes($timeOut);

                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => $hoursWorked,
                        ];

                        //echo "Valid time in/out found - First In: {$timeIn->format('h:i A')}, Last Out: {$timeOut->format('h:i A')}, Hours: $hoursWorked\n";
                    } else {
                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => '—',
                        ];
                        //echo "Invalid time range - Time out is before time in\n";
                    }
                } else {
                    $groupedData[$dateKey] = [
                        'time_in' => $firstTimeIn ? Carbon::parse($firstTimeIn->datetime)->format('h:i A') : '—',
                        'time_out' => $lastTimeOut ? Carbon::parse($lastTimeOut->datetime)->format('h:i A') : '—',
                        'hours_worked' => '—',
                    ];
                    //echo "Incomplete logs - Missing " . (!$firstTimeIn ? "time in" : "time out") . "\n";
                }
            } else {
                $groupedData[$dateKey] = [
                    'time_in' => '—',
                    'time_out' => '—',
                    'hours_worked' => '—',
                ];
                //echo "No logs found for this date\n";
            }
        }
        
        $totalHoursPerMonth = 0;
        foreach ($groupedData as $key => $value) {
            if ($value['hours_worked'] !== '—') {
                $totalHoursPerMonth += $value['hours_worked'];
                //echo "Adding hours for $key: {$value['hours_worked']}\n";
            }
        }

        //echo "\nFinal total hours for month: $totalHoursPerMonth\n";

        $records = [];
        foreach ($groupedData as $date => $data) {
            $records[] = [
                'date' => $date,
                'user' => $user,
                'time_in' => $data['time_in'],
                'time_out' => $data['time_out'],
                'hours_worked' => $data['hours_worked']
            ];
        }

        //I remove the user becausue its just redundant to Auth::user();
        $yearlyTotals = $dtrSummaryController->showUserDtrSummary()['yearlyTotals'];
        
        $approved_by_user = null;
        if($downloadRequest->approved_by != null && isset($downloadRequest->approved_by)){
            $approved_by_user = User::with('downloadRequests')->where('id', $downloadRequest->approved_by)->first();
            $approved_by_user = $approved_by_user->firstname . ' ' . substr($approved_by_user->middlename, 0, 1) . '. ' . $approved_by_user->lastname;
        }

        $declined_by_user = null;
        if($downloadRequest->declined_by != null && isset($downloadRequest->declined_by)){
            $declined_by_user = User::with('downloadRequests')->where('id', $downloadRequest->declined_by)->first();
            $declined_by_user = $declined_by_user->firstname . ' ' . substr($declined_by_user->middlename, 0, 1) . '. ' . $declined_by_user->lastname;
        }
        
        if ($request->type === 'download') {
            // Check if the request is approved
            $dtrRequest = DtrDownloadRequest::where('id', $id)->first();
            if (!$dtrRequest || $dtrRequest->status !== 'approved') {
                return back()->with('invalid', 'This document is not yet approved!');
            }
            
            // Pass data to the view, which will submit a POST request
            return view('download-dtr', [
                'user' => $user,
                'declined_by' => $declined_by_user,
                'approved_by' => $approved_by_user,
                'type' => 'verified.download',
                'yearlyTotals' => $yearlyTotals,
                'records' => $records,
                'totalHoursPerMonth' => $totalHoursPerMonth,
                'selectedMonth' => $selectedMonth,
                'selectedYear' => $selectedYear,
                'pagination' => [
                    'currentMonth' => [
                        'name' => $selectedDate->format('F Y'),
                        'month' => $selectedMonth,
                        'year' => $selectedYear
                    ],
                    'previousMonth' => [
                        'name' => $previousMonth->format('F Y'),
                        'month' => $previousMonth->month,
                        'year' => $previousMonth->year,
                        'url' => '',
                    ],
                    'nextMonth' => [
                        'name' => $nextMonth->format('F Y'),
                        'month' => $nextMonth->month,
                        'year' => $nextMonth->year,
                        'url' => '',
                    ]
                ]
            ]);
        }

        return view('users.request.show', [
            'id' => $id,
            'user' => $user,
            'status' => $downloadRequest->status,
            'declined_by' => $declined_by_user,
            'approved_by' => $approved_by_user,
            'yearlyTotals' => $yearlyTotals,
            'records' => $records,
            'totalHoursPerMonth' => $totalHoursPerMonth,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'pagination' => [
                'currentMonth' => [
                    'name' => $selectedDate->format('F Y'),
                    'month' => $selectedMonth,
                    'year' => $selectedYear
                ],
                'previousMonth' => [
                    'name' => $previousMonth->format('F Y'),
                    'month' => $previousMonth->month,
                    'year' => $previousMonth->year,
                    'url' => '',
                ],
                'nextMonth' => [
                    'name' => $nextMonth->format('F Y'),
                    'month' => $nextMonth->month,
                    'year' => $nextMonth->year,
                    'url' => '',
                ]
            ]
        ]);
    }

    public function showAdminUserApprovalDtr($id, Request $request, DtrSummaryController $dtrSummaryController)
    {
        $user = optional(DtrDownloadRequest::with('users')->where('id', $id)->first())->users;
        $downloadRequest = DtrDownloadRequest::where('id', $id)->first();
        if(Auth::user()->role != 'admin')
        {
            if(Auth::id() != $user->id)
            {
                return back()->with('invalid', 'You do not have permission to see this!');
            }
        }

        //get the user based on the id sent
        $currentDate = Carbon::now();
        $selectedMonth = $downloadRequest->month ?? $currentDate->month;
        $selectedYear = $downloadRequest->year ?? $currentDate->year;

        $selectedDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
        $previousMonth = (clone $selectedDate)->subMonth();
        $nextMonth = (clone $selectedDate)->addMonth();

        // Get all logs for the month
        $userLogs = Histories::where('user_id', $user->id)
            ->whereYear('datetime', $selectedYear)
            ->whereMonth('datetime', $selectedMonth)
            ->orderBy('datetime', 'asc')
            ->get();

        $logsByDate = $userLogs->groupBy(function ($log) {
            return Carbon::parse($log->datetime)->format('Y-m-d');
        });

        $daysInMonth = Carbon::createFromDate($request->year, $request->month, 1)->daysInMonth;

        $groupedData = [];
        $totalHours = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateKey = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->format('Y-m-d');
            //echo "\nProcessing date: $dateKey\n";

            if (isset($logsByDate[$dateKey])) {
                $logs = $logsByDate[$dateKey];
                //echo "Found " . $logs->count() . " logs for this date\n";

                // Get first time in and last time out for the day
                $timeInLogs = $logs->where('description', 'time in')->sortBy('datetime');
                $timeOutLogs = $logs->where('description', 'time out')->sortByDesc('datetime');

                $firstTimeIn = $timeInLogs->first();
                $lastTimeOut = $timeOutLogs->first(); // This gets the last time out since we sorted desc

                if ($firstTimeIn && $lastTimeOut) {
                    $timeIn = Carbon::parse($firstTimeIn->datetime);
                    $timeOut = Carbon::parse($lastTimeOut->datetime);

                    // Only calculate hours if time out is after time in
                    if ($timeOut->gt($timeIn)) {
                        $hoursWorked = $timeIn->diffInMinutes($timeOut);

                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => $hoursWorked,
                        ];

                        //echo "Valid time in/out found - First In: {$timeIn->format('h:i A')}, Last Out: {$timeOut->format('h:i A')}, Hours: $hoursWorked\n";
                    } else {
                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => '—',
                        ];
                        //echo "Invalid time range - Time out is before time in\n";
                    }
                } else {
                    $groupedData[$dateKey] = [
                        'time_in' => $firstTimeIn ? Carbon::parse($firstTimeIn->datetime)->format('h:i A') : '—',
                        'time_out' => $lastTimeOut ? Carbon::parse($lastTimeOut->datetime)->format('h:i A') : '—',
                        'hours_worked' => '—',
                    ];
                    //echo "Incomplete logs - Missing " . (!$firstTimeIn ? "time in" : "time out") . "\n";
                }
            } else {
                $groupedData[$dateKey] = [
                    'time_in' => '—',
                    'time_out' => '—',
                    'hours_worked' => '—',
                ];
                //echo "No logs found for this date\n";
            }
        }

        $totalHoursPerMonth = 0;
        foreach ($groupedData as $key => $value) {
            if ($value['hours_worked'] !== '—') {
                $totalHoursPerMonth += $value['hours_worked'];
                //echo "Adding hours for $key: {$value['hours_worked']}\n";
            }
        }

        //echo "\nFinal total hours for month: $totalHoursPerMonth\n";

        $records = [];
        foreach ($groupedData as $date => $data) {
            $records[] = [
                'date' => $date,
                'user' => $user,
                'time_in' => $data['time_in'],
                'time_out' => $data['time_out'],
                'hours_worked' => $data['hours_worked']
            ];
        }

        //I remove the user becausue its just redundant to Auth::user();
        $yearlyTotals = $dtrSummaryController->showUserDtrSummary()['yearlyTotals'];

        return view('admin.approvals.show', [
            'id' => $id,
            'user' => $user,
            'yearlyTotals' => $yearlyTotals,
            'records' => $records,
            'totalHoursPerMonth' => $totalHoursPerMonth,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'pagination' => [
                'currentMonth' => [
                    'name' => $selectedDate->format('F Y'),
                    'month' => $selectedMonth,
                    'year' => $selectedYear
                ],
                'previousMonth' => [
                    'name' => $previousMonth->format('F Y'),
                    'month' => $previousMonth->month,
                    'year' => $previousMonth->year,
                    'url' => '',
                ],
                'nextMonth' => [
                    'name' => $nextMonth->format('F Y'),
                    'month' => $nextMonth->month,
                    'year' => $nextMonth->year,
                    'url' => '',
                ]
            ]
        ]);
    }

    public function showAdminUserDtr(Request $request, $id, RankingController $rankingController, HistoryController $historyController)
    {
        $currentDate = Carbon::now();
        $selectedMonth = $request->input('month', $currentDate->month);
        $selectedYear = $request->input('year', $currentDate->year);

        $selectedDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
        $previousMonth = (clone $selectedDate)->subMonth();
        $nextMonth = (clone $selectedDate)->addMonth();

        // Get all logs for the month
        $userLogs = Histories::where('user_id', $id)
            ->whereYear('datetime', $selectedYear)
            ->whereMonth('datetime', $selectedMonth)
            ->orderBy('datetime', 'asc')
            ->get();

        $logsByDate = $userLogs->groupBy(function ($log) {
            return Carbon::parse($log->datetime)->format('Y-m-d');
        });

        $daysInMonth = Carbon::createFromDate($request->year, $request->month, 1)->daysInMonth;

        $groupedData = [];
        $totalHours = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateKey = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->format('Y-m-d');
            //echo "\nProcessing date: $dateKey\n";

            if (isset($logsByDate[$dateKey])) {
                $logs = $logsByDate[$dateKey];
                //echo "Found " . $logs->count() . " logs for this date\n";

                // Get first time in and last time out for the day
                $timeInLogs = $logs->where('description', 'time in')->sortBy('datetime');
                $timeOutLogs = $logs->where('description', 'time out')->sortByDesc('datetime');

                $firstTimeIn = $timeInLogs->first();
                $lastTimeOut = $timeOutLogs->first(); // This gets the last time out since we sorted desc

                if ($firstTimeIn && $lastTimeOut) {
                    $timeIn = Carbon::parse($firstTimeIn->datetime);
                    $timeOut = Carbon::parse($lastTimeOut->datetime);

                    // Only calculate hours if time out is after time in
                    if ($timeOut->gt($timeIn)) {
                        $hoursWorked = $timeIn->diffInMinutes($timeOut);

                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => $hoursWorked,
                        ];

                        //echo "Valid time in/out found - First In: {$timeIn->format('h:i A')}, Last Out: {$timeOut->format('h:i A')}, Hours: $hoursWorked\n";
                    } else {
                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => '—',
                        ];
                        //echo "Invalid time range - Time out is before time in\n";
                    }
                } else {
                    $groupedData[$dateKey] = [
                        'time_in' => $firstTimeIn ? Carbon::parse($firstTimeIn->datetime)->format('h:i A') : '—',
                        'time_out' => $lastTimeOut ? Carbon::parse($lastTimeOut->datetime)->format('h:i A') : '—',
                        'hours_worked' => '—',
                    ];
                    //echo "Incomplete logs - Missing " . (!$firstTimeIn ? "time in" : "time out") . "\n";
                }
            } else {
                $groupedData[$dateKey] = [
                    'time_in' => '—',
                    'time_out' => '—',
                    'hours_worked' => '—',
                ];
                //echo "No logs found for this date\n";
            }
        }

        $totalHoursPerMonth = 0;
        foreach ($groupedData as $key => $value) {
            if ($value['hours_worked'] !== '—') {
                $totalHoursPerMonth += $value['hours_worked'];
                //echo "Adding hours for $key: {$value['hours_worked']}\n";
            }
        }

        //echo "\nFinal total hours for month: $totalHoursPerMonth\n";

        $records = [];
        foreach ($groupedData as $date => $data) {
            $records[] = [
                'date' => $date,
                'user' => User::find($request->id),
                'time_in' => $data['time_in'],
                'time_out' => $data['time_out'],
                'hours_worked' => $data['hours_worked']
            ];
        }

        return view('admin.users.dtr', [
            'ranking' => $rankingController->getRankings(),
            'array_daily' => $historyController->AllUserDailyAttendance(),
            'user' => User::find($request->id),
            'image_url' => File::where('id',
                School::where('id', 
                    User::where('id', $request->id)->first()->school_id
                )->first()->file_id
            )->first()->path,
            'records' => $records,
            'totalHoursPerMonth' => $totalHoursPerMonth,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'pagination' => [
                'currentMonth' => [
                    'name' => $selectedDate->format('F Y'),
                    'month' => $selectedMonth,
                    'year' => $selectedYear
                ],
                'previousMonth' => [
                    'name' => $previousMonth->format('F Y'),
                    'month' => $previousMonth->month,
                    'year' => $previousMonth->year,
                    'url' => route('users.dtr', ['month' => $previousMonth->month, 'year' => $previousMonth->year])
                ],
                'nextMonth' => [
                    'name' => $nextMonth->format('F Y'),
                    'month' => $nextMonth->month,
                    'year' => $nextMonth->year,
                    'url' => route('users.dtr', ['month' => $nextMonth->month, 'year' => $nextMonth->year])
                ]
            ]
        ]);
    }

    public function ShowAdminUserDtrPagination(Request $request, $id, RankingController $rankingController, HistoryController $historyController)
    {
        $currentDate = Carbon::now();
        $selectedMonth = $request->input('month', $currentDate->month);
        $selectedYear = $request->input('year', $currentDate->year);

        if ($request->searchDate) {
            $selectedDate = Carbon::parse($request->searchDate);
            $selectedMonth = $selectedDate->month;
            $selectedYear = $selectedDate->year;
        }

        $selectedDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
        $previousMonth = (clone $selectedDate)->subMonth();
        $nextMonth = (clone $selectedDate)->addMonth();

        // Get all logs for the month
        $userLogs = Histories::where('user_id', $id)
            ->whereYear('datetime', $selectedYear)
            ->whereMonth('datetime', $selectedMonth)
            ->orderBy('datetime', 'asc')
            ->get();

        $logsByDate = $userLogs->groupBy(function ($log) {
            return Carbon::parse($log->datetime)->format('Y-m-d');
        });

        $daysInMonth = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->daysInMonth;

        $groupedData = [];
        $totalHours = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateKey = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->format('Y-m-d');
            //echo "\nProcessing date: $dateKey\n";

            if (isset($logsByDate[$dateKey])) {
                $logs = $logsByDate[$dateKey];
                //echo "Found " . $logs->count() . " logs for this date\n";

                // Get first time in and last time out for the day
                $timeInLogs = $logs->where('description', 'time in')->sortBy('datetime');
                $timeOutLogs = $logs->where('description', 'time out')->sortByDesc('datetime');

                $firstTimeIn = $timeInLogs->first();
                $lastTimeOut = $timeOutLogs->first(); // This gets the last time out since we sorted desc

                if ($firstTimeIn && $lastTimeOut) {
                    $timeIn = Carbon::parse($firstTimeIn->datetime);
                    $timeOut = Carbon::parse($lastTimeOut->datetime);

                    // Only calculate hours if time out is after time in
                    if ($timeOut->gt($timeIn)) {
                        $hoursWorked = floor($timeIn->diffInHours($timeOut));

                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => $hoursWorked,
                        ];

                        //echo "Valid time in/out found - First In: {$timeIn->format('h:i A')}, Last Out: {$timeOut->format('h:i A')}, Hours: $hoursWorked\n";
                    } else {
                        $groupedData[$dateKey] = [
                            'time_in' => $timeIn->format('h:i A'),
                            'time_out' => $timeOut->format('h:i A'),
                            'hours_worked' => '—',
                        ];
                        //echo "Invalid time range - Time out is before time in\n";
                    }
                } else {
                    $groupedData[$dateKey] = [
                        'time_in' => $firstTimeIn ? Carbon::parse($firstTimeIn->datetime)->format('h:i A') : '—',
                        'time_out' => $lastTimeOut ? Carbon::parse($lastTimeOut->datetime)->format('h:i A') : '—',
                        'hours_worked' => '—',
                    ];
                    //echo "Incomplete logs - Missing " . (!$firstTimeIn ? "time in" : "time out") . "\n";
                }
            } else {
                $groupedData[$dateKey] = [
                    'time_in' => '—',
                    'time_out' => '—',
                    'hours_worked' => '—',
                ];
                //echo "No logs found for this date\n";
            }
        }

        $totalHoursPerMonth = 0;
        foreach ($groupedData as $key => $value) {
            if ($value['hours_worked'] !== '—') {
                $totalHoursPerMonth += $value['hours_worked'];
                //echo "Adding hours for $key: {$value['hours_worked']}\n";
            }
        }

        //echo "\nFinal total hours for month: $totalHoursPerMonth\n";

        $records = [];
        foreach ($groupedData as $date => $data) {
            $records[] = [
                'date' => $date,
                'user' => User::find($id),
                'time_in' => $data['time_in'],
                'time_out' => $data['time_out'],
                'hours_worked' => $data['hours_worked']
            ];
        }

        return view('admin.users.dtr', [
            'user' => User::find($id),
            'ranking' => $rankingController->getRankings(),
            'array_daily' => $historyController->AllUserDailyAttendance(),
            'image_url' => File::where('id',
                School::where('id', 
                    User::where('id', $request->id)->first()->school_id
                )->first()->file_id
            )->first()->path,
            'records' => $records,
            'totalHoursPerMonth' => $totalHoursPerMonth,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'pagination' => [
                'currentMonth' => [
                    'name' => $selectedDate->format('F Y'),
                    'month' => $selectedMonth,
                    'year' => $selectedYear
                ],
                'previousMonth' => [
                    'name' => $previousMonth->format('F Y'),
                    'month' => $previousMonth->month,
                    'year' => $previousMonth->year,
                    'url' => route('users.dtr', ['month' => $previousMonth->month, 'year' => $previousMonth->year])
                ],
                'nextMonth' => [
                    'name' => $nextMonth->format('F Y'),
                    'month' => $nextMonth->month,
                    'year' => $nextMonth->year,
                    'url' => route('users.dtr', ['month' => $nextMonth->month, 'year' => $nextMonth->year])
                ]
            ]
        ]);
    }

    public function showAdminUserDtrSummary(Request $request)
    {
        $user = User::find($request->id);
        $firstRecord = Histories::where('user_id', $user->id)
            ->orderBy('datetime', 'asc')
            ->first();
        $lastRecord = Histories::where('user_id', $user->id)
            ->orderBy('datetime', 'desc')
            ->first();

        if (!$firstRecord || !$lastRecord) {
            return [];
        }

        $startDate = Carbon::parse($firstRecord->datetime)->startOfMonth();
        $endDate = Carbon::parse($lastRecord->datetime)->endOfMonth();
        $yearlyTotals = [];

        while ($startDate->lte($endDate)) {
            $currentYear = $startDate->year;
            $currentMonth = $startDate->format('m');

            // Get all logs for the current month
            $monthLogs = Histories::where('user_id', $user->id)
                ->whereYear('datetime', $currentYear)
                ->whereMonth('datetime', $currentMonth)
                ->orderBy('datetime', 'asc')
                ->get();

            // Group logs by date
            $logsByDate = $monthLogs->groupBy(function ($log) {
                return Carbon::parse($log->datetime)->format('Y-m-d');
            });

            $monthlyHours = 0;

            // Calculate total hours for the month
            foreach ($logsByDate as $dateKey => $logs) {
                $timeInLogs = $logs->where('description', 'time in')->sortBy('datetime');
                $timeOutLogs = $logs->where('description', 'time out')->sortByDesc('datetime');

                $firstTimeIn = $timeInLogs->first();
                $lastTimeOut = $timeOutLogs->first();

                if ($firstTimeIn && $lastTimeOut) {
                    $timeIn = Carbon::parse($firstTimeIn->datetime);
                    $timeOut = Carbon::parse($lastTimeOut->datetime);

                    if ($timeOut->gt($timeIn)) {
                        $hoursWorked = floor($timeIn->diffInHours($timeOut));
                        $monthlyHours += $hoursWorked;
                    }
                }
            }

            // Only add months that have hours
            if ($monthlyHours > 0) {
                if (!isset($yearlyTotals[$currentYear])) {
                    $yearlyTotals[$currentYear] = [
                        'year' => $currentYear,
                        'total_hours' => 0,
                        'months' => []
                    ];
                }

                $yearlyTotals[$currentYear]['months'][$startDate->format('Y-m')] = [
                    'month_name' => $startDate->format('F Y'),
                    'total_hours' => $monthlyHours
                ];

                $yearlyTotals[$currentYear]['total_hours'] += $monthlyHours;
            }

            $startDate->addMonth();
        }

        // Sort years in descending order
        krsort($yearlyTotals);

        // Sort months in descending order within each year
        foreach ($yearlyTotals as &$yearData) {
            krsort($yearData['months']);
        }

        return $yearlyTotals;
    }

    // public function ShowUserDtrSummary(Request $request)
    // {
    //     @dd($request->all());
    //     if(is_null($request)){
    //         return null;
    //     }

    //     $currentDate = Carbon::now();
    //     $selectedMonth = $request->input('month', $currentDate->month);
    //     $selectedYear = $request->input('year', $currentDate->year);

    //     $selectedDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
    //     $previousMonth = (clone $selectedDate)->subMonth();
    //     $nextMonth = (clone $selectedDate)->addMonth();

    //     // Get all logs for the month
    //     $userLogs = Histories::where('user_id', Auth::user()->id)
    //         ->whereYear('datetime', $selectedYear)
    //         ->whereMonth('datetime', $selectedMonth)
    //         ->orderBy('datetime', 'asc')
    //         ->get();

    //     // If no logs exist for the month, return empty data
    //     if ($userLogs->isEmpty()) {
    //         return view('users.dtr', [
    //             'user' => Auth::user(),
    //             'records' => [
    //                 $selectedDate->format('Y-m-d') => [
    //                     'time_in' => '—',
    //                     'time_out' => '—',
    //                     'hours_worked' => '—',
    //                 ]
    //             ],
    //             'totalHoursPerMonth' => 0,
    //             'selectedMonth' => $selectedMonth,
    //             'selectedYear' => $selectedYear,
    //             'pagination' => [
    //                 'currentMonth' => [
    //                     'name' => $selectedDate->format('F Y'),
    //                     'month' => $selectedMonth,
    //                     'year' => $selectedYear
    //                 ],
    //                 'previousMonth' => [
    //                     'name' => $previousMonth->format('F Y'),
    //                     'month' => $previousMonth->month,
    //                     'year' => $previousMonth->year,
    //                     'url' => route('users.dtr', ['month' => $previousMonth->month, 'year' => $previousMonth->year])
    //                 ],
    //                 'nextMonth' => [
    //                     'name' => $nextMonth->format('F Y'),
    //                     'month' => $nextMonth->month,
    //                     'year' => $nextMonth->year,
    //                     'url' => route('users.dtr', ['month' => $nextMonth->month, 'year' => $nextMonth->year])
    //                 ]
    //             ]
    //         ]);
    //     }

    //     $logsByDate = $userLogs->groupBy(function ($log) {
    //         return Carbon::parse($log->datetime)->format('Y-m-d');
    //     });

    //     $daysInMonth = Carbon::createFromDate($request->year, $request->month, 1)->daysInMonth;

    //     $groupedData = [];
    //     $totalHours = 0;

    //     for ($day = 1; $day <= $daysInMonth; $day++) {
    //         $dateKey = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->format('Y-m-d');
    //         echo "\nProcessing date: $dateKey\n";

    //         if (isset($logsByDate[$dateKey])) {
    //             $logs = $logsByDate[$dateKey];
    //             echo "Found " . $logs->count() . " logs for this date\n";

    //             // Get first time in and last time out for the day
    //             $timeInLogs = $logs->where('description', 'time in')->sortBy('datetime');
    //             $timeOutLogs = $logs->where('description', 'time out')->sortByDesc('datetime');

    //             $firstTimeIn = $timeInLogs->first();
    //             $lastTimeOut = $timeOutLogs->first(); // This gets the last time out since we sorted desc

    //             if ($firstTimeIn && $lastTimeOut) {
    //                 $timeIn = Carbon::parse($firstTimeIn->datetime);
    //                 $timeOut = Carbon::parse($lastTimeOut->datetime);

    //                 // Only calculate hours if time out is after time in
    //                 if ($timeOut->gt($timeIn)) {
    //                     $hoursWorked = floor($timeIn->diffInHours($timeOut));

    //                     $groupedData[$dateKey] = [
    //                         'time_in' => $timeIn->format('h:i A'),
    //                         'time_out' => $timeOut->format('h:i A'),
    //                         'hours_worked' => $hoursWorked,
    //                     ];

    //                     echo "Valid time in/out found - First In: {$timeIn->format('h:i A')}, Last Out: {$timeOut->format('h:i A')}, Hours: $hoursWorked\n";
    //                 } else {
    //                     $groupedData[$dateKey] = [
    //                         'time_in' => $timeIn->format('h:i A'),
    //                         'time_out' => $timeOut->format('h:i A'),
    //                         'hours_worked' => '—',
    //                     ];
    //                     echo "Invalid time range - Time out is before time in\n";
    //                 }
    //             } else {
    //                 $groupedData[$dateKey] = [
    //                     'time_in' => $firstTimeIn ? Carbon::parse($firstTimeIn->datetime)->format('h:i A') : '—',
    //                     'time_out' => $lastTimeOut ? Carbon::parse($lastTimeOut->datetime)->format('h:i A') : '—',
    //                     'hours_worked' => '—',
    //                 ];
    //                 echo "Incomplete logs - Missing " . (!$firstTimeIn ? "time in" : "time out") . "\n";
    //             }
    //         } else {
    //             $groupedData[$dateKey] = [
    //                 'time_in' => '—',
    //                 'time_out' => '—',
    //                 'hours_worked' => '—',
    //             ];
    //             echo "No logs found for this date\n";
    //         }
    //     }

    //     $totalHoursPerMonth = 0;
    //     foreach ($groupedData as $key => $value) {
    //         if ($value['hours_worked'] !== '—') {
    //             $totalHoursPerMonth += $value['hours_worked'];
    //             echo "Adding hours for $key: {$value['hours_worked']}\n";
    //         }
    //     }

    //     echo "\nFinal total hours for month: $totalHoursPerMonth\n";

    //     $records = [];
    //     foreach ($groupedData as $date => $data) {
    //         $records[] = [
    //             'date' => $date,
    //             'user' => Auth::user(),
    //             'time_in' => $data['time_in'],
    //             'time_out' => $data['time_out'],
    //             'hours_worked' => $data['hours_worked']
    //         ];
    //     }

    //     return view('users.dtr', [
    //         'user' => Auth::user(),
    //         'records' => $groupedData,
    //         'totalHoursPerMonth' => $totalHoursPerMonth,
    //         'selectedMonth' => $selectedMonth,
    //         'selectedYear' => $selectedYear,
    //         'pagination' => [
    //             'currentMonth' => [
    //                 'name' => $selectedDate->format('F Y'),
    //                 'month' => $selectedMonth,
    //                 'year' => $selectedYear
    //             ],
    //             'previousMonth' => [
    //                 'name' => $previousMonth->format('F Y'),
    //                 'month' => $previousMonth->month,
    //                 'year' => $previousMonth->year,
    //                 'url' => route('users.dtr', ['month' => $previousMonth->month, 'year' => $previousMonth->year])
    //             ],
    //             'nextMonth' => [
    //                 'name' => $nextMonth->format('F Y'),
    //                 'month' => $nextMonth->month,
    //                 'year' => $nextMonth->year,
    //                 'url' => route('users.dtr', ['month' => $nextMonth->month, 'year' => $nextMonth->year])
    //             ]
    //         ]
    //     ]);
    // }

    public function showAdminSingleUserDtr(Request $request)
    {
        // Get first and last records to determine date range
        $firstRecord = Histories::where('user_id', User::find(3)->id)
            ->orderBy('datetime', 'asc')
            ->first();
        $lastRecord = Histories::where('user_id', User::find(3)->id)
            ->orderBy('datetime', 'desc')
            ->first();

        if (!$firstRecord || !$lastRecord) {
            return view('admin.dtr.index', [
                'allMonthsData' => []
            ]);
        }

        $startDate = Carbon::parse($firstRecord->datetime)->startOfMonth();
        $endDate = Carbon::parse($lastRecord->datetime)->endOfMonth();

        // Get all logs between first and last record
        $userLogs = Histories::where('user_id', User::find(3)->id)
            ->whereBetween('datetime', [$startDate, $endDate])
            ->orderBy('datetime', 'asc')
            ->get();

        // Group logs by month
        $allMonthsData = [];

        while ($startDate->lte($endDate)) {
            $currentMonth = $startDate->format('Y-m');
            $daysInMonth = $startDate->daysInMonth;

            $monthLogs = $userLogs->filter(function ($log) use ($startDate) {
                return Carbon::parse($log->datetime)->format('Y-m') === $startDate->format('Y-m');
            });

            $logsByDate = $monthLogs->groupBy(function ($log) {
                return Carbon::parse($log->datetime)->format('Y-m-d');
            });

            $monthData = [];
            $monthlyHours = 0;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dateKey = $startDate->copy()->day($day)->format('Y-m-d');

                if (isset($logsByDate[$dateKey])) {
                    $logs = $logsByDate[$dateKey];
                    $timeInLogs = $logs->where('description', 'time in')->sortBy('datetime');
                    $timeOutLogs = $logs->where('description', 'time out')->sortByDesc('datetime');

                    $firstTimeIn = $timeInLogs->first();
                    $lastTimeOut = $timeOutLogs->first();

                    if ($firstTimeIn && $lastTimeOut) {
                        $timeIn = Carbon::parse($firstTimeIn->datetime);
                        $timeOut = Carbon::parse($lastTimeOut->datetime);

                        if ($timeOut->gt($timeIn)) {
                            $hoursWorked = floor($timeIn->diffInHours($timeOut));
                            $monthlyHours += $hoursWorked;

                            $monthData[$dateKey] = [
                                'time_in' => $timeIn->format('h:i A'),
                                'time_out' => $timeOut->format('h:i A'),
                                'hours_worked' => $hoursWorked,
                            ];
                        } else {
                            $monthData[$dateKey] = [
                                'time_in' => $timeIn->format('h:i A'),
                                'time_out' => $timeOut->format('h:i A'),
                                'hours_worked' => '—',
                            ];
                        }
                    } else {
                        $monthData[$dateKey] = [
                            'time_in' => $firstTimeIn ? Carbon::parse($firstTimeIn->datetime)->format('h:i A') : '—',
                            'time_out' => $lastTimeOut ? Carbon::parse($lastTimeOut->datetime)->format('h:i A') : '—',
                            'hours_worked' => '—',
                        ];
                    }
                } else {
                    $monthData[$dateKey] = [
                        'time_in' => '—',
                        'time_out' => '—',
                        'hours_worked' => '—',
                    ];
                }
            }

            // Only add months that have data
            if (
                !empty(array_filter($monthData, function ($data) {
                    return $data['time_in'] !== '—' || $data['time_out'] !== '—';
                }))
            ) {
                $allMonthsData[$currentMonth] = [
                    'month_name' => $startDate->format('F Y'),
                    'users' => [
                        [
                            'user' => User::find(3),
                            'records' => $monthData,
                            'total_hours' => $monthlyHours
                        ]
                    ]
                ];
            }

            $startDate->addMonth();
        }

        // Sort months in descending order
        krsort($allMonthsData);

        return view('admin.dtr.index', [
            'allMonthsData' => $allMonthsData
        ]);
    }

    public function showAdminAllUserDtr(Request $request)
    {
        // Get all users
        $users = User::all();
        $allUsersData = [];

        foreach ($users as $user) {
            // Get first and last records for each user
            $firstRecord = Histories::where('user_id', $user->id)
                ->orderBy('datetime', 'asc')
                ->first();
            $lastRecord = Histories::where('user_id', $user->id)
                ->orderBy('datetime', 'desc')
                ->first();

            if (!$firstRecord || !$lastRecord) {
                continue; // Skip users with no records
            }

            $startDate = Carbon::parse($firstRecord->datetime)->startOfMonth();
            $endDate = Carbon::parse($lastRecord->datetime)->endOfMonth();

            // Get all logs between first and last record for this user
            $userLogs = Histories::where('user_id', $user->id)
                ->whereBetween('datetime', [$startDate, $endDate])
                ->orderBy('datetime', 'asc')
                ->get();

            // Group logs by month
            $monthlyGroupedData = [];
            $totalHoursOverall = 0;

            while ($startDate->lte($endDate)) {
                $currentMonth = $startDate->format('Y-m');
                $daysInMonth = $startDate->daysInMonth;

                $monthLogs = $userLogs->filter(function ($log) use ($startDate) {
                    return Carbon::parse($log->datetime)->format('Y-m') === $startDate->format('Y-m');
                });

                $logsByDate = $monthLogs->groupBy(function ($log) {
                    return Carbon::parse($log->datetime)->format('Y-m-d');
                });

                $monthData = [];
                $monthlyHours = 0;

                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $dateKey = $startDate->copy()->day($day)->format('Y-m-d');

                    if (isset($logsByDate[$dateKey])) {
                        $logs = $logsByDate[$dateKey];
                        $timeInLogs = $logs->where('description', 'time in')->sortBy('datetime');
                        $timeOutLogs = $logs->where('description', 'time out')->sortByDesc('datetime');

                        $firstTimeIn = $timeInLogs->first();
                        $lastTimeOut = $timeOutLogs->first();

                        if ($firstTimeIn && $lastTimeOut) {
                            $timeIn = Carbon::parse($firstTimeIn->datetime);
                            $timeOut = Carbon::parse($lastTimeOut->datetime);

                            if ($timeOut->gt($timeIn)) {
                                $hoursWorked = floor($timeIn->diffInHours($timeOut));
                                $monthlyHours += $hoursWorked;

                                $monthData[$dateKey] = [
                                    'time_in' => $timeIn->format('h:i A'),
                                    'time_out' => $timeOut->format('h:i A'),
                                    'hours_worked' => $hoursWorked,
                                ];
                            } else {
                                $monthData[$dateKey] = [
                                    'time_in' => $timeIn->format('h:i A'),
                                    'time_out' => $timeOut->format('h:i A'),
                                    'hours_worked' => '—',
                                ];
                            }
                        } else {
                            $monthData[$dateKey] = [
                                'time_in' => $firstTimeIn ? Carbon::parse($firstTimeIn->datetime)->format('h:i A') : '—',
                                'time_out' => $lastTimeOut ? Carbon::parse($lastTimeOut->datetime)->format('h:i A') : '—',
                                'hours_worked' => '—',
                            ];
                        }
                    } else {
                        $monthData[$dateKey] = [
                            'time_in' => '—',
                            'time_out' => '—',
                            'hours_worked' => '—',
                        ];
                    }
                }

                // Only add months that have data
                if (
                    !empty(array_filter($monthData, function ($data) {
                        return $data['time_in'] !== '—' || $data['time_out'] !== '—';
                    }))
                ) {
                    $monthlyGroupedData[$currentMonth] = [
                        'month_name' => $startDate->format('F Y'),
                        'records' => $monthData,
                        'total_hours' => $monthlyHours
                    ];
                    $totalHoursOverall += $monthlyHours;
                }

                $startDate->addMonth();
            }

            // Store user's data if they have any records
            if (!empty($monthlyGroupedData)) {
                $allUsersData[$user->id] = [
                    'user' => $user,
                    'monthlyRecords' => $monthlyGroupedData,
                    'totalHoursOverall' => $totalHoursOverall
                ];
            }
        }

        return view('admin.dtr.index', [
            'allUsersData' => $allUsersData
        ]);
    }

    public function ShowAdminDtrSummary(Request $request)
    {
        //check if the requerst is null it was used for year and month passing in the controller
        if (is_null($request)) {
            return null;
        }

        // Get selected month and year (default to current month/year)
        $selectedMonth = request('month', Carbon::now()->month);
        $selectedYear = request('year', Carbon::now()->year);

        // Fetch logs for the selected month and year
        // Fetch logs for the selected month and year
        $userLogs = Auth::user()->history()
            ->whereYear('datetime', $request->year)
            ->whereMonth('datetime', $request->month)
            ->orderBy('datetime', 'asc')
            ->get();

        // Group logs by both month and day
        $logsByDate = $userLogs->groupBy(function ($log) {
            return Carbon::parse($log->datetime)->format('Y-m-d'); // Group by full date (YYYY-MM-DD)
        });

        // Get the total days in the selected month
        $daysInMonth = Carbon::createFromDate($request->year, $request->month, 1)->daysInMonth;

        //this will be the array
        //the content of this array will be the time in, time out, and hours worked
        $groupedData = [];

        //set the totalhours to 0
        //settings the totalhours at default value 0 since it will be used again in the dtr summary page
        $totalHours = 0;

        // Loop through all days of the selected month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateKey = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->format('Y-m-d');

            if (isset($logsByDate[$dateKey])) {
                // Process logs for this day
                $logs = $logsByDate[$dateKey];
                $firstTimeIn = null;
                $lastTimeOut = null;
                $dailyHours = 0;

                foreach ($logs as $log) {
                    if ($log->description === 'time in') {
                        $firstTimeIn = Carbon::parse($log->datetime);
                    } elseif ($log->description === 'time out' && $firstTimeIn) {
                        $lastTimeOut = Carbon::parse($log->datetime);
                        $dailyHours += $firstTimeIn->diffInHours($lastTimeOut);
                        $firstTimeIn = null;
                    }
                }

                // Store processed data
                $groupedData[$dateKey] = [
                    'time_in' => $logs->first()->datetime ? Carbon::parse($logs->first()->datetime)->format('h:i A') : '—',
                    'time_out' => $logs->last()->datetime ? Carbon::parse($logs->last()->datetime)->format('h:i A') : '—',
                    // 'hours_worked' => floor($dailyHours),
                    'hours_worked' => floor($logs->first()->datetime ? Carbon::parse($logs->first()->datetime)->diffInHours($logs->last()->datetime) : '—'),
                ];
                $totalHours += $dailyHours;
            } else {
                // If no logs exist for this day, store empty values
                $groupedData[$dateKey] = [
                    'time_in' => '—',
                    'time_out' => '—',
                    'hours_worked' => '—',
                ];
            }
        }

        //passing the grouped data to the dtr summary page 
        //this will be use in the later process of the system
        return $groupedData;
    }
}
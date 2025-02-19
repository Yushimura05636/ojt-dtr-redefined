<?php

namespace App\Http\Controllers;

use App\Models\DtrDownloadRequest;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class PDFController extends Controller
{
    public function download(Request $request)
    {
        // Get current month and year
        $month = Carbon::now()->format('F Y');
        
        // Get the number of days in the current month
        $daysInMonth = Carbon::now()->daysInMonth;
        $days = range(1, $daysInMonth);
        
        $user = Auth::user();
        
        $full_name = $user->firstname . ' ' . substr($user->middlename, 0, 1) . '. ' . $user->lastname;
        $hoursThisMonth = str(20) . ' hours';

        $data = [
            'name' => $full_name,
            'position' => 'Intern',
            'hoursThisMonth' => $hoursThisMonth,
            'month' => $month,
            'days' => $days,
        ];
        
        // @dd(json_decode($request->pagination, true)['currentMonth']['name']);

        $pdf = null;

        if($request->type === 'verified.download'){
            $pdf = Pdf::loadView('pdf.dtr', [
                'user' => $user,
                'records' => $request->records,
                'pagination' => $request->pagination,
                'totalHoursPerMonth' => $request->totalHoursPerMonth,
                'approved_by' => $request->approved_by,
            ]);
        }
        else {
            $pdf = Pdf::loadView('pdf.dtr', [
                'user' => $user,
                'records' => $request->records,
                'pagination' => $request->pagination,
                'totalHoursPerMonth' => $request->totalHoursPerMonth,
                'approved_by' => $request->approved_by,
            ]);
        }
        return $pdf->download('DTR_Report.pdf');

        
    }
}
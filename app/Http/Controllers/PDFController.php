<?php

namespace App\Http\Controllers;

use App\Models\DtrDownloadRequest;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

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

        $pdf = null;

        // Get the school and file path
        $user_school = \App\Models\School::where('id', $user->school_id)->first();
        $file_path = optional(\App\Models\File::where('id', optional($user_school)->file_id)->first())->path;

        // Handle external image download and save it as a temporary file
        $externalUrl = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png'; // Example image URL
        $tmpFileName = 'tmp_google_logo.png';
        $storagePath = 'tmp/' . $tmpFileName;

        // Check if the file exists in storage
        if (!Storage::exists($storagePath)) {
            $imageContents = file_get_contents($externalUrl);
            Storage::put($storagePath, $imageContents);
        }

        // Generate a public URL for the temporary file
        $tmpFilePath = storage_path('app/' . $storagePath);

        $pdf = Pdf::loadView('pdf.dtr', [
            'user' => $user,
            'file_path' => $file_path,
            'tmp_file_path' => $tmpFilePath, // Pass temporary file path to the view
            'records' => $request->records,
            'pagination' => $request->pagination,
            'totalHoursPerMonth' => $request->totalHoursPerMonth,
            'approved_by' => $request->approved_by,
        ]);
        
        // Debugging: Check if $pdf is null
        if (!$pdf) {
            abort(500, 'Failed to generate PDF');
        }
        
        return $pdf->download('DTR_Report.pdf');        
    }
}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTR Report</title>
</head>

@php
    $pagination = is_string($pagination) ? json_decode($pagination, true) : $pagination;
    $records = is_string($records) ? json_decode($records, true) : $records;
    // $profile = \App\Models\Profile::where('id', $user->profile_id)->first();
    // $file = \App\Models\File::where('id', $profile->file_id)->first();
    // $fileId = $file->description;
@endphp

<body style="font-family: Arial, sans-serif; margin: 20px; padding: 0;">

    <div style="position: relative; height: 120px; margin-bottom: 50px;">
        <!-- Left Image -->
        <img src="resources/img/rweb_logo.png" 
             alt="RWEB Logo" 
             style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 250px; height: auto;">

        <!-- Right Image -->
        <img src="{{ $file_path }}" 
             alt="Profile Image" 
             onerror="this.onerror=null;this.src='/resources/img/default.png';"
             style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 70px; height: auto;">
    </div>

    <div style="text-align: center; margin: 20px 0;">
        <h4 style="font-weight: bold; color: #F57D11; margin: 0;">OJT Daily Time Record</h4>
        <h1 style="font-size: 24px; margin-top: 5px;">{{ $pagination['currentMonth']['name'] }}</h1>
    </div>

    <hr>

    <p><strong>Name:</strong> {{ $user->firstname }} {{ $user->middlename }} {{ $user->lastname }}</p>
    <p><strong>Position:</strong> Intern</p>
    <div style="position: relative; height: auto; margin-top: -20px;">
        <!-- Left Image -->
        <p><strong>Hours This Month:</strong> {{ floor($totalHoursPerMonth / 60) }} hours {{ $totalHoursPerMonth % 60 }} minutes</p>
        {{-- <img src="resources/img/rweb_logo.png" 
             alt="RWEB Logo" 
             style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 250px; height: auto;"> --}}

        <!-- Right Image -->
        {{-- <img src="{{ $file_path }}" 
             alt="Profile Image" 
             onerror="this.onerror=null;this.src='/resources/img/default.png';"
             style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 70px; height: auto;"> --}}
        @if (!empty($approved_by))
            <p style="position: absolute; right: 0; top: 0; width: auto; margin: 0; text-align: right; text-transform: capitalize;">
                <strong>Approved By:</strong> {{ $approved_by }}
            </p>
        @endif
    </div>
    {{-- <p><strong>Hours This Month:</strong> {{ floor($totalHoursPerMonth / 60) }} hours {{ $totalHoursPerMonth % 60 }} minutes</p>
    @if (!empty($approved_by))
        <p style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 70px; text-align: right; text-transform: uppercase;">
            <strong>Approved By:</strong> {{ strtoupper($approved_by) }}
        </p>
    @endif --}}


    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th style="border: 1px solid #ccc; padding: 10px; text-align: center; background-color: #F57D11; color: white;">Day</th>
                <th style="border: 1px solid #ccc; padding: 10px; text-align: center; background-color: #F57D11; color: white;">Time In</th>
                <th style="border: 1px solid #ccc; padding: 10px; text-align: center; background-color: #F57D11; color: white;">Time Out</th>
                <th style="border: 1px solid #ccc; padding: 10px; text-align: center; background-color: #F57D11; color: white;">Total Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $date => $data)
                <tr>
                    <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">{{ \Carbon\Carbon::parse($data['date'])->format('j') }}</td>
                    <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">{{ $data['time_in'] }}</td>
                    <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">{{ $data['time_out'] }}</td>
                    <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">
                        {{ $data['hours_worked'] == '—' ? '—' : floor($data['hours_worked'] / 60) . ' hours ' . ($data['hours_worked'] % 60) . ' minutes' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTR Report</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- hedvig font --}}
    <link href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Sans&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Hedvig Letters Sans", sans-serif;
        }

        /* Flex utility */
        .flex-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
        }

        .flex-between p,
        .flex-between img {
            display: inline-block;
            /* Makes sure text elements behave properly inside flex */
            margin: 0;
            /* Removes default margin */
            align-items: center;
            justify-content: space-between;
        }

        /* Logo styles */
        .rweb-logo,
        .sti-logo {
            width: auto;
            height: 50px;
            /* Adjust as needed */
        }

        /* Header */
        .header {
            text-align: center;
            margin: 20px 0;
        }

        .header h4 {
            font-weight: bold;
            color: #F57D11;
            margin: 0;
            /* Custom orange */
        }

        .header h1 {
            font-size: 24px;
            margin-top: 5px;
        }

        /* Info Section */
        .info {
            margin: 20px 0;
        }

        .info p {
            margin: 5px 0;
        }

        .capitalize {
            text-transform: capitalize;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #F57D11;
            color: white;
        }

        .flex {
            display: flex;
            flex-direction: row;
            width: max-content;
            margin: 0;
        }

        .flex p,
        .flex img {
            align-items: center;
            display: flex;
            justify-content: space-between;
            width: auto;
            margin: 0;
        }
    </style>
</head>
<body class="hedvig-letters-sans-regular">
    <div style="display: flex; position: absolute; width: 100%; min-height: 100px;">
        <div style="position: absolute; left: 0; top: 0%; transform: translateY(-50%); width: 40%;">
            <img class="rweb-logo" src="resources/img/rweb_logo.png" alt="rweb-logo" style="max-width: 100%; height: auto;">
        </div>
        <div style="position: absolute; right: 0; top: 0%; transform: translateY(-50%); width: 10%;">
            <img class="sti-logo" src="resources/img/school-logo/sti.png" alt="sti-logo" style="max-width: 100%; height: auto;">
        </div>
    </div>

    @php
        $pagination = is_string($pagination) ? json_decode($pagination, true) : $pagination;
        $records = is_string($records) ? json_decode($records, true) : $records;
    @endphp


    <div class="header" style="margin-top: 70px;">
        <h4>OJT Daily Time Record</h4>
        <h1>{{ $pagination['currentMonth']['name'] }}</h1>
    </div>

    <hr>

    <div class="info" style="position: relative;">
        <p class="capitalize"><strong>Name:</strong> {{ $user->firstname }} {{ $user->middlename }} {{ $user->lastname }}</p>
        <p><strong>Position:</strong> Intern</p>
        <div style="position: relative;">
            <p>
                <strong>Hours This Month:</strong> 
                {{ floor((int) filter_var($totalHoursPerMonth, FILTER_SANITIZE_NUMBER_INT) / 60) }} hours 
                {{ round(((int) filter_var($totalHoursPerMonth, FILTER_SANITIZE_NUMBER_INT) % 60)) }} minutes
            </p>
            <p style="position: absolute; right: 0; top: 0;">
                @if (!empty($approved_by))
                    <strong>Approved By:</strong> 
                    <span class="capitalize">{{ $approved_by }}</span>
                @endif


            </p>
        </div>
        
    </div>

    <table>
        <thead>
            <tr>
                <th>Day</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Total Hours</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($records) && count($records) > 0)
                @foreach($records as $date => $data)
                    <tr style="text-align: center; border: 1px solid gray;">
                        <td style="padding: 8px; border: 1px solid gray;">
                            {{ \Carbon\Carbon::parse($data['date'])->format('j') }}
                        </td>
                        <td style="padding: 8px; border: 1px solid gray;">
                            {{ $data['time_in'] }}
                        </td>
                        <td style="padding: 8px; border: 1px solid gray;">
                            {{ $data['time_out'] }}
                        </td>
                        @if($data['hours_worked'] == '—')
                            <td style="padding: 8px; border: 1px solid gray;">—</td>
                        @else
                            @php
                                $totalMinutes = (int) filter_var($data['hours_worked'], FILTER_SANITIZE_NUMBER_INT);
                                $hours = floor($totalMinutes / 60);
                                $minutes = $totalMinutes % 60;
                            @endphp
                            <td style="padding: 8px; border: 1px solid gray;">
                                @if ($hours < 1)
                                    {{ $minutes }} minutes
                                @elseif ($hours == 1)
                                    {{ $hours }} hour {{ $minutes > 0 ? $minutes . ' minutes' : '' }}
                                @else
                                    {{ $hours }} hours {{ $minutes > 0 ? $minutes . ' minutes' : '' }}
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="padding: 8px; border: 1px solid gray; text-align: center;">
                        No records found
                    </td>
                </tr>
            @endif
        </tbody>
        
    </table>
</body>

</html>

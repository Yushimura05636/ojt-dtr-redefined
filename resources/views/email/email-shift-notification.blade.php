{{-- 
This is the email shift notification

Hello [Employee Name],

Your time-in has been successfully recorded.

🕒 Time In: [Timestamp]
📍 Location: [Office/Remote]

If this was not you, please contact HR immediately.

Have a great workday!

[Company Name]
--}}

<p>Hello {{ $user->firstname . ' ' . substr($user->middlename, 0, 1) . '. ' . $user->lastname }}</p>
<p>Your {{ $history->description }} shift has been successfully recorded.</p>
<p>🕒 {{ $history->description}}: {{ $history->datetime->format('F j, Y h:i:s A') }}</p>
<p>If this was not you, please contact HR immediately.</p>
<p>Have a great workday!</p>

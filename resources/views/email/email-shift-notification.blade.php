<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Shift Recorded</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table role="presentation" width="100%"
        style="max-width: 600px; margin: 20px auto; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);">
        <tr>
            <td style="text-align: center;">
                <h1 style="color: #333;">Greetings,
                    <span
                        style="text-transform: capitalize;">{{ strtolower($user->firstname) . ' ' . strtolower(substr($user->middlename, 0, 1)) . '. ' . strtolower($user->lastname) }}</span>!
                </h1>

                <p style="font-size: 16px; color: #555;">Your <strong>{{ $history->description }}</strong> shift has been
                    successfully recorded.</p>

                <div
                    style="background: #f8f8f8; padding: 15px; border-radius: 5px; display: inline-block; margin: 10px 0;">
                    <p style="font-size: 14px; color: #333; margin: 5px 0;">
                        🕒 <strong style="text-transform: capitalize;">{{ $history->description }}:</strong>
                        {{ $history->datetime->format('F j, Y | h:i:s A') }}
                    </p>
                </div>

                <p style="font-size: 14px; color: red; font-weight: bold;">If this was not you, please contact HR
                    immediately.</p>

                <h3 style="color: #28a745; margin-top: 20px;">Have a great day! 😊</h3>

                <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">

                <p style="font-size: 12px; color: #888;">
                    This is an automated email. <strong>Please do not reply.</strong> If you need assistance, contact HR
                    through official channels.
                </p>
            </td>
        </tr>
    </table>
</body>

</html>

{{-- 
    Here will be the email verification page
--}}

{{-- {{$token}}

<h1>Reset Password</h1>
<p>Click the link below to reset your password</p>
<p>This link will expire in 15 minutes</p>
<a href="{{ route('reset-password', ['email' => $email, 'token' => $token]) }}">Reset Password</a> --}}

{{-- {{ $token }} --}}

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table role="presentation" width="100%"
        style="max-width: 600px; margin: 20px auto; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1); text-align: center;">
        <tr>
            <td style="padding: 20px;">
                <h1 style="color: #333; margin-bottom: 10px;">Reset Password</h1>
                <p style="font-size: 16px; color: #555; margin-bottom: 20px;">Click the button below to reset your
                    password.</p>
                <p style="font-size: 14px; color: red; font-weight: bold;">This link will expire in 15 minutes.</p>

                <!-- Reset Password Button -->
                <a href="{{ route('reset-password', ['email' => $email, 'token' => $token]) }}"
                    style="display: inline-block; padding: 12px 20px; margin-top: 10px; font-size: 16px; color: #ffffff; background-color: #007bff; text-decoration: none; border-radius: 5px;">
                    Reset Password
                </a>

                <p style="margin-top: 20px; font-size: 14px; color: #777;">If you did not request this, please ignore
                    this email.</p>

                <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">

                <p style="font-size: 12px; color: #888;">
                    This is an automated email. <strong>Please do not reply.</strong> If you need assistance, contact
                    support.
                </p>
            </td>
        </tr>
    </table>
</body>

</html>

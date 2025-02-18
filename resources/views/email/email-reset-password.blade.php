{{-- 
    Here will be the email verification page
--}}

{{$token}}

<h1>Reset Password</h1>
<p>Click the link below to reset your password</p>
<p>This link will expire in 15 minutes</p>
<a href="{{ route('reset-password', ['email' => $email, 'token' => $token]) }}">Reset Password</a>

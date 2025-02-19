<?php

namespace App\Http\Controllers;

use App\Mail\EmailResetPassword;
use App\Mail\EmailShiftNotification;
use App\Models\Histories;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class EmailController extends Controller
{
    public function index()
    {
        //nothing to send here
    }

    //this function is used for generalization
    public function EmailResetPassword(User $user)
    {
        //get the email from the request
        //auth_reset_password means that the use is resetting their password in their dashboard or in their own account
        //create a request to send the email

        //check if db has the old email and token if not then create a new one
        
        $DBtoken = DB::table('password_reset_tokens')->where('email', $user->email)->first();

        if ($DBtoken) {
            // Check if created_at exists and parse it correctly
            if (!isset($DBtoken->created_at)) {
                return response()->json(['error' => 'created_at column missing or null'], 500);
            }

            // Convert created_at to a Carbon instance
            $createdAt = Carbon::parse($DBtoken->created_at);

            if ($createdAt->addMinutes(15) < Carbon::now()) {
                // Use $user->email instead of $DBtoken->email to delete
                DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            }
        }


        //dd($user->email);
        Mail::to($user->email)->send(new EmailResetPassword($user));

        return response()->json(['message' => 'Email sent successfully', 'valid' => true]);
    }

    public function EmailResetPasswordValidation(Request $request)
    {
        //show the user that the password has been reset
        //dd($request->all());
        
        $error = back();

        if($request->email == null){
            return $error->with(['invalid' =>'Email is required!', 'valid' => false]);
        }

        if($request->_token == null){
            return $error->with(['invalid' =>'Error occured!', 'valid' => false]);
        }

        if($request->password == null){
            return $error->with(['invalid' =>'Password is required!', 'valid' => false]);
        }
        
        if($request->password_confirmation == null){
            return $error->with(['invalid' =>'Password Confirmation is required!', 'valid' => false]);
        }
        
        if($request->password != $request->password_confirmation){
            return $error->with(['invalid' =>'Password does not matched!', 'valid' => false]);
        }

        //get the email from the request
        $email = $request->email;
        $token = $request->token;
        
        //@dd('hello');
        //check if the token is valid
        $DBtoken = DB::table('password_reset_tokens')->where('email', $email)->first();
        if (!$DBtoken) {
            //return $error->with(['invalid' =>'Invalid token!', 'valid' => false]);
            return redirect()->route('show.login')->with(['invalid' => 'Invalid token!', 'valid' => false]);
        }

        // Ensure $token->created_at is a Carbon instance
        if (Carbon::parse($DBtoken->created_at)->addMinutes(15) < Carbon::now()) {
            return redirect()->route('show.login')->with(['invalid' => 'Link is expired!', 'valid' => false]);
        }
        
        if (!$DBtoken || !Hash::check($token, $DBtoken->token)) {
            return redirect()->route('show.login')->with(['invalid' => 'Invalid token!', 'valid' => false]);
        }



        //reset password
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        //delete the token
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect()->route('show.login')->with(['success' =>'Password reset successfully!', 'valid' => true]);
    }

    public function EmailShiftNotification(User $user, Histories $history)
    {
       $emailShiftNotification = Mail::to($user->email)->send(new EmailShiftNotification($user, $history));

        if($emailShiftNotification){
            return response()->json(['message' => 'Shift notification sent successfully', 'valid' => true]);
        }else{
            return response()->json(['message' => 'Shift notification failed', 'valid' => false]);
        }
    }
}

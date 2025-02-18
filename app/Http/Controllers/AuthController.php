<?php

namespace App\Http\Controllers;

use App\Models\Histories;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'student_no' => 'required|string|max:255',

            'emergency_contact_fullname' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:255',
            'emergency_contact_address' => 'required|string|max:255',

            'password' => 'required|string|min:8|confirmed',
        ]);

        //return response()->json(['message' => $request->all()],Response::HTTP_INTERNAL_SERVER_ERROR);

        //dd($data);
        //Generate QR Code
        $qr_code = 'QR' . '_' . Str::random(10) . '_' . Str::random(10);

        //dd($qr_code);
        $user = User::create(
            [
                'firstname' => $data['firstname'],
                'middlename' => $data['middlename'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'address' => $data['address'],
                'school' => $data['school'],
                'student_no' => $data['student_no'],
                'emergency_contact_fullname' => $data['emergency_contact_fullname'],
                'emergency_contact_number' => $data['emergency_contact_number'],
                'emergency_contact_address' => $data['emergency_contact_address'],
                'qr_code' => $qr_code,
                'expiry_date' => Carbon::now()->addMonths(3),
            ]
        );

        return back()->with([
            'success' => 'Congratulations! You are now registered!',
        ]);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request, HistoryController $historyController, UserController $userController)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'type' => 'required|string|in:admin,user', // Ensure type is either 'admin' or 'user'
        ]);

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($data['type'] === 'admin') {
                return $this->adminLogin($request, $user, $userController);
            } else {
                return $this->userLogin($request, $user);
            }
        }

        throw ValidationException::withMessages([
            'invalid' => 'Invalid login credentials.',
        ]);
    }

    private function adminLogin(Request $request, $user, UserController $userController)
    {
        if ($user->role !== 'admin') {
            Auth::logout();
            return back()->with('invalid', 'This user does not exist.');
        }

        $histories = Histories::all();
        $users = User::get();

        $rankingController = new RankingController();
        $ranking = $rankingController->getRankings();


        $history = new HistoryController();
        $totalScan = $history->TotalScan();
        $totalTimeIn = $history->TotalTimeIn();
        $totalTimeOut = $history->TotalTimeOut();
        $totalRegister = $history->TotalRegister();
        $dailyAttendance = $history->AllUserDailyAttendance();
        $recentlyAddedUser = $history->AllMonthlyUsers();

        return redirect()->route('admin.dashboard', [
            'user' => $users,
            'totalScans' => $totalScan,
            'totalTimeIn' => $totalTimeIn,
            'totalTimeOut' => $totalTimeOut,
            'totalRegister' => $totalRegister,
            'array_daily' => $dailyAttendance,
            'histories' => $histories,
            'ranking' => $ranking,
            'recentlyAddedUser' => $recentlyAddedUser,
        ]);
    }

    private function userLogin(Request $request, $user)
    {
        if ($user->expiry_date <= Carbon::now()) {
            $user->status = 'inactive';
            $user->save();
            Auth::logout();
            
            return back()->with('invalid', 'This account does not belong here.');
        }

        $isStarted = !is_null($user->starting_date) && $user->starting_date <= Carbon::now();
        $isExpired = !is_null($user->expiry_date) && $user->expiry_date <= Carbon::now();
        $isActive = $user->status === 'active';

        if ($isStarted && $isActive && !$isExpired) {
            return redirect()->route('users.dashboard');
        }

        Auth::logout();
        // return response()->json(['error' => 'You are not allowed to log in. Please contact the admin for more information'], 403);

        return back()->with('invalid', 'This account is not active yet. Please contact admin for more information.');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($user->role == 'admin') {
            Auth::logout();
            return redirect()->route('show.admin.login');
        } else {
            Auth::logout();
            return redirect()->route('show.login');
        }
    }

    public function showResetPassword()
    {
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request, EmailController $emailController)
    {
        //email verification
        $data = $request->validate([
            'email' => 'required|string|email',
        ]);
        //dd($data);

        //validation here
        $user = User::where('email', $request->email)->first();

        //get the class of the Auth
        $authenticatedUser = Auth::class;

        if (!$user) {
            return back()->with('invalid', 'Email not found');
        }

        if ($authenticatedUser::check()) {
            if ($user->email != $authenticatedUser::user()->email) {
                return back()->with('invalid', 'Email does not matched!');
            }
        }

        //send the reset password link to the email
        $resetPassword = $emailController->EmailResetPassword($user);

        //return the success response
        return back()->with('success', 'We\'ve sent a link to reset your password.');
    }

    public function showAdminUsersCreate()
    {
        return view('admin.users.create');
    }

    public function showAdminUsersCreatePost(Request $request)
    {
        $data = $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'student_no' => 'required|string|max:255',

            'emergency_contact_fullname' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:255',
            'emergency_contact_address' => 'required|string|max:255',

            'password' => 'required|string|min:8|confirmed',
        ]);

        //return response()->json(['message' => $request->all()],Response::HTTP_INTERNAL_SERVER_ERROR);

        //dd($data);
        //Generate QR Code
        $qr_code = 'QR' . '_' . Str::random(10) . '_' . Str::random(10);

        //dd($qr_code);
        $user = User::create(
            [
                'firstname' => $data['firstname'],
                'middlename' => $data['middlename'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'password' => $data['password'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'address' => $data['address'],
                'school' => $data['school'],
                'student_no' => $data['student_no'],
                'emergency_contact_fullname' => $data['emergency_contact_fullname'],
                'emergency_contact_number' => $data['emergency_contact_number'],
                'emergency_contact_address' => $data['emergency_contact_address'],
                'qr_code' => $qr_code,
                'expiry_date' => Carbon::now()->addMonths(3),
            ]
        );

        return back()->with([
            'success' => 'Account Created Successfully!',
        ]);
    }
}
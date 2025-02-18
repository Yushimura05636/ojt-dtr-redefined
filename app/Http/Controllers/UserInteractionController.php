<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInteractionController extends Controller
{
    public function create()
    {
        //role
        return view('users.create');
    }

    //admin interaction button
    //pages
    public function history()
    {
        //view for history
    }

    //this function will be used for generalization either its for user or admin 
    public function dashboard()
    {
        $user = Auth::user();

        if($user->role == 'admin'){
            return redirect()->route('admin.dashboard');
        }
        else{
            return redirect()->route('users.dashboard');
        }
    }
    
    public function scanner()
    {
        $user = Auth::user();

        //check authentication
        if(!Auth::check()){
            return redirect()->route('login');
        }
        //nothing to show here
    }

    //generalization section
    //show profile
    public function profile()
    {
        //role
        $user = Auth::user();

        if($user->role == 'admin'){
            return redirect()->route('admin.dashboard');
        }
        else{
            return redirect()->route('user.dashboard');
        }
    }

    //settings
    public function settings()
    {
        $user = Auth::user();

        if($user->role == 'admin'){
            return redirect()->route('admin.settings', compact($user));
        }
        else{
            return redirect()->route('user.settings', compact($user));
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\NewAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->user_type == "admin" || Auth::user()->user_type == "superadmin") {
            return redirect()->route('admin.home');
        } else if (Auth::user()->user_type == "user") {
            // If user account is new, force to change password
            if (NewAccount::where('user_id', Auth::user()->id)->count() > 0) {
                // return redirect()->route('supplier.change_password');
            }
            return redirect()->route('supplier.published_boms');
        }
        abort(403, 'Unknown User Type');
    }
}

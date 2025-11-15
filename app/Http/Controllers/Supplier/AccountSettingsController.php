<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountSettingsController extends Controller
{
    public function index() {
        return view('supplier.account_settings');
    }
}

<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForceChangePassController extends Controller
{
    public function index() {
        return view('supplier.force_change_pass');
    }
}

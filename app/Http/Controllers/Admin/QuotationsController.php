<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuotationsController extends Controller
{
    public function index() {
        return view('admin.submitted_quotations');
    }
}

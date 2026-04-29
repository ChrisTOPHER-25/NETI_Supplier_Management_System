<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageDepartmentsController extends Controller
{
    public function index() {
        return view('admin.manage_departments');
    }
}

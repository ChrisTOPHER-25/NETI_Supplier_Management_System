<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminManagementController extends Controller
{
    public function DisplayAdminAccounts() {
        return view('admin.admin_accounts');
    }

    public function DisplayDepartments() {
        return view('admin.departments');
    }
}

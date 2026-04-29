<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageCategoriesController extends Controller
{
    public function index() {
        return view('admin.manage_categories');
    }
}

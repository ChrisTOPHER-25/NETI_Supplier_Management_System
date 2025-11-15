<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageBomController extends Controller
{
    public function index(Request $request) {
        return view('admin.manage_bom')->with('bom_id', $request->bom_id);
    }
}

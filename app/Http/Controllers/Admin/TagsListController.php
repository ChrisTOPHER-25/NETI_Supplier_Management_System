<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagsListController extends Controller
{
    public function index() {
        return view('admin.tags_list');
    }
}

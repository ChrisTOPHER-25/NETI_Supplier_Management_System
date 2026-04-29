<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BomMaterial;
use App\Models\Bom;
use Illuminate\Http\Request;

class BomController extends Controller
{
    // public function index()
    // {
    //     return view('admin.boms');
    // }

    public function DisplayHome() {
        return view('admin.home');
    }

    public function DisplayPublishedBoms() {
        return view('admin.published_boms');
    }

    public function DisplayDraftBoms() {
        return view('admin.draft_boms');
    }
}

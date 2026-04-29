<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateQuotationController extends Controller
{
    public function index() {
        return view('supplier.create_quotation');
    }
}

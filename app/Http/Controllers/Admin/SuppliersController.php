<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Exception;

class SuppliersController extends Controller
{
    public function index()
    {
        $suppliers = User::where('user_type', 'user')->get();
        return view('admin.suppliers')->with('suppliers', $suppliers);
    }

    public function AddSupplier(Request $request)
    {
        // TODO: Instead of sending the supplier their password, send password reset link instead
        try {
            $user = $request->validate([
                'supplier_name' => ['required', 'string', 'min:5'],
                'supplier_email' => ['required', 'string', 'unique:users,email'],
                'supplier_password' => ['required', 'min:6', Password::min(6)->letters()->numbers()->mixedCase()],
            ]);
            User::create([
                'name' => $user['supplier_name'],
                'email' => $user['supplier_email'],
                'password' => $user['supplier_password'],
            ]);
            return to_route('admin.suppliers')->with([
                'message' => 'You created a new supplier account: ' . $user['supplier_email'],
                'color' => 'success',
            ]);
        } catch (Exception $ex) {
            return to_route('admin.suppliers')->with([
                'message' => $ex->getMessage(),
                'message_type' => 'addSupplier',
                'color' => 'danger',
            ])->withInput($request->input());
        }
    }

    public function DeleteSupplier(Request $request)
    {
        try {
            $user = User::findOrFail($request->supplier_id);
            if ($user->user_type == 'admin') throw new Exception("Deleting admin accounts is probihited");
            User::destroy($user->id);
            return to_route('admin.suppliers')->with([
                'message' => 'You removed a supplier account',
                'color' => 'warning',
            ]);
        } catch (Exception $ex) {
            return to_route('admin.suppliers')->with([
                'message' => $ex->getMessage(),
                'color' => 'danger',
            ]);
        }
    }

    // Updates the supplier name and email only
    public function UpdateSupplier(Request $request)
    {
        try {
            // Find the supplier that will be changed
            $supplier = User::findOrFail($request->supplier_id);
            $updatedInfo = $request->validate([
                'name' => ['required', 'string', 'min:5'],
                'email' => ['required', 'email', 'unique:users,email,' . $supplier->id],
            ]);
            $supplier->name = $updatedInfo['name'];
            $supplier->email = $updatedInfo['email'];
            $supplier->save();
            return to_route('admin.suppliers')->with([
                'message' => 'You updated a supplier account',
                'color' => 'success',
            ]);
        } catch (Exception $ex) {
            return to_route('admin.suppliers')->with([
                'message' => $ex->getMessage(),
                'message_type' => 'updateSupplier',
                'update_supplier_modal_id' => 'updateSupplier_' . $request->supplier_id,
                'color' => 'danger',
            ]);
        }
    }
}

<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\BomController;
use App\Http\Controllers\Admin\ManageBomController;
use App\Http\Controllers\Admin\ManageCategoriesController;
use App\Http\Controllers\Admin\ManageSupplierTagsController;
use App\Http\Controllers\Admin\QuotationsController;
use App\Http\Controllers\Admin\SuppliersController;
use App\Http\Controllers\Admin\TagsListController;
use App\Http\Controllers\Supplier\AccountSettingsController;
use App\Http\Controllers\Supplier\BomController as SupplierBomController;
use App\Http\Controllers\Supplier\CreateQuotationController;
use App\Http\Controllers\Supplier\DashboardController as SupplierDashboardController;
use App\Http\Controllers\Supplier\ForceChangePassController;
use App\Http\Controllers\Supplier\ItemsController;
use App\Http\Controllers\Supplier\QuotationController;
use App\Http\Controllers\Supplier\ManageDepartmentsController;
use App\Http\Controllers\Supplier\MaterialImageController;
use App\Http\Controllers\Supplier\ProfilePictureController;
use App\Http\Controllers\Supplier\UploadedDocumentsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('guest.login');
    })->name('guest.login');
    Route::get('/login', function () {
        return view('guest.login');
    })->name('login');
    Route::get('/register', function () {
        return view('guest.login');
    })->name('register');
});

Route::group(['middleware' => ['auth']], function () {
    // Admin Routes
    Route::group(['middleware' => ['admin']], function () {
        // Superadmin Routes
        Route::group(['middleware' => ['superadmin']], function () {
            // Admin Accounts
            Route::get('/admin/admin-accounts', [AdminManagementController::class, 'DisplayAdminAccounts'])->name('admin.admin_accounts');
            // Departments
            Route::get('/admin/departments', [AdminManagementController::class, 'DisplayDepartments'])->name('admin.departments');
        });

        // Home
        Route::get('/admin/home', [BomController::class, 'DisplayHome'])->name('admin.home');
        // Draft BOMs
        Route::get('/admin/draft-boms', [BomController::class, 'DisplayDraftBoms'])->name('admin.draft_boms');
        // Published BOMs
        Route::get('/admin/published-boms', [BomController::class, 'DisplayPublishedBoms'])->name('admin.published_boms');
        // Edit BOM
        Route::get('/admin/manage-bom/', [ManageBomController::class, 'index'])->name('admin.manage_bom');
        // Manage Categories
        Route::get('/admin/manage-categories/', [ManageCategoriesController::class, 'index'])->name('admin.manage_categories');
        // Manage Departments
        Route::get('/admin/manage-departments', [ManageDepartmentsController::class, 'index'])->name('admin.manage_departments');
        // Submitted Quotations
        Route::get('/admin/submitted-quotations', [QuotationsController::class, 'index'])->name('admin.submitted_quotations');
        // Submitted Quotation Images
        Route::get('/admin/submitted-quotations/image', [MaterialImageController::class, 'show'])->name('admin.material_image.show');
        // Supplier List
        Route::get('/admin/suppliers', [SuppliersController::class, 'index'])->name('admin.suppliers');
        // Tags List
        Route::get('/admin/tags-list', [TagsListController::class, 'index'])->name('admin.tags_list');
        // Manage Supplier Tags
        Route::get('/admin/manage-supplier-tags', [ManageSupplierTagsController::class, 'index'])->name('admin.manage_supplier_tags');
    });

    // Supplier Routes
    Route::group(['middleware' => ['supplier']], function () {
        Route::get('/supplier/change-password', [ForceChangePassController::class, 'index'])->name('supplier.change_password');
        Route::get('/supplier/dashboard', [SupplierDashboardController::class, 'index'])->name('supplier.dashboard');
        Route::get('/supplier/published-boms', [SupplierBomController::class, 'index'])->name('supplier.published_boms');
        Route::get('/supplier/account-settings', [AccountSettingsController::class, 'index'])->name('supplier.account_settings');
        Route::get('/supplier/create-quotation', [CreateQuotationController::class, 'index'])->name('supplier.create_quotation');
        Route::get('/supplier/images', [ProfilePictureController::class, 'show'])->name('profile_picture.show');
        Route::get('/supplier/quotations/images', [MaterialImageController::class, 'show'])->name('material_image.show');
        Route::get('/supplier/quotation', [QuotationController::class, 'index'])->name('supplier.quotation');
        Route::get('/document/show/{fileName}', [UploadedDocumentsController::class, 'show'])->name('document.show');
        Route::get('/document/download/{fileName}', [UploadedDocumentsController::class, 'download'])->name('document.download');

    });
});

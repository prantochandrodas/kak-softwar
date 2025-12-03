<?php

use App\Http\Controllers\Backend\BankAccountController;
use App\Http\Controllers\Backend\BankBranchController;
use App\Http\Controllers\Backend\BankController;
use App\Http\Controllers\Backend\BranchController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Backend\CustomerInformationController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\DesignationController;
use App\Http\Controllers\Backend\DuePaymentController;
use App\Http\Controllers\Backend\ExpenseHeadController;
use App\Http\Controllers\Backend\ExpenseController;
use App\Http\Controllers\Backend\fundController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductTransferController;
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\SaleController;
use App\Http\Controllers\Backend\SizeController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\UnitController;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('optimize');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');

    return '<!DOCTYPE html>
<html>
<head>
    <title>Cache Cleared</title>
    <meta http-equiv="refresh" content="2;url=/">
</head>
<body style="font-family: Arial; text-align: center; padding: 50px;">
    <h1 style="color: #4CAF50;">✓ Cache cleared successfully!</h1>
    <p>Redirecting to homepage...</p>
</body>
</html>';
});


Route::middleware(['auth:web'])->group(function () {


    Route::get('/', [\App\Http\Controllers\Backend\DashboardController::class, 'index']);
    Route::get('login', [\App\Http\Controllers\Backend\DashboardController::class, 'login'])->name('login');
});

Route::get('/language/{lang}', function ($lang) {
    session(['lang' => $lang]);

    return redirect()->back();
})->name('change.language');
Route::get('assign-branch', [\App\Http\Controllers\Backend\DashboardController::class, 'assign_branch'])->name('admin.branch.assign');
Route::post('assign_branch', [\App\Http\Controllers\Backend\DashboardController::class, 'update_branch'])->name('admin.branch.assign.update');
Route::prefix('admin')->group(function () {

    Route::get('login', [\App\Http\Controllers\Backend\DashboardController::class, 'login'])->name('admin.login');
    Route::post('login', [\App\Http\Controllers\Backend\DashboardController::class, 'doLogin']);

    Route::middleware(['auth:web'])->group(function () {
        Route::get('/', [\App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [\App\Http\Controllers\Backend\DashboardController::class, 'logout'])->name('admin.logout');
        //users
        Route::prefix('employee')->group(function () {
            Route::get('/', [\App\Http\Controllers\Backend\UserController::class, 'index'])->name('admin.user');
            Route::get('data', [\App\Http\Controllers\Backend\UserController::class, 'getData'])->name('admin.user.data');
            Route::get('create', [\App\Http\Controllers\Backend\UserController::class, 'create'])->name('admin.user.create');
            Route::post('create', [\App\Http\Controllers\Backend\UserController::class, 'store']);
            Route::get('edit/{id}', [\App\Http\Controllers\Backend\UserController::class, 'edit'])->name('admin.user.edit');
            Route::post('edit/{id}', [\App\Http\Controllers\Backend\UserController::class, 'update']);
            Route::post('delete', [\App\Http\Controllers\Backend\UserController::class, 'delete'])->name('admin.user.delete');

            Route::get('profile', [\App\Http\Controllers\Backend\UserController::class, 'profile'])->name('admin.user.profile');
            Route::post('profile/{id}', [\App\Http\Controllers\Backend\UserController::class, 'profileUpdate'])->name('profile.update');
        });
        Route::post('/user/toggle-status', [\App\Http\Controllers\Backend\UserController::class, 'toggleStatus'])->name('user.toggleStatus');
        Route::get('profile-edit/{id}', [\App\Http\Controllers\Backend\UserController::class, 'Profile_edit'])->name('admin.user.profile.edit');
        Route::get('get-designation/{id}', [\App\Http\Controllers\Backend\UserController::class, 'getDesignation']);

        //Roles
        Route::prefix('roles')->group(function () {
            Route::get('/', [\App\Http\Controllers\Backend\RoleController::class, 'index'])->name('admin.role');
            Route::get('data', [\App\Http\Controllers\Backend\RoleController::class, 'getData'])->name('admin.role.data');
            Route::get('create', [\App\Http\Controllers\Backend\RoleController::class, 'create'])->name('admin.role.create');
            Route::post('create', [\App\Http\Controllers\Backend\RoleController::class, 'store']);
            Route::get('edit/{id}', [\App\Http\Controllers\Backend\RoleController::class, 'edit'])->name('admin.role.edit');
            Route::post('edit/{id}', [\App\Http\Controllers\Backend\RoleController::class, 'update']);
            Route::get('delete/{id}', [\App\Http\Controllers\Backend\RoleController::class, 'delete'])->name('admin.role.delete');
            Route::get('permissions', [\App\Http\Controllers\Backend\RoleController::class, 'permissions'])->name('admin.role.permissions');
        });

        Route::get('sale-due-payment', [DuePaymentController::class, 'sale_due_payment_form'])->name('sale.due.payment');
        Route::get('/get-sale-invoice/{id}', [DuePaymentController::class, 'getSaleInvoice'])->name('getSaleInvoice');
        Route::get('/get-sale-invoice-due/{id}', [DuePaymentController::class, 'getSaleInvoiceDue'])->name('getSaleInvoiceDue');
        Route::post('/sale-due-payment/store', [DuePaymentController::class, 'saleDuePaymentStore'])->name('sale-due-payment.store');
        Route::get('/get-customer-opening-balance/{id}', [DuePaymentController::class, 'getOpeningBalance']);
        Route::get('get-customer/{id}', [DuePaymentController::class, 'getCustomer']);

        Route::get('branch', [BranchController::class, 'index'])->name('branch.index');
        Route::get('branch/getdata', [BranchController::class, 'getdata'])->name('branch.getdata');
        Route::get('branch/create', [BranchController::class, 'create'])->name('branch.create');
        Route::post('branch/store', [BranchController::class, 'store'])->name('branch.store');
        Route::delete('branch/distroy/{id}', [BranchController::class, 'distroy'])->name('branch.distroy');
        Route::get('branch/edit/{id}', [BranchController::class, 'edit'])->name('branch.edit');
        Route::put('branch/update/{id}', [BranchController::class, 'update'])->name('branch.update');
        Route::post('/branch/toggle-status', [BranchController::class, 'toggleStatus'])->name('branch.toggleStatus');


        Route::get('category', [CategoryController::class, 'index'])->name('category.index');
        Route::get('category/getdata', [CategoryController::class, 'getdata'])->name('category.getdata');
        Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::delete('category/distroy/{id}', [CategoryController::class, 'distroy'])->name('category.distroy');
        Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::post('/category/toggle-status', [CategoryController::class, 'toggleStatus'])->name('category.toggleStatus');

        Route::get('unit', [UnitController::class, 'index'])->name('unit.index');
        Route::get('unit/getdata', [UnitController::class, 'getdata'])->name('unit.getdata');
        Route::get('unit/create', [UnitController::class, 'create'])->name('unit.create');
        Route::post('unit/store', [UnitController::class, 'store'])->name('unit.store');
        Route::delete('unit/distroy/{id}', [UnitController::class, 'distroy'])->name('unit.distroy');
        Route::get('unit/edit/{id}', [UnitController::class, 'edit'])->name('unit.edit');
        Route::put('unit/update/{id}', [UnitController::class, 'update'])->name('unit.update');
        Route::post('/unit/toggle-status', [UnitController::class, 'toggleStatus'])->name('unit.toggleStatus');


        Route::get('brand', [BrandController::class, 'index'])->name('brand.index');
        Route::get('brand/getdata', [BrandController::class, 'getdata'])->name('brand.getdata');
        Route::get('brand/create', [BrandController::class, 'create'])->name('brand.create');
        Route::post('brand/store', [BrandController::class, 'store'])->name('brand.store');
        Route::delete('brand/distroy/{id}', [BrandController::class, 'distroy'])->name('brand.distroy');
        Route::get('brand/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
        Route::put('brand/update/{id}', [BrandController::class, 'update'])->name('brand.update');
        Route::post('/brand/toggle-status', [BrandController::class, 'toggleStatus'])->name('brand.toggleStatus');


        Route::get('size', [SizeController::class, 'index'])->name('size.index');
        Route::get('size/getdata', [SizeController::class, 'getdata'])->name('size.getdata');
        Route::get('size/create', [SizeController::class, 'create'])->name('size.create');
        Route::post('size/store', [SizeController::class, 'store'])->name('size.store');
        Route::delete('size/distroy/{id}', [SizeController::class, 'distroy'])->name('size.distroy');
        Route::get('size/edit/{id}', [SizeController::class, 'edit'])->name('size.edit');
        Route::put('size/update/{id}', [SizeController::class, 'update'])->name('size.update');
        Route::post('/size/toggle-status', [SizeController::class, 'toggleStatus'])->name('size.toggleStatus');





        Route::get('product', [ProductController::class, 'index'])->name('product.index');
        Route::get('product/getdata', [ProductController::class, 'getdata'])->name('product.getdata');
        Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
        Route::delete('product/distroy/{id}', [ProductController::class, 'distroy'])->name('product.distroy');
        Route::get('product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('product/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/product/toggle-status', [ProductController::class, 'toggleStatus'])->name('product.toggleStatus');
        Route::get('product/show/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::get('get-subcategory/{id}', [ProductController::class, 'getSubcategory']);


        Route::get('purchase-form', [PurchaseController::class, 'purchase_form'])->name('purchase.form');
        Route::post('purchase/store', [PurchaseController::class, 'store'])->name('purchase.store');
        Route::get('/get-product-data', [PurchaseController::class, 'getProductData'])->name('getProductData');


        Route::get('purchase', [PurchaseController::class, 'index'])->name('purchase.index');
        Route::get('purchase/getdata', [PurchaseController::class, 'getdata'])->name('purchase.getdata');
        Route::post('purchase/distroy', [PurchaseController::class, 'distroy'])->name('purchase.distroy');
        Route::get('purchase/edit/{id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
        Route::put('purchase/update/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
        Route::post('/purchase/toggle-status', [PurchaseController::class, 'toggleStatus'])->name('purchase.toggleStatus');
        Route::get('purchase/show/{id}', [PurchaseController::class, 'show'])->name('purchase.show');
        Route::get('/purchase-invoice-print/{id}', [PurchaseController::class, 'purchase_invoice_print'])->name('purchase_invoice_print');
        Route::get('/get-supplier-data/{id}', [PurchaseController::class, 'getSupplierData'])->name('getSupplierData');
        Route::get('get-bank/{id}', [PurchaseController::class, 'getBank']);
        Route::get('get-account-by-bank/{id}/{branch_id?}', [PurchaseController::class, 'getAccountByBank']);
        Route::get('/get-supplier/{id}', [PurchaseController::class, 'getSupplier']);

        Route::get('due-payment', [DuePaymentController::class, 'index'])->name('due.payment');
        Route::get('/get-invoice/{id}', [DuePaymentController::class, 'getInvoice'])->name('getInvoice');
        Route::get('/get-invoice-due/{id}', [DuePaymentController::class, 'getInvoiceDue'])->name('getInvoiceDue');
        Route::post('/due-payment/store', [DuePaymentController::class, 'due_payment_store'])->name('due-payment.store');

        Route::match(['get', 'post'], 'purchase-payment-list', [PurchaseController::class, 'purchasePaymentList'])->name('purchase-payment-list');

        Route::get('fund-current-balance', [fundController::class, 'current_balance'])->name('fund.current_balance');
        Route::get('fund-current-balance/getdata', [fundController::class, 'current_balance_getdata'])->name('fund.current_balance.getdata');

        Route::get('fund', [fundController::class, 'index'])->name('fund.index');
        Route::get('fund/getdata', [fundController::class, 'getdata'])->name('fund.getdata');
        Route::get('fund/create', [fundController::class, 'create'])->name('fund.create');
        Route::post('fund/store', [fundController::class, 'store'])->name('fund.store');
        Route::delete('fund/distroy/{id}', [fundController::class, 'distroy'])->name('fund.distroy');
        Route::get('fund/edit/{id}', [fundController::class, 'edit'])->name('fund.edit');
        Route::put('fund/update/{id}', [fundController::class, 'update'])->name('fund.update');
        Route::post('/fund/toggle-status', [fundController::class, 'toggleStatus'])->name('fund.toggleStatus');

        Route::get('expense-head', [ExpenseHeadController::class, 'index'])->name('expense-head.index');
        Route::get('expense-head/getdata', [ExpenseHeadController::class, 'getdata'])->name('expense-head.getdata');
        Route::get('expense-head/create', [ExpenseHeadController::class, 'create'])->name('expense-head.create');
        Route::post('expense-head/store', [ExpenseHeadController::class, 'store'])->name('expense-head.store');
        Route::delete('expense-head/distroy/{id}', [ExpenseHeadController::class, 'distroy'])->name('expense-head.distroy');
        Route::get('expense-head/edit/{id}', [ExpenseHeadController::class, 'edit'])->name('expense-head.edit');
        Route::put('expense-head/update/{id}', [ExpenseHeadController::class, 'update'])->name('expense-head.update');
        Route::post('/expense-head/toggle-status', [ExpenseHeadController::class, 'toggleStatus'])->name('expense-head.toggleStatus');
        Route::get('/get-head/{id}', [ExpenseHeadController::class, 'getHead']);
        Route::get('/print-voucher/{id}', [ExpenseController::class, 'printDebitVoucher'])->name('print-debit-voucher');

        Route::get('expense', [ExpenseController::class, 'index'])->name('expense.index');
        Route::get('expense/getdata', [ExpenseController::class, 'getdata'])->name('expense.getdata');
        Route::get('expense/create', [ExpenseController::class, 'create'])->name('expense.create');
        Route::post('expense/store', [ExpenseController::class, 'store'])->name('expense.store');
        Route::post('expense/distroy', [ExpenseController::class, 'distroy'])->name('expense.distroy');
        Route::get('expense/edit/{id}', [ExpenseController::class, 'edit'])->name('expense.edit');
        Route::put('expense/update/{id}', [ExpenseController::class, 'update'])->name('expense.update');
        Route::post('/expense/toggle-status', [ExpenseController::class, 'toggleStatus'])->name('expense.toggleStatus');
        Route::get('expense/show/{id}', [ExpenseController::class, 'show'])->name('expense.show');

        Route::get('bank', [BankController::class, 'index'])->name('bank.index');
        Route::get('bank/getdata', [BankController::class, 'getdata'])->name('bank.getdata');
        Route::get('bank/create', [BankController::class, 'create'])->name('bank.create');
        Route::post('bank/store', [BankController::class, 'store'])->name('bank.store');
        Route::delete('bank/distroy/{id}', [BankController::class, 'distroy'])->name('bank.distroy');
        Route::get('bank/edit/{id}', [BankController::class, 'edit'])->name('bank.edit');
        Route::put('bank/update/{id}', [BankController::class, 'update'])->name('bank.update');
        Route::post('/bank/toggle-status', [BankController::class, 'toggleStatus'])->name('bank.toggleStatus');

        Route::get('bank-branch', [BankBranchController::class, 'index'])->name('bank-branch.index');
        Route::get('bank-branch/getdata', [BankBranchController::class, 'getdata'])->name('bank-branch.getdata');
        Route::get('bank-branch/create', [BankBranchController::class, 'create'])->name('bank-branch.create');
        Route::post('bank-branch/store', [BankBranchController::class, 'store'])->name('bank-branch.store');
        Route::delete('bank-branch/distroy/{id}', [BankBranchController::class, 'distroy'])->name('bank-branch.distroy');
        Route::get('bank-branch/edit/{id}', [BankBranchController::class, 'edit'])->name('bank-branch.edit');
        Route::put('bank-branch/update/{id}', [BankBranchController::class, 'update'])->name('bank-branch.update');
        Route::post('/bank-branch/toggle-status', [BankBranchController::class, 'toggleStatus'])->name('bank-branch.toggleStatus');


        Route::get('bank-account', [BankAccountController::class, 'index'])->name('bank-account.index');
        Route::get('bank-account/getdata', [BankAccountController::class, 'getdata'])->name('bank-account.getdata');
        Route::get('bank-account/create', [BankAccountController::class, 'create'])->name('bank-account.create');
        Route::post('bank-account/store', [BankAccountController::class, 'store'])->name('bank-account.store');
        Route::delete('bank-account/distroy/{id}', [BankAccountController::class, 'distroy'])->name('bank-account.distroy');
        Route::get('bank-account/edit/{id}', [BankAccountController::class, 'edit'])->name('bank-account.edit');
        Route::put('bank-account/update/{id}', [BankAccountController::class, 'update'])->name('bank-account.update');
        Route::post('/bank-account/toggle-status', [BankAccountController::class, 'toggleStatus'])->name('bank-account.toggleStatus');
        Route::get('bank-account/show/{id}', [BankAccountController::class, 'show'])->name('bank-account.show');
        Route::get('get-branch/{id}', [BankAccountController::class, 'getBranch']);
        Route::get('get-account/{id}', [BankAccountController::class, 'getAccount']);

        Route::get('product-transfer/form', [ProductTransferController::class, 'form'])->name('product.transfer.form');
        Route::post('product-transfer/store', [ProductTransferController::class, 'store'])->name('product.transfer.store');
        Route::get('get-variant/{id}/{branch_id?}', [ProductTransferController::class, 'getProductVariant']);
        Route::get('get-variant-stock/{id}/{productId}/{branch_id?}', [ProductTransferController::class, 'getVariantStock']);
        Route::get('transfer-list', [ProductTransferController::class, 'index'])->name('transfer.list');
        Route::get('transfer-list/getdata', [ProductTransferController::class, 'getdata'])->name('transfer-list.getdata');
        Route::get('transfer-list/show/{id}', [ProductTransferController::class, 'show'])->name('transfer-list.show');
        Route::get('transfer-received-list', [ProductTransferController::class, 'receivedIndex'])->name('transfer.received.list');
        Route::get('transfer-received-list/getdata', [ProductTransferController::class, 'receivedGetdata'])->name('transfer-received-list.getdata');
        Route::post('/transfer/receive/{id}', [ProductTransferController::class, 'receiveTransfer'])
            ->name('transfer.receive');

        // Transfer Return
        Route::post('/transfer/return/{id}', [ProductTransferController::class, 'returnTransfer'])
            ->name('transfer.return');


        Route::get('sale/form', [SaleController::class, 'form'])->name('sale.form');
        Route::get('/customer/check/{branch?}', [SaleController::class, 'checkCustomer'])->name('customer.check');
        Route::get('get-sale-variant/{id}/{branch_id?}', [SaleController::class, 'getProductVariant']);
        Route::post('sale/store', [SaleController::class, 'store'])->name('sale.store');
        Route::get('sale-list', [SaleController::class, 'index'])->name('sale.list');
        Route::get('sale/getdata', [SaleController::class, 'getdata'])->name('sale.getdata');
        Route::post('sale/distroy', [SaleController::class, 'distroy'])->name('sale.distroy');
        Route::get('sale/edit/{id}', [SaleController::class, 'edit'])->name('sale.edit');
        Route::get('sale/show/{id}', [SaleController::class, 'show'])->name('sale.show');
        Route::get('/sale-invoice-print/{id}', [SaleController::class, 'sale_invoice_print'])->name('sale_invoice_print');

        Route::match(['get', 'post'], 'sale-payment-list', [SaleController::class, 'salePaymentList'])->name('sale-payment-list');

        Route::get('customer-information', [CustomerInformationController::class, 'index'])->name('customer-information.index');
        Route::get('customer-information/getdata', [CustomerInformationController::class, 'getdata'])->name('customer-information.getdata');
        Route::get('customer-information/create', [CustomerInformationController::class, 'create'])->name('customer-information.create');
        Route::post('customer-information/store', [CustomerInformationController::class, 'store'])->name('customer-information.store');
        Route::delete('customer-information/distroy/{id}', [CustomerInformationController::class, 'distroy'])->name('customer-information.distroy');
        Route::get('customer-information/edit/{id}', [CustomerInformationController::class, 'edit'])->name('customer-information.edit');
        Route::put('customer-information/update/{id}', [CustomerInformationController::class, 'update'])->name('customer-information.update');
        Route::post('/customer-information/toggle-status', [CustomerInformationController::class, 'toggleStatus'])->name('customer-information.toggleStatus');
        Route::get('customer-information/show/{id}', [CustomerInformationController::class, 'show'])->name('customer-information.show');
        Route::get('customer-due-payment', [CustomerInformationController::class, 'customerDuePayment'])->name('customer.due.payment');

        Route::match(['get', 'post'], 'customer-due-payment-list', [CustomerInformationController::class, 'customerDuePaymentList'])->name('customer-due-payment-list');

        Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('supplier/getdata', [SupplierController::class, 'getdata'])->name('supplier.getdata');
        Route::get('supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::delete('supplier/distroy/{id}', [SupplierController::class, 'distroy'])->name('supplier.distroy');
        Route::get('supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::post('/supplier/toggle-status', [SupplierController::class, 'toggleStatus'])->name('supplier.toggleStatus');
        Route::get('supplier/show/{id}', [SupplierController::class, 'show'])->name('supplier.show');

        Route::get('supplier-due-payment', [SupplierController::class, 'supplier_due_payment'])->name('supplier.due.payment');
        Route::get('/get-supplier-due/{id}', [SupplierController::class, 'getDue']);
        Route::post('/supplier-due-payment/store', [SupplierController::class, 'due_payment_store'])->name('supplier.due-payment.store');
        Route::match(['get', 'post'], 'supplier-due-payment-list', [SupplierController::class, 'supplierDuePaymentList'])->name('supplier-due-payment-list');

        Route::get('color', [ColorController::class, 'index'])->name('color.index');
        Route::get('color/getdata', [ColorController::class, 'getdata'])->name('color.getdata');
        Route::get('color/create', [ColorController::class, 'create'])->name('color.create');
        Route::post('color/store', [ColorController::class, 'store'])->name('color.store');
        Route::delete('color/distroy/{id}', [ColorController::class, 'distroy'])->name('color.distroy');
        Route::get('color/edit/{id}', [ColorController::class, 'edit'])->name('color.edit');
        Route::put('color/update/{id}', [ColorController::class, 'update'])->name('color.update');
        Route::post('/color/toggle-status', [ColorController::class, 'toggleStatus'])->name('color.toggleStatus');


        Route::get('sub-category', [SubCategoryController::class, 'index'])->name('sub-category.index');
        Route::get('sub-category/getdata', [SubCategoryController::class, 'getdata'])->name('sub-category.getdata');
        Route::get('sub-category/create', [SubCategoryController::class, 'create'])->name('sub-category.create');
        Route::post('sub-category/store', [SubCategoryController::class, 'store'])->name('sub-category.store');
        Route::delete('sub-category/distroy/{id}', [SubCategoryController::class, 'distroy'])->name('sub-category.distroy');
        Route::get('sub-category/edit/{id}', [SubCategoryController::class, 'edit'])->name('sub-category.edit');
        Route::put('sub-category/update/{id}', [SubCategoryController::class, 'update'])->name('sub-category.update');
        Route::post('/sub-category/toggle-status', [SubCategoryController::class, 'toggleStatus'])->name('sub-category.toggleStatus');

        //settings
        Route::prefix('settings')->group(function () {
            Route::get('general', [\App\Http\Controllers\Backend\SettingController::class, 'generalSetting'])->name('admin.setting.general');
            Route::post('general', [\App\Http\Controllers\Backend\SettingController::class, 'generalSettingUpdate']);
            Route::get('slider', [\App\Http\Controllers\Backend\SettingController::class, 'slider'])->name('admin.setting.slider');
            Route::post('slider', [\App\Http\Controllers\Backend\SettingController::class, 'sliderUpdate']);
        });
    });
});

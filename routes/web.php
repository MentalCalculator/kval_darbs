<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
Auth::routes();
// Registered Verification
Route::middleware(['auth'])->group(function() {
// Entrance Route When You Login/Register
Route::get('/', function () {
    $user_id = Auth::id();
    $purchases = DB::table('purchases')
        ->select('id','created_at')
        ->where('userid', '=', $user_id)
        ->get();

    $data = [];
    $totalSums = [];
    foreach ($purchases as $p) {
        $purchase_id = $p->id;
        $products = DB::table('products')
            ->select('id', 'purchaseid', 'productname', 'productprice', 'productamount', 'producttype', 'total', 'created_at')
            ->where('userid', '=', $user_id)
            ->where('purchaseid', '=', $purchase_id)
            ->get();

        $totalSum = $products->sum('total');
        $totalSum = number_format($totalSum, 2);
        foreach ($products as $product) {
            if (round($product->productamount) == $product->productamount) {
                $product->productamount = number_format($product->productamount);
            } else {
                $product->productamount = number_format($product->productamount, 3);
            }
        }
        $data[$purchase_id] = $products;
        $totalSums[$purchase_id] = $totalSum;
    }

    return view('Home', compact('data', 'purchases', 'totalSums'));
    })->name('Purchases');
// Page Routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products',[App\Http\Controllers\HomeController::class, 'products'])->name('products');
Route::get('/total', [App\Http\Controllers\HomeController::class, 'total'])->name('total');
Route::get('/settings', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
// Edit, Add and Delete Routes
Route::post('/CreatePurchase', [App\Http\Controllers\PurchaseCreateController::class, 'purchasecreate'])->name('purchasecreate');
Route::delete('/purchase/remove/{id}', [App\Http\Controllers\ModifyController::class, 'removepurchase'])->name('removepurchase');
Route::delete('/product/remove/{id}', [App\Http\Controllers\ModifyController::class, 'removeproduct'])->name('removeproduct');
Route::put('/product/update/{id}', [App\Http\Controllers\ModifyController::class, 'productupdate'])->name('productupdate');
Route::post('/ProfileU',[App\Http\Controllers\ProfileEditController::class, 'userchange'])->name('namechange');
Route::post('/ProfileE',[App\Http\Controllers\ProfileEditController::class, 'emailchange'])->name('emailchange');
Route::post('/ProfileP',[App\Http\Controllers\ProfileEditController::class, 'passwordchange'])->name('passwordchange');
// Search and Date Routes
Route::get('/PurchaseS', [App\Http\Controllers\SearchController::class, 'purchasessearch'])->name('purchasessearch');
Route::get('/ProductsS', [App\Http\Controllers\SearchController::class, 'productssearch'])->name('productssearch');
Route::get('/PurchaseD', [App\Http\Controllers\DateController::class, 'purchasesdate'])->name('purchasesdate');
Route::get('/ProductsD', [App\Http\Controllers\DateController::class, 'productsdate'])->name('productsdate');
Route::get('/TotalD', [App\Http\Controllers\DateController::class, 'totalcountdate'])->name('totaldate');
});
// Admin User Confirmation
Route::middleware('admin')->group(function() {
// Admin Page Routes
Route::get('/admin/purchases', [App\Http\Controllers\AdminController::class, 'purchasedashboard'])->name('adminpurchases');
Route::get('/admin/products', [App\Http\Controllers\AdminController::class, 'productdashboard'])->name('adminproducts');
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'userdashboard'])->name('adminusers');
// Admin Edit, Add and Delete Routes
Route::put('/admin/user/update/{id}', [App\Http\Controllers\AdminModifyController::class, 'adminmodifyuser'])->name('adminuserupdate');
Route::put('/admin/product/update/{id}', [App\Http\Controllers\AdminModifyController::class, 'adminproductupdate'])->name('adminproductupdate');
Route::delete('/admin/product/remove/{id}', [App\Http\Controllers\AdminModifyController::class, 'adminremoveproduct'])->name('adminremoveproduct');
Route::delete('/admin/purchase/remove/{id}', [App\Http\Controllers\AdminModifyController::class, 'adminremovepurchase'])->name('adminremovepurchase');
Route::delete('/admin/user/remove/{id}', [App\Http\Controllers\AdminModifyController::class, 'adminremoveuser'])->name('adminremoveuser');
// Admin Search and Date Routes
Route::get('/AdminPurchaseSearchI', [App\Http\Controllers\AdminSearchController::class, 'adminpurchasesearchid'])->name('adminpurchasesearchid');
Route::get('/AdminPurchaseSearchU', [App\Http\Controllers\AdminSearchController::class, 'adminpurchasesearchuserid'])->name('adminpurchasesearchuserid');
Route::get('/AdminProductsSearchN', [App\Http\Controllers\AdminSearchController::class, 'adminproductssearchname'])->name('adminproductssearchname');
Route::get('/AdminProductsSearchU', [App\Http\Controllers\AdminSearchController::class, 'adminproductssearchuserid'])->name('adminproductssearchuserid');
Route::get('/AdminUserSearchI', [App\Http\Controllers\AdminSearchController::class, 'adminusersearchID'])->name('adminusersearchid');
Route::get('/AdminUserSearchN', [App\Http\Controllers\AdminSearchController::class, 'adminusersearchname'])->name('adminusersearchname');
Route::get('/AdminPurchaseDate', [App\Http\Controllers\AdminDateController::class, 'adminpurchasesdate'])->name('adminpurchasesdate');
Route::get('/AdminProductsDate', [App\Http\Controllers\AdminDateController::class, 'adminproductsdate'])->name('adminproductsdate');
Route::get('/AdminUserDate', [App\Http\Controllers\AdminDateController::class, 'adminuserdate'])->name('adminuserdate');
});

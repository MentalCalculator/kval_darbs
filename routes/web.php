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

// Entrance Route
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $user_id = Auth::id();
        $purchases = DB::table('purchases')
            ->select('id','created_at')
            ->where('userid', '=', $user_id)
            ->get();

        $data = [];
        foreach ($purchases as $p) {
            $purchase_id = $p->id;
            $products = DB::table('products')
                ->select('id', 'purchaseid', 'productname', 'productprice', 'productamount', 'producttype', 'total', 'created_at')
                ->where('userid', '=', $user_id)
                ->where('purchaseid', '=', $purchase_id)
                ->get();
            foreach ($products as $product) {
                if (round($product->productamount) == $product->productamount) {
                    $product->productamount = number_format($product->productamount);
                } else {
                    $product->productamount = number_format($product->productamount, 3);
                }
            }
            $data[$purchase_id] = $products;
        }
        return view('Home', compact('data','purchases'));
    })->name('Purchases');

// Page Routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/Produkti',[App\Http\Controllers\HomeController::class, 'products'])->name('productsinfo');
Route::get('/total', [App\Http\Controllers\HomeController::class, 'total'])->name('total');
Route::get('/Settings', [App\Http\Controllers\HomeController::class, 'profile'])->name('profils');

// Edit, Add, Delete Routes
Route::post('/CreatePurchase', [App\Http\Controllers\PurchaseCreateController::class, 'purchasecreate'])->name('purchasecreate');
Route::delete('/Remove{id}', [App\Http\Controllers\RemoveController::class, 'removeData'])->name('remove');
Route::put('/Update{id}',  [App\Http\Controllers\ModifyController::class, 'update'])->name('productsupdate');
Route::post('/ProfileU',[App\Http\Controllers\ProfileEditController::class, 'userchange'])->name('userchange');
Route::post('/ProfileE',[App\Http\Controllers\ProfileEditController::class, 'emailchange'])->name('emailchange');
Route::post('/ProfileP',[App\Http\Controllers\ProfileEditController::class, 'passwordchange'])->name('passwordchange');

// Search Routes
Route::get('/PurchaseS', [App\Http\Controllers\SearchController::class, 'purchasessearch'])->name('purchasessearch');
Route::get('/ProductsS', [App\Http\Controllers\SearchController::class, 'productssearch'])->name('productssearch');
Route::get('/PurchaseD', [App\Http\Controllers\DateController::class, 'purchasesdate'])->name('purchasesdate');
Route::get('/ProductsD', [App\Http\Controllers\DateController::class, 'productsdate'])->name('productsdate');
Route::get('/TotalD', [App\Http\Controllers\DateController::class, 'totalcountdate'])->name('totaldate');
});


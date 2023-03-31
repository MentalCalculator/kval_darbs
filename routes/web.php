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

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $user_id = Auth::id();
        $pirkumi = DB::table('pirkumi')
            ->select('id','created_at')
            ->where('userid', '=', $user_id)
            ->get();

        $data = [];
        foreach ($pirkumi as $p) {
            $pirkums_id = $p->id;
            $products = DB::table('produkti')
                ->select('id','pirkumsid', 'nosaukums', 'cena', 'sveramais', 'sveramaistype', 'total', 'created_at')
                ->where('userid', '=', $user_id)
                ->where('pirkumsid', '=', $pirkums_id)
                ->get();
            foreach ($products as $product) {
                if (round($product->sveramais) == $product->sveramais) {
                    $product->sveramais = number_format($product->sveramais);
                } else {
                    $product->sveramais = number_format($product->sveramais, 3);
                }
            }
            $data[$pirkums_id] = $products;
        }
        return view('Home', compact('data','pirkumi'));
    })->name('Pirkumi');
// Page Routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/Produkti',[App\Http\Controllers\ProductsController::class, 'products'])->name('productsinfo');
Route::get('/total', [App\Http\Controllers\HomeController::class, 'total'])->name('total');
Route::get('/Profils', [App\Http\Controllers\HomeController::class, 'profile'])->name('profils');

// Edit, Add, Delete Routes
Route::post('/Pirkumi', [App\Http\Controllers\PirkumiCreateController::class, 'purchasecreate'])->name('purchasecreate');
Route::delete('Remove', [App\Http\Controllers\RemoveController::class, 'removeData'])->name('remove');
Route::put('Update',  [App\Http\Controllers\ModifyController::class, 'update'])->name('productsupdate');
Route::post('/ProfileU',[App\Http\Controllers\ProfileEditController::class, 'userchange'])->name('userchange');
Route::post('/ProfileE',[App\Http\Controllers\ProfileEditController::class, 'emailchange'])->name('emailchange');
Route::post('/ProfileP',[App\Http\Controllers\ProfileEditController::class, 'passwordchange'])->name('passwordchange');

// Search Routes
Route::get('/PurchaseS', [App\Http\Controllers\SearchController::class, 'index'])->name('purchasessearch');
Route::get('/ProductsS', [App\Http\Controllers\ProductsSearchController::class, 'productssearch'])->name('productssearch');
Route::get('/ProductsD', [App\Http\Controllers\ProductDateController::class, 'productsdate'])->name('productsdate');
Route::get('/TotalD', [App\Http\Controllers\TotalDateController::class, 'totalcountdate'])->name('totaldate');
});


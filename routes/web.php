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
                ->select('id','pirkumsid', 'nosaukums', 'cena', 'sveramais', 'total', 'created_at')
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
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/Produkti',[App\Http\Controllers\ProductsController::class, 'products'])->name('productsinfo');
Route::get('/Pirkumi', [App\Http\Controllers\HomeController::class, 'pirkumi'])->name('pirkumi');
Route::post('/Pirkumi', [App\Http\Controllers\PirkumiController::class, 'pirkums'])->name('pirkums');
Route::get('/Pirkumi', [App\Http\Controllers\PirkumiShowController::class, 'products'])->name('pirkumi');
Route::delete('/remove/{id}', [App\Http\Controllers\RemoveController::class, 'removeData'])->name('remove');
Route::put('/products/{id}',  [App\Http\Controllers\ModifyController::class, 'update'])->name('products.update');
Route::post('/Profils',[App\Http\Controllers\ProfileEditController::class, 'userchange'])->name('userchange');
Route::post('/Profild',[App\Http\Controllers\ProfileEditController::class, 'emailchange'])->name('emailchange');
Route::post('/Profil',[App\Http\Controllers\ProfileEditController::class, 'passwordchange'])->name('passwordchange');
Route::get('/Kopsavilkums', [App\Http\Controllers\TotalController::class, 'totalcount'])->name('totalcount');
Route::get('/Profils', [App\Http\Controllers\HomeController::class, 'profile'])->name('profils');
});


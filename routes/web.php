<?php

//Controller場所を示すuse宣言が必要
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
//↑↑Auth部品を使うために取り込みが必要、ユーザー認証(ログイン)に関する処理を行う

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/

//get=ページを表示
Route::get('/', function () {
    //ウェブサイトのホームページ('/'のURL)にアクセスした場合

    if (Auth::check()) {
        //ログイン状態ならば、商品一覧ページへ
        //該当のindexメゾットがあるController名の複数形にて記載する
        return redirect()->route('products.index');

        //ログイン状態でなければ、ログイン画面へ
    } else{
        return redirect()->route('login');
    }
});

Auth::routes();
//↑↑Laravelが提供している機能
//一般的な認証に関するルーティングを自動的に定義する
//ログイン画面に用意されているビューのリンク先がこの１行でOK!!

//Route::group(['middleware' => 'auth'], function () {
//    Route::resource('products', ProductController::class);
//});

Route::get('products',[App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::post('products',[App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
Route::get('products/create',[App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
Route::get('products/{id}',[App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::put('products/{id}',[App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
Route::delete('delete/{id}',[App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
Route::get('products/{id}/edit',[App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
Route::get('/cart/{id}', [App\Http\Controllers\ProductController::class, 'cart'])->name('cart');
Route::get('/search', [App\Http\Controllers\ProductController::class, 'search'])->name('search');

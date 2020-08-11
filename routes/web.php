<?php

use Illuminate\Support\Facades\Route;

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

//DEFAULT / HOME
Route::get('/', function () {
    return view('home');
});

// TRANSAKSI
Route::get('/transaksi',"TransaksiController@index");
Route::post('/transaksi/insert',"TransaksiController@insert");

// PRODUK
Route::get('/produk',"ProdukController@index");
Route::post('/produk/insert',"ProdukController@insert");
Route::get('/produk/getProdukByKategori/{id_kategori}',"ProdukController@getProdukByKategori");

// KATEGORI PRODUK
Route::get('/produk/kategori',"ProdukController@kategori");
Route::post('/produk/insertkategori',"ProdukController@insertKategori");

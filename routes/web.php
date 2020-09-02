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
Route::get('/', 'HomeController@index');

// TRANSAKSI
Route::get('/transaksi',"TransaksiController@index");
Route::post('/transaksi/insert',"TransaksiController@insert");

// PENGELUARAN
Route::get('/pengeluaran',"PengeluaranController@index");
Route::post('/pengeluaran/insert',"PengeluaranController@insert");

// PRODUK
Route::get('/produk',"ProdukController@index");
Route::post('/produk/insert',"ProdukController@insert");
Route::get('/produk/getProdukByKategori/{id_kategori}',"ProdukController@getProdukByKategori");
Route::get('/produk/getAllProduk',"ProdukController@getAllProduk");
Route::get('/produk/edit',"ProdukController@editProduk");
Route::POST('/produk/update',"ProdukController@updateProduk");



//STOK
Route::get('/stok',"ProdukController@stok");
Route::post('/addStok',"ProdukController@addStok");

// KATEGORI PRODUK
Route::get('/produk/kategori',"ProdukController@kategori");
Route::post('/produk/insertkategori',"ProdukController@insertKategori");

//LAPORAN
Route::get('/laporan/penjualan',"LaporanController@penjualan");
Route::POST('/laporan/penjualan',"LaporanController@getReportPenjualan");

//REFUND
Route::POST('/refund/',"RefundController@refund");

<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){
    //DEFAULT / HOME
    Route::get('/', 'HomeController@index');

    // TRANSAKSI
    Route::get('/transaksi',"TransaksiController@index");
    Route::post('/transaksi/insert',"TransaksiController@insert");

    // TRANSAKSI V2
    Route::get('/transaksiv2',"TransaksiController@indexv2");
    Route::post('/transaksi/insertv2',"TransaksiController@insertv2");

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
    Route::get('/produk/getProdukByInput/{input}',"ProdukController@getProdukByInput");
    Route::get('/produk/getProdukByCategoryInput/{id_kategori}/{input}',"ProdukController@getProdukByCategoryInput");
    Route::get('/produk/getproductbycode/{code}',"ProdukController@getProductByCode");

    //STOK
    Route::get('/stok',"ProdukController@stok");
    Route::post('/addStok',"ProdukController@addStok");

    //STOK V2
    Route::get('/stokv2',"ProdukController@stokv2");
    Route::post('/addStokv2',"ProdukController@addStokv2");

    // KATEGORI PRODUK
    Route::get('/produk/kategori',"ProdukController@kategori");
    Route::post('/produk/insertkategori',"ProdukController@insertKategori");

    //LAPORAN
    Route::get('/laporan/penjualan',"LaporanController@penjualan");
    Route::POST('/laporan/penjualan',"LaporanController@getReportPenjualan");

    //REFUND
    Route::POST('/refund/',"RefundController@refund");

    //EOD
    Route::POST('/eod',"EodController@eod");
});

//AUTH
Route::get('/login',"LoginController@index")->name("login");
Route::post('/dologin',"LoginController@login");
Route::get('/register',"RegisterController@index")->name("register");
Route::post('/doregister',"RegisterController@register");
Route::get('/logout',"LogoutController");

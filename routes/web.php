<?php

use App\Http\Middleware\checkAdmin;
use App\Http\Middleware\checkKasir;
use App\Http\Middleware\checkSuperUser;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){

    // ALL USER LOGIN
        //DEFAULT / HOME
        Route::get('/', 'HomeController@index');

        // PENGELUARAN
        Route::get('/pengeluaran',"PengeluaranController@index");
        Route::post('/pengeluaran/insert',"PengeluaranController@insert");
        Route::get('/produk/getAllProduk',"ProdukController@getAllProduk");

        // PRODUK
        Route::get('/produk',"ProdukController@index");
        Route::get('/produk/getProdukByKategori/{id_kategori}',"ProdukController@getProdukByKategori");
        Route::get('/produk/getProdukByInput/{input}',"ProdukController@getProdukByInput");
        Route::get('/produk/getProdukByCategoryInput/{id_kategori}/{input}',"ProdukController@getProdukByCategoryInput");
        Route::get('/produk/getproductbycode/{code}',"ProdukController@getProductByCode");

        //MENU
        Route::get('/menu/menuhaschild/{id}', 'MenuController@menuHasChild');

        //USER
        Route::get('/user/getbyid/{id}','UserController@getbyid');

    Route::middleware(['middleware' => checkKasir::class])->group(function(){   //KASIR
        // TRANSAKSI
        Route::get('/transaksi',"TransaksiController@index");
        Route::post('/transaksi/insert',"TransaksiController@insert");

        // TRANSAKSI V2
        Route::get('/transaksiv2',"TransaksiController@indexv2");
        Route::post('/transaksi/insertv2',"TransaksiController@insertv2");
    });

    Route::middleware(['middleware' => checkAdmin::class])->group(function(){   //ADMIN
        //PRODUK
        Route::post('/produk/insert',"ProdukController@insert");
        Route::get('/produk/edit',"ProdukController@editProduk");
        Route::POST('/produk/update',"ProdukController@updateProduk");

        //STOK
        Route::get('/stok',"ProdukController@stok");
        Route::post('/addStok',"ProdukController@addStok");

        //STOK V2
        Route::get('/stokv2',"ProdukController@stokv2");
        Route::post('/addStokv2',"ProdukController@addStokv2");

        // KATEGORI PRODUK
        Route::get('/produk/kategori',"ProdukController@kategori");
        Route::post('/produk/insertkategori',"ProdukController@insertKategori");

        //REFUND
        Route::POST('/refund',"RefundController@refund");

        //EOD
        Route::POST('/eod',"EodController@eod");

    });

    Route::middleware(['middleware' => checkSuperUser::class])->group(function(){   // SUPER USER
        //LAPORAN
        Route::get('/laporan/penjualan',"LaporanController@penjualan");
        Route::POST('/laporan/penjualan',"LaporanController@getReportPenjualan");
        Route::get('/laporan/eod',"LaporanController@eod");
        Route::POST('/laporan/eod',"LaporanController@getEod");

        //USER
        Route::get('/user',"UserController@index");
        Route::get('/user/getuser',"UserController@getUser");
        Route::post('/user/insert',"UserController@insert");
        Route::post('/user/update',"UserController@update");
        Route::post('/user/checkpass',"UserController@checkPass");
    });


});

// PUBLIC AREA
    //AUTH
    Route::get('/login',"LoginController@index")->name("login");
    Route::post('/dologin',"LoginController@login");
    Route::get('/register',"RegisterController@index")->name("register");
    Route::post('/doregister',"RegisterController@register");
    Route::get('/logout',"LogoutController");

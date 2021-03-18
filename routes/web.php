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
        Route::get('/pengeluaran/getAll',"PengeluaranController@getAll");
        Route::get('/pengeluaran/getByDate',"PengeluaranController@getByDate");

        // PEMASUKAN
        Route::get('/pemasukan',"PemasukanController@index");
        Route::post('/pemasukan/insert',"PemasukanController@insert");
        Route::get('/pemasukan/getAll',"PemasukanController@getAll");
        Route::get('/pemasukan/getByDate',"PemasukanController@getByDate");

        // MEMBER
        Route::get('/member',"MemberController@index");
        Route::post('/member/insert',"MemberController@store");
        Route::put('/member/update',"MemberController@update");
        Route::get('/member/getAll',"MemberController@getAll");
        Route::get('/member/getByDate',"MemberController@getByDate");
        Route::put('/member/getById',"MemberController@getById");
        Route::delete('/member/delete',"MemberController@delete");

        // PRODUCT CATEGORY
        Route::get('/product-category',"ProductCategoryController@index");
        Route::post('/product-category/insert',"ProductCategoryController@store");
        Route::put('/product-category/update',"ProductCategoryController@update");
        Route::get('/product-category/getAll',"ProductCategoryController@getAll");
        Route::get('/product-category/getByDate',"ProductCategoryController@getByDate");
        Route::put('/product-category/getById',"ProductCategoryController@getById");
        Route::delete('/product-category/delete',"ProductCategoryController@delete");

        // TRX CATEGORY
        Route::get('/trx-category',"TrxCategoryController@index");
        Route::post('/trx-category/insert',"TrxCategoryController@store");
        Route::put('/trx-category/update',"TrxCategoryController@update");
        Route::get('/trx-category/getAll',"TrxCategoryController@getAll");
        Route::get('/trx-category/getByDate',"TrxCategoryController@getByDate");
        Route::put('/trx-category/getById',"TrxCategoryController@getById");
        Route::delete('/trx-category/delete',"TrxCategoryController@delete");

        // History Refund
        Route::get('/history-refund',"RefundController@index");
        Route::get('/history-refund/getAll',"RefundController@getAll");
        
        // History Produk
        Route::get('/history-produk',"ProdukController@historyProduk");
        Route::get('/history-produk/getAllHistory',"ProdukController@getAllHistory");

        // Jasa Transfer
        Route::get('/jasatf',"JasaTFController@index");
        Route::post('/jasatf/insert',"JasaTFController@store");
        Route::put('/jasatf/update',"JasaTFController@update");
        Route::get('/jasatf/getAll',"JasaTFController@getAll");
        Route::get('/jasatf/getSetoranTF',"JasaTFController@getSetoranTF");
        Route::get('/jasatf/getProfitTF',"JasaTFController@getProfitTF");
        Route::get('/jasatf/getAdminTF',"JasaTFController@getAdminTF");
        Route::put('/jasatf/getById',"JasaTFController@getById");
        Route::delete('/jasatf/delete',"JasaTFController@delete");

        // PPOB
        Route::get('/ppob',"PPOBController@index");
        Route::put('/ppob/getOperator',"PPOBController@getOperator");
        Route::put('/ppob/getProduct',"PPOBController@getProduct");
        Route::post('/ppob/send',"PPOBController@send");
        Route::get('/ppob/update-product/{operator_id}',"PPOBController@send");

        // Rekening
        Route::get('/rekening',"RekeningController@index");
        Route::post('/rekening/insert',"RekeningController@store");
        Route::put('/rekening/update',"RekeningController@update");
        Route::get('/rekening/getAll',"RekeningController@getAll");
        Route::put('/rekening/getByNorek',"RekeningController@getByNorek");
        Route::get('/rekening/getByDate',"RekeningController@getByDate");
        Route::put('/rekening/getById',"RekeningController@getById");
        Route::delete('/rekening/delete',"RekeningController@delete");

        // PRODUK
        Route::get('/produk/getAll',"ProdukController@getAll");
        Route::get('/produk/get',"ProdukController@get");
        Route::get('/produk',"ProdukController@index");
        Route::get('/produk/getByKategori/{id_kategori}',"ProdukController@getByKategori");
        Route::get('/produk/getProdukByInput/{input}',"ProdukController@getProdukByInput");
        Route::get('/produk/getProdukByCategoryInput/{id_kategori}/{input}',"ProdukController@getProdukByCategoryInput");
        Route::get('/produk/getproductbycode/{code}',"ProdukController@getProductByCode");
        Route::put('/produk/getById',"ProdukController@getById");
        Route::put('/produk/getStockById',"ProdukController@getStockById");
        Route::get('/produk/getHistoryStokIn',"ProdukController@getHistoryStokIn");
        Route::get('/produk/getHistoryStokOut',"ProdukController@getHistoryStokOut");
        Route::get('/produk/getHistoryStokInByDate',"ProdukController@getHistoryStokInByDate");
        Route::get('/produk/getHistoryStokOutByDate',"ProdukController@getHistoryStokOutByDate");
        
        // KATEGORI
        Route::get('/kategori/get',"KategoriController@get");

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

    Route::middleware(['middleware' => checkAdmin::class])->group(function(){   //ADMIN / SPV
        
        // TRANSAKSI
        Route::get('/transaksi',"TransaksiController@index");
        Route::post('/transaksi/insert',"TransaksiController@insert");

        //PRODUK
        Route::post('/produk/insert',"ProdukController@insert");
        Route::put('/produk/update',"ProdukController@update");
        Route::delete('/produk/delete',"ProdukController@delete");
        Route::get('/stock-in',"ProdukController@stockIn");
        Route::post('/stock-in/insert',"ProdukController@addStock");

        //STOCK Out
        Route::get('/stock-out',"ProdukController@stockOut");
        Route::post('/stock-out/insert',"ProdukController@outStock");

        // KATEGORI PRODUK
        Route::get('/produk/kategori',"ProdukController@kategori");
        Route::post('/produk/insertkategori',"ProdukController@insertKategori");

        //REFUND
        Route::POST('/refund/insert',"RefundController@store");

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
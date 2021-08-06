<?php

namespace App\Http\Controllers;

use App\Finance;
use App\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends MenuController
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');

        $lastTrx = $this->getLastTrx();
        $sellDay = $this->getSellsDay();
        $admin_tf = App::call('App\Http\Controllers\JasaTFController@getAdminTF');

        $refund = $this->getRefund();
        //GANTI METODE STOK MENIPISNYA
        $produk = $this->getStokMenipis();
        $finance = Finance::select('balance')->first();

        $profit = $this->getAllProfit();
        
        $asset_produk = $this->getAssetProduct();
        $total_asset = $finance->balance + $asset_produk[0]->asset;

        $uang_minus = $this->getUangMinus();
        $uang_plus = $this->getUangPlus();
        $uang_tf = App::call('App\Http\Controllers\JasaTFController@getSetoranTF');

        $data = [
            'profit' => $profit,
            'lastTrx' => $lastTrx,
            'sellDay' => $sellDay[0],
            'produk' => $produk,
            'finance' => $finance,
            'total_asset' => $total_asset,
            'uang_minus' => $uang_minus[0]->uang_minus,
            'uang_plus' => $uang_plus[0]->uang_plus,
            'refund' => $refund,
            'admin_tf' => $admin_tf,
            'uang_tf' => $uang_tf
        ];

        return view('home')->with($data);
    }

    public function getLastTrx()
    {
        return DB::select("SELECT A.id,
        (SELECT B.nama_produk from produk B WHERE B.id = A.id_produk) as nama_produk,
        A.jumlah,
        A.total_harga,
        A.created_at,
        A.deskripsi_transaksi,
        A.id_trx_category
        FROM detail_transaksi A
        WHERE A.status = 1
        ORDER BY A.id
        DESC
        LIMIT 10");
    }

    public function getSellsDay()
    {
        return DB::select("
        SELECT sum(A.total_harga) as total_omset,
        sum(A.jumlah) as total_produk,
        count(A.id) as totalTrx
        FROM transaksi B
        INNER JOIN detail_transaksi A
        ON A.id_transaksi = B.id
        WHERE B.id_eod = 0
        AND B.status = 1
        AND A.status = 1
        AND A.id_trx_category IN (1,2)
        AND B.type IN (1,4)
        ");
    }

    public function getProfitKasir()
    {
        return DB::select("
        SELECT SUM(Z.profit) AS profit
        FROM
            (SELECT A.total_harga-(
                        SELECT (B.harga_modal*A.jumlah)
                        FROM produk B
                        WHERE B.id = A.id_produk )
                AS profit
            FROM detail_transaksi A
            INNER JOIN transaksi C
            ON A.id_transaksi = C.id
            WHERE C.id_eod = 0
            AND C.status = 1
            AND A.status = 1
            AND A.id_trx_category = 1
            AND C.type = 1 ) Z
        ");
    }
    
    public function getRefund()
    {
        return DB::select("
        SELECT B.deskripsi_transaksi, A.deskripsi_refund, A.created_at FROM refund A
        INNER JOIN detail_transaksi B ON A.id_detailtransaksi = B.id
        ORDER BY A.id DESC LIMIT 0,10 
        ");
    }

    public function getStokMenipis()
    {
        return DB::select("
        SELECT Z.nama_produk,Z.distributor,Z.stok,CEIL(Z.avg_sell_permonth/10) AS warning_stok, CEIL(Z.avg_sell_permonth/2) AS stok_wajar FROM (
            SELECT A.nama_produk,A.distributor,A.stok, (
                SELECT COALESCE(SUM(B.jumlah),0) FROM detail_transaksi B 
                WHERE A.id = B.id_produk AND B.id_trx_category=1 AND B.created_at > ?) AS avg_sell_permonth 
            FROM produk A WHERE A.status=1
            ) Z
        WHERE Z.avg_sell_permonth > 0
        AND Z.stok < 200
        AND Z.stok < CEIL(Z.avg_sell_permonth/10)
        ", [Carbon::now()->subDays(30)]);
    }
    
    public function getAssetProduct()
    {
        return DB::select('SELECT SUM(harga_modal*stok) AS asset FROM produk where stok < ?', [200]);
    }

    public function getUangMinus()
    {
        return DB::select("
        SELECT COALESCE(SUM(total_harga),0) as uang_minus FROM detail_transaksi 
        WHERE id_trx_category = 5
        AND MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
        AND status = 1
        ", []);
    }

    public function getUangPlus()
    {
        return DB::select("
        SELECT COALESCE(SUM(total_harga),0) as uang_plus FROM detail_transaksi 
        WHERE id_trx_category = 3 
        AND MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
        AND status = 1 
        ", []);
    }

    public function getAllProfit()
    {
        $profit_kasir = $this->getProfitKasir();
        $profit_tf = App::call('App\Http\Controllers\JasaTFController@getProfitTF');
        return $profit_kasir[0]->profit+$profit_tf;
    }

    public function getAllExpense()
    {
        return DB::select("
        SELECT COALESCE(sum(A.total_harga),0) as expense
        FROM transaksi B
        INNER JOIN detail_transaksi A
        ON A.id_transaksi = B.id
        WHERE B.id_eod = 0
        AND A.status = 1
        AND B.type = 3
        ");
    }


}

<?php

namespace App\Http\Controllers;

use App\Finance;
use App\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');

        $lastTrx = DB::select("SELECT A.id,
        (SELECT B.nama_produk from produk B WHERE B.id = A.id_produk) as nama_produk,
        A.jumlah,
        A.total_harga,
        A.created_at,
        A.deskripsi_transaksi
        FROM detail_transaksi A
        WHERE A.status = 1
        ORDER BY A.id
        DESC
        LIMIT 10");

        $sellDay = DB::select("
        SELECT sum(A.total_harga) as total_omset,
        sum(A.jumlah) as total_produk,
        count(A.id) as totalTrx
        FROM transaksi B
        INNER JOIN detail_transaksi A
        ON A.id_transaksi = B.id
        WHERE B.id_eod = 0
        AND A.status = 1
        AND A.total_harga > 0
        ");

        $profit = DB::select("
        SELECT SUM(Z.profit) as profit
        FROM
            (SELECT
                (A.total_harga-(SELECT ((B.harga_modal*A.jumlah)) as profit from produk B
                WHERE B.id = A.id_produk )) as profit
        FROM detail_transaksi A
        INNER JOIN transaksi C
        ON A.id_transaksi = C.id
        WHERE C.id_eod = 0
        AND A.status = 1 ) Z
        ");

        $refund = DB::select("
        SELECT C.nama_produk, A.deskripsi_refund, A.created_at FROM refund A
        INNER JOIN detail_transaksi B ON A.id_detailtransaksi = B.id
        INNER JOIN produk C ON B.id_produk = C.id LIMIT 0,10
        ");

        $produk = Produk::select('nama_produk','distributor','stok')->where('stok','<','10')->orderBy('stok')->get();
        $finance = Finance::select('balance')->first();


        $data = [
            'profit' => $profit[0]->profit,
            'lastTrx' => $lastTrx,
            'sellDay' => $sellDay[0],
            'produk' => $produk,
            'finance' => $finance,
            'refund' => $refund
        ];

        return view('home')->with($data);
    }
}

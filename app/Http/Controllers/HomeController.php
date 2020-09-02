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
        SELECT sum(total_harga) as total_omset,
        sum(jumlah) as total_produk,
        count(id) as totalTrx
        FROM detail_transaksi
        WHERE DATE(created_at) = '".$today."'
        AND status = 1
        ");

        $profit = DB::select("
        SELECT SUM(Z.profit) as profit
        FROM
            (SELECT
                (A.total_harga-(SELECT ((B.harga_modal*A.jumlah)) as profit from produk B
                WHERE B.id = A.id_produk )) as profit
        FROM detail_transaksi A
        WHERE DATE(A.created_at) = '".$today."'
        AND A.status = 1 ) Z
        ");

        $produk = Produk::select('nama_produk','distributor','stok')->where('stok','<','10')->get();
        $finance = Finance::select('balance')->first();


        $data = [
            'profit' => $profit[0]->profit,
            'lastTrx' => $lastTrx,
            'sellDay' => $sellDay[0],
            'produk' => $produk,
            'finance' => $finance
        ];

        return view('home')->with($data);
    }
}

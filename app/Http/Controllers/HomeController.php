<?php

namespace App\Http\Controllers;

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
        A.created_at
        FROM detail_transaksi A
        ORDER BY A.id
        DESC
        LIMIT 10");

        $sellDay = DB::select("
        SELECT sum(total_harga) as total_omset,
        sum(jumlah) as total_produk,
        count(id) as totalTrx
        FROM detail_transaksi
        WHERE DATE(created_at) = '".$today."'
        ");

        $profit = DB::select("
        SELECT SUM(Z.profit) as profit
        FROM
            (SELECT
                (A.total_harga-(SELECT ((B.harga_modal*A.jumlah)) as profit from produk B
                WHERE B.id = A.id_produk )) as profit
        FROM detail_transaksi A
        WHERE DATE(A.created_at) = '".$today."' ) Z
        ");

        $produk = Produk::select('nama_produk','distributor','stok')->where('stok','<','10')->get();


        $data = [
            'profit' => $profit[0]->profit,
            'lastTrx' => $lastTrx,
            'sellDay' => $sellDay[0],
            'produk' => $produk
        ];

        return view('home')->with($data);
    }
}

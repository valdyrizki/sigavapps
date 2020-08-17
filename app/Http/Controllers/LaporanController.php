<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function penjualan()
    {
        $report = DB::select("SELECT DISTINCT A.id_produk,
        (SELECT B.nama_produk from produk B WHERE B.id = A.id_produk) as nama_barang,
        (SELECT COUNT(C.jumlah) from detail_transaksi C WHERE C.id_produk = A.id_produk) as total_jual,
        (SELECT SUM(D.total_harga) from detail_transaksi D WHERE D.id_produk = A.id_produk) as total_harga
        FROM detail_transaksi A");
        dd($report);
        return view("laporan.penjualan",compact('report'));
    }
}

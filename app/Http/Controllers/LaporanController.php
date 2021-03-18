<?php

namespace App\Http\Controllers;

use App\Eod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function penjualan()
    {
        $today = Carbon::today()->format('Y-m-d');

        $report = DB::select(
        "SELECT A.id,
        (SELECT B.nama_produk from produk B WHERE B.id = A.id_produk) as nama_produk,
        A.jumlah,
        A.total_harga,
        A.created_at,
        A.deskripsi_transaksi,
        A.id_trx_category,
        C.id_eod
        FROM detail_transaksi A, transaksi C
        WHERE A.id_transaksi = C.id
        AND DATE(A.created_at) = '".$today."'
        AND A.status = 1
        ORDER BY A.created_at
        ");

        return view("laporan.penjualan",compact('report'));
    }

    public function getReportPenjualan(Request $req)
    {
        $tglAwal = substr($req->dtReport,0,10);
        $tglAkhir = substr($req->dtReport,13);

        $report = DB::select("SELECT A.id,
        (SELECT B.nama_produk from produk B WHERE B.id = A.id_produk) as nama_produk,
        A.jumlah,
        A.total_harga,
        A.created_at,
        A.deskripsi_transaksi,
        A.id_trx_category,
        C.id_eod
        FROM detail_transaksi A, transaksi C
        WHERE A.id_transaksi = C.id
        AND DATE(A.created_at) BETWEEN '".$tglAwal."' AND '".$tglAkhir."'
        AND A.status = 1
        ORDER BY A.created_at");

        return view("laporan.penjualan",compact('report'));
    }

    public function eod()
    {
        $report = Eod::limit(5)->orderBy("id","desc")->get();
        return view("laporan.eod",compact('report'));
    }

    public function getEod(Request $req)
    {
        $tglAwal = substr($req->dtReport,0,10);
        $tglAkhir = substr($req->dtReport,13);
        $report = Eod::whereBetween('created_at', [$tglAwal,$tglAkhir.' 23:59:59'])->get();
        return view("laporan.eod",compact('report'));
    }
}

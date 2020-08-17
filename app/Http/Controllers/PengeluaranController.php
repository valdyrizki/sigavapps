<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use App\Kategori;
use App\Produk;
use App\Transaksi;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        $transaksi = DetailTransaksi::select('total_harga','deskripsi_transaksi')->where('total_harga','<',0)->get();
        return view("pengeluaran.index",compact("transaksi"));
    }

    public function insert()
    {
        $trx = Transaksi::create([
            'total_harga' => request()->jumlah_pengeluaran*-1
        ]);

            DetailTransaksi::create([
                'id_transaksi' => $trx->id,
                'id_produk' => 0,
                'jumlah' => 1,
                'total_harga' => request()->jumlah_pengeluaran*-1,
                'deskripsi_transaksi' => request()->deskripsi_pengeluaran
            ]);

        return response()->json([
            'message' => 'Pengeluaran Berhasil Tersimpan'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use App\Finance;
use App\Kategori;
use App\Produk;
use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function index()
    {
        $transaksi = DetailTransaksi::select('total_harga','deskripsi_transaksi','created_at')->where('total_harga','<',0)->get();
        return view("pengeluaran.index",compact("transaksi"));
    }

    public function insert()
    {
        $finance = Finance::first();
        $balance = $finance->balance + request()->jumlah_pengeluaran*-1;

        $trx = Transaksi::create([
            'total_harga' => request()->jumlah_pengeluaran*-1,
            'balance_before' => $finance->balance,
            'balance_after' => $balance,
            'user' => Auth::user()->email
        ]);

        $finance->balance = $balance;
        $finance->expense += request()->jumlah_pengeluaran;
        $finance->save();

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

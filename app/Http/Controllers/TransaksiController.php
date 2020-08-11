<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use App\Kategori;
use App\Produk;
use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\Input;

class TransaksiController extends Controller
{
    public function index()
    {
        $kategori = Kategori::select('id','nama_kategori')->get();
        return view("transaksi.index",compact("kategori"));
    }

    public function insert()
    {
        $trx = Transaksi::create([
            'total_harga' => request()->totalHarga
        ]);

        foreach (request()->detailTransaksi as $arr){
            DetailTransaksi::create([
                'id_transaksi' => $trx->id,
                'id_produk' => $arr['id_produk'],
                'jumlah' => $arr['jumlah'],
                'total_harga' => $arr['total_harga']
            ]);

            $produk = Produk::find($arr['id_produk']);
            $produk->stok = $produk->stok-$arr['jumlah'];
            $produk->save();
        }
        return response()->json([
            'message' => 'Transaksi Berhasil'
        ]);
    }
}

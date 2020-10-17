<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use App\Finance;
use App\HistoryStok;
use App\Produk;
use App\Refund;
use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
{
    public function refund()
    {
        $detail_transaksi = DetailTransaksi::find(request()->id_detailtransaksi);

        //RETUR STOK (Hanya untuk transaksi, tidak untuk pengeluaran)
        if($detail_transaksi->total_harga > 0){
            $produk = Produk::find($detail_transaksi->id_produk);
            $hist_stok = new HistoryStok;
            $hist_stok->id_produk = $produk->id;
            $hist_stok->before = $produk->stok;
            $hist_stok->add_stok = $detail_transaksi->jumlah;
            $hist_stok->after = $detail_transaksi->jumlah+$produk->stok;

            $produk->stok = $produk->stok+$detail_transaksi->jumlah;
            $produk->save();
            $hist_stok->save();
        }

        //Recovery Finance
        $finance = Finance::first();
        if($detail_transaksi->total_harga > 0){
            $finance->income -= $detail_transaksi->total_harga;
        }else{
            $finance->expense -= $detail_transaksi->total_harga;
        }
        $finance->balance = $finance->balance -= $detail_transaksi->total_harga;

        //UPDATE TRX
        $trx = Transaksi::find($detail_transaksi->id_transaksi);
        $trx->total_harga = $trx->total_harga-$detail_transaksi->total_harga;
        $trx->balance_after = $trx->balance_after-$detail_transaksi->total_harga;

         //INSERT HIST REFUND
         $refund = new Refund();
         $refund->id_detailtransaksi = $detail_transaksi->id;
         $refund->deskripsi_refund = request()->deskripsi_refund;
         $refund->user = Auth::user()->email;

         $detail_transaksi->status = 9;

        //ACTION
        $refund->save();
        $trx->save();
        $finance->save();
        $detail_transaksi->save();

        return redirect('/laporan/penjualan');
    }
}

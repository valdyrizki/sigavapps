<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use App\Finance;
use App\HistoryStok;
use App\Produk;
use App\Refund;
use App\Transaksi;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function refund()
    {
        $detail_transaksi = DetailTransaksi::find(request()->id_detailtransaksi);

        //RETUR STOK
        $produk = Produk::find($detail_transaksi->id_produk);
        $produk->stok = $produk->stok+$detail_transaksi->jumlah;

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

         $detail_transaksi->status = 9;

        //ACTION
        $refund->save();
        $trx->save();
        $finance->save();
        $produk->save();
        $detail_transaksi->save();

        return redirect('/laporan/penjualan');
    }
}

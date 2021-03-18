<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use App\Finance;
use App\HistoryStok;
use App\Http\Resources\RefundResource;
use App\JasaTF;
use App\Produk;
use App\Refund;
use App\Transaksi;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{

    public function index(){
        return view('history-refund.index');
    }

    public function store()
    {
        $detail_transaksi = DetailTransaksi::find(request()->id_detailtransaksi);
        DB::beginTransaction();
        try{
            //RETUR STOK (Hanya untuk transaksi, tidak untuk pengeluaran)
            if($detail_transaksi->id_trx_category == 1){
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
            //Update status if Jasa Transfer
            if($detail_transaksi->id_trx_category == 2){
                //BAGAIMANA CARA UPDATE STATUS SI JASA TRANSFERNYA ?
                // Timpa di id_produk
                $jasa_tf = JasaTF::find($detail_transaksi->id_produk);
                $jasa_tf->status = 9;
                $jasa_tf->save();
            }

            //Recovery Finance
            $finance = Finance::first();
            if($detail_transaksi->total_harga > 0){
                $finance->income -= $detail_transaksi->total_harga;
            }else{
                $finance->expense -= $detail_transaksi->total_harga;
            }
            $finance->balance = $finance->balance -= $detail_transaksi->total_harga;
            $finance->save();

            //UPDATE TRX
            $trx = Transaksi::find($detail_transaksi->id_transaksi);
            $trx->total_harga = $trx->total_harga-$detail_transaksi->total_harga;
            $trx->balance_after = $trx->balance_after-$detail_transaksi->total_harga;
            $trx->save();

            //INSERT HIST REFUND
            $refund = new Refund();
            $refund->id_detailtransaksi = $detail_transaksi->id;
            $refund->deskripsi_refund = request()->deskripsi_refund;
            $refund->user = Auth::user()->email;
            $refund->save();

            $detail_transaksi->status = 9;
            $detail_transaksi->save();
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            report($e);
        }
        

        //ACTION

        return redirect('/laporan/penjualan');
    }

    public function getAll()
    {
        return RefundResource::collection(Refund::join('detail_transaksi','detail_transaksi.id','=','refund.id')
                                                ->join('produk','produk.id','detail_transaksi.id_produk')
                                                ->get(['refund.*','detail_transaksi.jumlah','produk.nama_produk'])
                                            );
    }
}

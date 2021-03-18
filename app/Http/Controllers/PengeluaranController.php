<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use App\Finance;
use App\Http\Resources\PengeluaranResource;
use App\Kategori;
use App\Produk;
use App\Transaksi;
use App\TrxCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function index()
    {
        $kategori = TrxCategory::select('id','category_name','description')->where('status',1)->where('type',2)->get();
        return view("pengeluaran.index",compact('kategori'));
    }

    public function getAll(){

        // $transaksi = DB::select("
        // SELECT A.created_at, A.deskripsi_transaksi, B.nama, A.total_harga 
        // FROM detail_transaksi A, trx_categories B
        // WHERE A.id_trx_category =  B.id
        // AND A.total_harga < 0
        // ");

        $transaksi = DetailTransaksi::
        select('detail_transaksi.id','detail_transaksi.created_at','detail_transaksi.deskripsi_transaksi','trx_categories.category_name','detail_transaksi.total_harga')
        ->join('trx_categories', 'detail_transaksi.id_trx_category', '=', 'trx_categories.id')
        ->where('total_harga','<',0)
        ->get();

        return PengeluaranResource::collection($transaksi);
    }

    public function getByDate(){

        $end = date('Y-m-d', strtotime(request()->end. ' + 1 days'));

        $transaksi = DB::select("
        SELECT A.id,A.created_at, A.deskripsi_transaksi, B.category_name, A.total_harga 
        FROM detail_transaksi A, trx_categories B
        WHERE A.id_trx_category =  B.id
        AND A.total_harga < 0
        AND A.created_at BETWEEN ? AND ?
        ",[request()->start,$end]);

        // $transaksi = DetailTransaksi::
        // select('detail_transaksi.created_at','detail_transaksi.deskripsi_transaksi','trx_categories.nama','detail_transaksi.total_harga')
        // ->join('trx_categories', 'detail_transaksi.id_trx_category', '=', 'trx_categories.id')
        // ->where('total_harga','<',0)
        // ->whereBetween('detail_transaksi.created_at',array('2020-02-01','2020-02-05'))
        // ->get();

        return PengeluaranResource::collection($transaksi);
    }

    public function insert()
    {
        $finance = Finance::first();
        $balance = $finance->balance + request()->jumlah_pengeluaran*-1;

        $trx = Transaksi::create([
            'total_harga' => request()->jumlah_pengeluaran*-1,
            'balance_before' => $finance->balance,
            'balance_after' => $balance,
            'user' => Auth::user()->email,
            'type' => 3 //1 = Transaksi kasir, 2 = Pemasukan, 3 = Pengeluaran, 4 = Jasa TF (Default 1)
        ]); 

        $finance->balance = $balance;
        $finance->expense += request()->jumlah_pengeluaran;
        $finance->save();

        DetailTransaksi::create([
            'id_transaksi' => $trx->id,
            'jumlah' => 1,
            'total_harga' => request()->jumlah_pengeluaran*-1,
            'deskripsi_transaksi' => request()->deskripsi_pengeluaran,
            'id_trx_category' => request()->id_trx_category
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengeluaran Berhasil Tersimpan'
        ]);
    }
}

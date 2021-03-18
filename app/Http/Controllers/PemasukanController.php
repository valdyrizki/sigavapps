<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use App\Finance;
use App\Http\Resources\PemasukanResource;
use App\Transaksi;
use App\TrxCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemasukanController extends Controller
{
    public function index()
    {
        $kategori = TrxCategory::select('id','category_name','description')
        ->where('status',1)
        ->where('type',1)
        ->whereNotIn('id',[1,2]) //SELAIN TRANSAKSI KASIR dan TF
        ->get();
        return view("pemasukan.index",compact('kategori'));
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
        ->where('total_harga','>',0)
        ->whereNotIn('detail_transaksi.id_trx_category',[1,2]) //SELAIN TRANSAKSI KASIR dan TF
        ->get();

        return PemasukanResource::collection($transaksi);
    }

    public function getByDate(){

        $end = date('Y-m-d', strtotime(request()->end. ' + 1 days'));

        $transaksi = DB::select("
        SELECT A.id,A.created_at, A.deskripsi_transaksi, B.category_name, A.total_harga 
        FROM detail_transaksi A, trx_categories B
        WHERE A.id_trx_category =  B.id
        AND A.total_harga > 0
        AND A.id_trx_category NOT IN (1,2)
        AND A.created_at BETWEEN ? AND ?
        ",[request()->start,$end]);

        return PemasukanResource::collection($transaksi);
    }

    public function insert()
    {
        $finance = Finance::first();
        $balance = $finance->balance + request()->jumlah_pemasukan;

        $trx = Transaksi::create([
            'total_harga' => request()->jumlah_pemasukan,
            'balance_before' => $finance->balance,
            'balance_after' => $balance,
            'user' => Auth::user()->email,
            'type' => 2 //1 = Transaksi kasir, 2 = Pemasukan, 3 = Pengeluaran (Default 1)
        ]); 

        $finance->balance = $balance;
        $finance->income += request()->jumlah_pemasukan;
        $finance->save();

        DetailTransaksi::create([
            'id_transaksi' => $trx->id,
            'jumlah' => 1,
            'total_harga' => request()->jumlah_pemasukan,
            'deskripsi_transaksi' => request()->deskripsi_pemasukan,
            'id_trx_category' => request()->id_trx_category
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pemasukan Berhasil Tersimpan'
        ]);
    }
}

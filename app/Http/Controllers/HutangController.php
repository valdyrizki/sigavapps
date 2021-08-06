<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use App\Finance;
use App\Http\Resources\HutangResource;
use App\Http\Resources\PemasukanResource;
use App\Hutang;
use App\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HutangController extends Controller
{
    public function index()
    {
        return view("hutang.index");
    }

    public function getAll(){

        // $transaksi = DB::select("
        // SELECT A.created_at, A.deskripsi_transaksi, B.nama, A.total_harga 
        // FROM detail_transaksi A, trx_categories B
        // WHERE A.id_trx_category =  B.id
        // AND A.total_harga < 0
        // ");

        $hutang = Hutang::
        select('hutangs.*','members.nama')
        ->join('members', 'hutangs.id_member', '=', 'members.id')
        ->where('hutangs.status',0)
        ->get();

        return HutangResource::collection($hutang);
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

    public function bayar()
    {
        $id_hutang = request()->id;
        DB::beginTransaction();
        $msg = 'Hutang berhasil dibayar';
        
        try{
            $hutang =Hutang::find($id_hutang);
            $hutang->status = 1;
            $hutang->save();

            $finance = Finance::first();
            $balance = $finance->balance + $hutang->jumlah;

            $trx = Transaksi::where("id",$hutang->id_transaksi)->update([
                "status" => 1,
                "balance_before" => $finance->balance,
                'balance_after' => $balance
            ]);

            $finance->balance = $balance;
            $finance->income += $hutang->jumlah;
            $finance->save();

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            report($e);
            $msg = $hutang->jumlah;
        }

        return response()->json([
            'status' => 'success',
            'message' => $msg
        ]);
        
    }
}

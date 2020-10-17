<?php

namespace App\Http\Controllers;

use App\Eod;
use App\Finance;
use App\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EodController extends Controller
{
    public function eod()
    {

        $sellDay = DB::select("
        SELECT sum(A.total_harga) as total_omset,
        sum(A.jumlah) as total_produk,
        count(A.id) as totalTrx
        FROM transaksi B
        INNER JOIN detail_transaksi A
        ON A.id_transaksi = B.id
        WHERE B.id_eod = 0
        AND A.status = 1
        AND A.total_harga > 0
        ");

        $profit = DB::select("
        SELECT SUM(Z.profit) as profit
        FROM
            (SELECT
                (A.total_harga-(SELECT ((B.harga_modal*A.jumlah)) as profit from produk B
                WHERE B.id = A.id_produk )) as profit
        FROM detail_transaksi A
        INNER JOIN transaksi C
        ON A.id_transaksi = C.id
        WHERE C.id_eod = 0
        AND A.status = 1 ) Z
        ");

        $finance = Finance::select('balance')->first();
        $msg = 'Proses EOD Berhasil';
        if($sellDay[0]->total_produk != null && $sellDay[0]->total_omset != null){
            try{
                $eod = Eod::create([
                    'omset' => $sellDay[0]->total_omset,
                    'profit' => $profit[0]->profit,
                    'sell' => $sellDay[0]->total_produk,
                    'saldo_akhir' => $finance->balance
                ]);
                Transaksi::where("id_eod",0)->update(['id_eod' => $eod->id]);
            }catch(Exception $e){
                return response()->json([
                    'message' => "Ada kesalahan transaksi, Proses EOD Gagal",
                    'error' => true
                ]);
            }
        }else{
            return response()->json([
                'message' => "Tidak ada transaksi, Proses EOD Gagal",
                'error' => true
            ]);
        }

        return response()->json([
            'message' => $msg
        ]);
    }
}

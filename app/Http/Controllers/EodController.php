<?php

namespace App\Http\Controllers;

use App\Eod;
use App\Finance;
use App\JasaTF;
use App\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EodController extends Controller
{
    public function eod()
    {

        $sellDay = App::call('App\Http\Controllers\HomeController@getSellsDay');
        $profit = App::call('App\Http\Controllers\HomeController@getAllProfit');
        $expense = App::call('App\Http\Controllers\HomeController@getAllExpense');

        $finance = Finance::select('balance')->first();
        $msg = 'Proses EOD Berhasil';
        if($sellDay[0]->total_produk != null && $sellDay[0]->total_omset != null){
            DB::beginTransaction();
            try{
                $uangTF = JasaTF::whereStatus(1)->sum("jumlah");
                //CREATE EOD
                $eod = Eod::create([
                    'omset' => $sellDay[0]->total_omset,
                    'profit' => $profit,
                    'sell' => $sellDay[0]->total_produk,
                    'saldo_akhir' => $finance->balance,
                    'expense' => $expense[0]->expense,
                    'total_tf' => $uangTF,
                    'admin_tf' => App::call('App\Http\Controllers\JasaTFController@getAdminTF')
                ]);

                $request = Http::get('https://api.telegram.org/bot1641094965:AAG0kjhFWdBWXnygWwantTOtvjNEtvANiFU/sendMessage',
                [
                    'chat_id'=>'-1001368719479',
                    'parse_mode' => 'HTML',
                    'text' => 'Toko telah tutup, berikut rincian penghasilannya : 
                    Omset : '.formatRupiah($sellDay[0]->total_omset).'
                    Profit : '.formatRupiah($profit).'
                    Uang TF : '.formatRupiah($uangTF).'
                    Admin TF : '.formatRupiah(App::call('App\Http\Controllers\JasaTFController@getAdminTF'))
                ]);
                $response = $request->getBody();

                // UPDATE TRX
                Transaksi::where("id_eod",0)->update(['id_eod' => $eod->id]);

                //UPDATE JASA TRANSFER
                JasaTF::where("status",1)->update(['status' => 2]);

                App::call('App\Http\Controllers\ProdukController@updateStokWajar');

                DB::commit();
            }catch(Exception $e){
                DB::rollback();
                return response()->json([
                    'message' => "Ada kesalahan transaksi, Proses EOD Gagal",
                    'msg' => $e,
                    'error' => true,
                    'res' => $response
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

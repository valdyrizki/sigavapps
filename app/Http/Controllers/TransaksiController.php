<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use App\Finance;
use App\Hutang;
use App\ProductCategory;
use App\Produk;
use App\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\Input;

class TransaksiController extends Controller
{
    public function index()
    {            
        $kategori = ProductCategory::select('id','category_name')->get();
        return view("transaksi.index",compact("kategori"));
    }

    // public function indexv2()
    // {
    //     return view("transaksi.indexv2");
    // }

    public function insert()
    {
        
        $finance = Finance::first();
        $balance = $finance->balance + request()->totalHarga;

        $id_member = request()->id_member == null ? 0 : request()->id_member;
        $deskripsi_transaksi = request()->deskripsi_transaksi == "" ? "-" : request()->deskripsi_transaksi;
        $msg = 'Transaksi Berhasil';
        DB::beginTransaction();
        try{
            if(request()->status == 1){ //Bayar Cash

                $trx = Transaksi::create([
                    'total_harga' => request()->totalHarga,
                    'balance_before' => $finance->balance,
                    'balance_after' => $balance,
                    'deskripsi_transaksi' => $deskripsi_transaksi,
                    'status' => request()->status,
                    'id_member' => $id_member
                ]);
        
                $finance->balance = $balance;
                $finance->income += request()->totalHarga;
                $finance->save();
        
                foreach (request()->detailTransaksi as $arr){
                    $produk = Produk::find($arr['id_produk']);
                    $produk->stok = $produk->stok-$arr['jumlah'];
                    $produk->save();
                    
                    DetailTransaksi::create([
                        'id_transaksi' => $trx->id,
                        'id_produk' => $arr['id_produk'],
                        'jumlah' => $arr['jumlah'],
                        'total_harga' => $arr['total_harga'],
                        'deskripsi_transaksi' => $produk->nama_produk." ".$arr['jumlah']." pcs",
                        'status' => 1
                    ]);
        
                }
            }else if(request()->status == 2){
                $trx = Transaksi::create([
                    'total_harga' => request()->totalHarga,
                    'balance_before' => $finance->balance,
                    'balance_after' => $finance->balance,
                    'deskripsi_transaksi' => $deskripsi_transaksi,
                    'status' => request()->status,
                    'id_member' => $id_member
                ]);
        
                foreach (request()->detailTransaksi as $arr){
                    $produk = Produk::find($arr['id_produk']);
                    $produk->stok = $produk->stok-$arr['jumlah'];
                    $produk->save();
                    
                    DetailTransaksi::create([
                        'id_transaksi' => $trx->id,
                        'id_produk' => $arr['id_produk'],
                        'jumlah' => $arr['jumlah'],
                        'total_harga' => $arr['total_harga'],
                        'deskripsi_transaksi' => $produk->nama_produk." ".$arr['jumlah']." pcs",
                        'status' => 1
                    ]);
                }
    
                Hutang::create([
                    'id_transaksi' => $trx->id,
                    'id_member' => $id_member,
                    'jumlah' => $trx->total_harga,
                    'deskripsi' => $deskripsi_transaksi
                ]);
            }
            
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            report($e);
            $msg = 'Transaksi Gagal';
        }
        
        return response()->json([
            'message' => $msg
        ]);
    }

    public function insertv2()
    {
        $finance = Finance::first();
        $balance = $finance->balance + request()->totalHarga;

        $trx = Transaksi::create([
            'total_harga' => request()->totalHarga,
            'balance_before' => $finance->balance,
            'balance_after' => $balance
        ]);

        $finance->balance = $balance;
        $finance->income += request()->totalHarga;

        foreach (request()->data as $arr){
            DetailTransaksi::create([
                'id_transaksi' => $trx->id,
                'id_produk' => $arr['id_produk'],
                'jumlah' => $arr['jumlah'],
                'total_harga' => $arr['harga_jual']*$arr['jumlah'],
                'status' => 1
            ]);

            $produk = Produk::find($arr['id_produk']);
            $produk->stok = $produk->stok-$arr['jumlah'];
            $produk->save();
        }

        $finance->save();

        return response()->json([
            'message' => 'Transaksi Berhasil'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\BiayaAdmin;
use App\DetailTransaksi;
use App\Finance;
use App\Http\Resources\JasaTFResource;
use App\JasaTF;
use App\Member;
use App\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JasaTFController extends Controller
{
    public function index()
    {
        return view("jasatf.index");
    }

    public function getAll()
    {
        $jasatf = DB::select('  SELECT A.created_at,A.id,A.norek,A.an,A.jumlah,C.biaya,A.bank , A.status
                                FROM jasa_tf A
                                INNER JOIN biaya_admins C ON A.id_biaya_admin = C.id
                                 ', []);

        return JasaTFResource::collection($jasatf);
    }

    public function getSetoranTF()
    {   
        $jasatf = JasaTF::where('status',1)->sum('jumlah');
        return $jasatf;
    }
    
    public function getProfitTF()
    {   
        $jasatf = DB::select('  SELECT COALESCE(sum(B.biaya-B.potongan),0) AS jml 
                                FROM jasa_tf A,biaya_admins B 
                                WHERE A.status = ?
                                AND A.id_biaya_admin = B.id
                                ', [1]);
        return $jasatf[0]->jml;
    }

    public function getAdminTF()
    {   
        $jasatf = DB::select('  SELECT COALESCE(sum(B.potongan),0) AS jml 
                                FROM jasa_tf A,biaya_admins B 
                                WHERE A.status = ?
                                AND A.id_biaya_admin = B.id
                                ', [1]);
        return $jasatf[0]->jml;
    }

    public function getById()
    {
        
        $status = 'success';
        try{
            $data = JasaTF::find(request()->id);
        }catch(Exception $e){
            $status = 'error';
            $data = $e;
        }
        
        return response()->json([
            'status' => $status,
            'data' => $data
        ]);
    }

    public function store(Request $req)
    {
        $status = 'success';
        $message = 'Jasa TF '.$req->nama.' berhasil disimpan';
        $biaya_admin = BiayaAdmin::select('id','biaya','potongan')->where('akhir','>=',$req->jumlah)->where('mulai','<=',$req->jumlah)->first();
        $id_biaya_admin = $biaya_admin->id != null ? $biaya_admin->id : 0;
        $biaya = $biaya_admin->biaya - $biaya_admin->potongan;
        try{
            DB::beginTransaction();
            $jasatf = JasaTF::create($req->all() + ['id_biaya_admin' => $id_biaya_admin]);
            $data = $jasatf;

            $finance = Finance::first();
            $balance = $finance->balance + $biaya;

            $trx = Transaksi::create([
                'total_harga' => $biaya,
                'balance_before' => $finance->balance,
                'balance_after' => $balance,
                'user' => Auth::user()->email,
                'type' => 4 //1 = Transaksi kasir, 2 = Pemasukan, 3 = Pengeluaran, 4 = Jasa Transfer (Default 1)
            ]); 

            $finance->balance = $balance;
            $finance->income += $biaya;
            $finance->save();

            DetailTransaksi::create([
                'id_transaksi' => $trx->id,
                'id_produk' => $jasatf->id,
                'jumlah' => 1,
                'total_harga' => $biaya,
                'deskripsi_transaksi' => 'Transfer A.n : '.$jasatf->an.' Rp '.formatRupiah($jasatf->jumlah),
                'id_trx_category' => 2
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            report($e);
            $status = 'error';
            $message = 'Jasa TF Gagal tersimpan';
            $data = $e;
        }

        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ]);
    }

    public function update()
    {
        try{
            $member = Member::find(request()->id);
            $member->nama = request()->nama;
            $member->no_hp = request()->no_hp;
            $member->norek = request()->norek;
            $member->bank = request()->bank;
            $member->deskripsi = request()->deskripsi;
            $member->status = request()->status;
            $member->save();

            $msg = "Member berhasil diupdate";
            $status = 'success';
            $data = $member;
        }catch(Exception $e){
            $msg = "Data".request()->name." gagal diupdate";
            $status = "error";
            $data = $e;
        }

        return response()->json([
            'msg' => $msg,
            'status' => $status,
            'data' => $data
        ]);
    }

    public function delete(Request $req)
    {
        $status = 'success';
        $message = 'Member '.$req->nama.' berhasil dihapus';

        try{
            Member::where('id', $req->id)->delete();
            $data = $req;
        }catch(Exception $e){
            $status = 'error';
            $message = 'Member '.$req->nama.' gagal dihapus';
            $data = $e;
        }

        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ]);
    }
}

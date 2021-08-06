<?php

namespace App\Http\Controllers;

use App\Http\Resources\RekeningResource;
use App\Rekening;
use Exception;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public function index()
    {
        return view("rekening.index");
    }

    public function getAll()
    {
        return RekeningResource::collection(Rekening::all());
    }

    public function store(Request $req)
    {
        $status = 'success';
        $message = 'Rekening '.$req->nama.' berhasil disimpan';

        try{
            $rekening = Rekening::create($req->all());
            $data = $rekening;
        }catch(Exception $e){
            $status = 'error';
            $message = 'Rekening '.$req->nama.' Gagal tersimpan';
            $data = $e;
        }

        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ]);
    }

    public function getById()
    {
        $status = 'success';
        try{
            $data = Rekening::find(request()->id);
        }catch(Exception $e){
            $status = 'error';
            $data = $e;
        }
        
        return response()->json([
            'status' => $status,
            'data' => $data
        ]);
    }

    public function update()
    {
        try{
            $rekening = Rekening::find(request()->id);
            $rekening->an = request()->nama;
            $rekening->norek = request()->norek;
            $rekening->bank = request()->bank;
            $rekening->save();

            $msg = "Rekening berhasil diupdate";
            $status = 'success';
            $data = $rekening;
        }catch(Exception $e){
            $msg = $e->getMessage();
            // $msg = "Data".request()->name." gagal diupdate";
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
        $message = 'Rekening '.$req->nama.' berhasil dihapus';

        try{
            Rekening::where('id', $req->id)->delete();
            $data = $req;
        }catch(Exception $e){
            $status = 'error';
            $message = 'Rekening '.$req->nama.' gagal dihapus';
            $data = $e;
        }

        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ]);
    }

    public function getByNorek()
    {
        $status = 'success';
        try{
            $data = Rekening::whereNorek(request()->norek)->first();
        }catch(Exception $e){
            $status = 'error';
            $data = $e;
        }
        
        return response()->json([
            'status' => $status,
            'data' => $data
        ]);
    }
}

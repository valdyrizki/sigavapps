<?php

namespace App\Http\Controllers;

use App\Http\Resources\TrxCategoryResource;
use App\TrxCategory;
use Exception;
use Illuminate\Http\Request;

class TrxCategoryController extends Controller
{
    public function index()
    {
        return view("trx-category.index");
    }

    public function getAll()
    {
        return TrxCategoryResource::collection(TrxCategory::all());
    }

    public function getById()
    {
        
        $status = 'success';
        try{
            $data = TrxCategory::find(request()->id);
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
        $message = 'Kategori '.$req->category_name.' berhasil disimpan';

        try{
            $category = TrxCategory::create($req->all());
            $data = $category;
        }catch(Exception $e){
            $status = 'error';
            $message = 'Kategori '.$req->category_name.' Gagal tersimpan';
            $data = $req->all();
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
            $category = TrxCategory::find(request()->id);
            $category->category_name = request()->category_name;
            $category->description = request()->description;
            $category->type = request()->type;
            $category->status = request()->status;
            $category->save();

            $msg = "Kategori berhasil diupdate";
            $status = 'success';
            $data = $category;
        }catch(Exception $e){
            $msg = "Data".request()->category_name." gagal diupdate";
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
        $message = 'Kategori '.$req->category_name.' berhasil dihapus';

        try{
            TrxCategory::where('id', $req->id)->delete();
            $data = $req;
        }catch(Exception $e){
            $status = 'error';
            $message = 'Kategori '.$req->category_name.' gagal dihapus';
            $data = $e;
        }

        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ]);
    }
}

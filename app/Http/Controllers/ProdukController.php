<?php

namespace App\Http\Controllers;

use App\HistoryProduk;
use App\HistoryStok;
use App\Kategori;
use App\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $kategori = Kategori::select('id','nama_kategori')->where('status',1)->get();
        $produk = Produk::get();
        return view ("produk.index",compact("kategori","produk"));
    }

    public function insert(Request $req)
    {
        Produk::create($req->except('_token'));
        return redirect ("/produk");
    }

    public function getProdukByKategori($id_kategori)
    {
        $produkByKategori = Produk::where("id_kategori",$id_kategori)->orderBy('nama_produk', 'asc')->get();
        return $produkByKategori;
    }

    public function getAllProduk()
    {
        $allProduk = Produk::orderBy('nama_produk', 'asc')->get();
        return $allProduk;
    }

    public function editProduk()
    {
        return view("produk.edit");
    }

    public function updateProduk()
    {
        $produk = Produk::find(request()->id_produk);

        //History Produk
        $hist_produk = new HistoryProduk;
        $hist_produk->harga_modal_before = $produk->harga_modal;
        $hist_produk->harga_jual_before = $produk->harga_jual;
        $hist_produk->harga_modal_after = request()->harga_modal;
        $hist_produk->harga_jual_after = request()->harga_jual;

        // Update Produk
        $produk->nama_produk = request()->nama_produk;
        $produk->distributor = request()->distributor;
        $produk->harga_jual = request()->harga_jual;
        $produk->harga_modal = request()->harga_modal;
        $produk->deskripsi = request()->deskripsi;

        //SAVE
        $produk->save();
        $hist_produk->save();

        // RETURN
        return response()->json([
            'message' => 'Data Berhasil Diubah'
        ]);
    }

    // KATEGORI
    public function kategori()
    {
        $kategori = Kategori::select('id','nama_kategori')->get();
        return view ("produk.kategori",compact("kategori"));
    }

    public function insertKategori(Request $req)
    {
        Kategori::create($req->except('_token'));
        return redirect("/produk/kategori");
    }

    public function stok(){
        return view("produk.stok");
    }

    public function addStok()
    {
        $produk = Produk::find(request()->id_produk);

        $before = $produk->stok;
        $add_stok = request()->tambah_stok;
        $after = $before + $add_stok;

        $hist_stok = new HistoryStok;
        $hist_stok->before = $before;
        $hist_stok->add_stok = $add_stok;
        $hist_stok->after = $after;

        $produk->stok = $after;

        $produk->save();
        $hist_stok->save();

        return response()->json([
            'message' => 'Tambah Stok Berhasil'
        ]);
    }
}

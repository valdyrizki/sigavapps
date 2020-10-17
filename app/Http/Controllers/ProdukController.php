<?php

namespace App\Http\Controllers;

use App\DetailProduk;
use App\HistoryProduk;
use App\HistoryStok;
use App\Kategori;
use App\Produk;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function getProdukByInput($input)
    {
        $produkByInput = Produk::where('nama_produk', 'LIKE', "%{$input}%")->orderBy('nama_produk', 'asc')->get();
        return $produkByInput;
    }

    public function getProdukByCategoryInput($id_kategori,$input)
    {
        $produkByCategoryInput = Produk::where('nama_produk', 'LIKE', "%{$input}%")->where("id_kategori",$id_kategori)->orderBy('nama_produk', 'asc')->get();
        return $produkByCategoryInput;
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
        $hist_produk->id_produk = request()->id_produk;
        $hist_produk->harga_modal_before = $produk->harga_modal;
        $hist_produk->harga_jual_before = $produk->harga_jual;
        $hist_produk->harga_modal_after = request()->harga_modal;
        $hist_produk->harga_jual_after = request()->harga_jual;
        $hist_produk->user = Auth::user()->email;


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
        $hist_stok->id_produk = request()->id_produk;
        $hist_stok->before = $before;
        $hist_stok->add_stok = $add_stok;
        $hist_stok->after = $after;
        $hist_stok->user = Auth::user()->email;

        $produk->stok = $after;

        $produk->save();
        $hist_stok->save();

        return response()->json([
            'message' => 'Tambah Stok Berhasil'
        ]);
    }

    // Add stock v2
    public function stokv2()
    {
        return view("produk.stokv2");
    }

    public function addStokv2()
    {


        $id = null;
        $data = request()->data;
        foreach ($data as $i=>$arr){
            if($id == null){
                $id = $arr['id_produk'];
            }
            try{
                DetailProduk::create([
                    'id_produk' => $arr['id_produk'],
                    'kode_produk' => $arr['kode_produk'],
                    'status' => 1
                ]);
            }catch(Exception $e){
                unset($data[$i]);
            }
        }

        $produk = Produk::find($id);
        $afterStok = $produk->stok+count($data);

        $hist_stok = new HistoryStok;
        $hist_stok->id_produk = $id;
        $hist_stok->before = $produk->stok;
        $hist_stok->add_stok = count($data);
        $hist_stok->after = $afterStok;
        $hist_stok->user = Auth::user()->email;

        $produk->stok = $afterStok;

        $produk->save();
        $hist_stok->save();

        return response()->json([
            'message' => 'Berhasil tambah detail produk'
        ]);
    }

    public function getProductByCode($code)
    {
        $product = DB::table('detail_produk')
            ->join('produk', 'detail_produk.id_produk', '=', 'produk.id')
            ->select('produk.id', 'produk.nama_produk', 'produk.harga_jual', 'produk.stok')
            ->where('detail_produk.kode_produk', $code)
            ->first();

        return response()->json([$product]);
    }
}

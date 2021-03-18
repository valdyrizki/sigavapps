<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function get()
    {
        $Kategori = Kategori::whereStatus(1)->get();
        return $Kategori;
    }
}

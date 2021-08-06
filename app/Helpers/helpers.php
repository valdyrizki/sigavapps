<?php

use Illuminate\Support\Facades\DB;

function generateMenu(){
    $parentMenu = DB::select('select id,name,url,icon,(SELECT count(id) from menu B where B.parent=A.id and B.status=1) AS count from menu A Where A.parent=0 and A.status=1 order by seq');
        // $parentMenu = Menu::select('id','name','url')->where('parent',0)->get();

        $menu = [];
        foreach ($parentMenu as $pm){
            $child = DB::select('select id,name,url,icon from menu where parent = ? and status=1 order by seq', [$pm->id]);

            if($child == null){
                $child = 0;
            }

            $m = [
                'id' => $pm->id,
                'name' => $pm->name,
                'url' => $pm->url,
                'icon' => $pm->icon,
                'child' => $child
            ];
            array_push($menu,$m);

        }

        return $menu;
}

function getRole($expression){
    $result = 'Kasir';
    switch ($expression){
        case 1:
        $result = 'Kasir';
        break;
        case 2:
        $result = 'Admin';
        break;
        case 99:
        $result = "Super Admin";
        break;
        default:
        $result = "Kasir";
    }
    return $result;
}

function getTrxCategoryName($expression){
    $result = 'Kasir';
    switch ($expression){
        case 1:
        $result = 'Kasir';
        break;
        case 2:
        $result = 'Admin';
        break;
        case 99:
        $result = "Super Admin";
        break;
        default:
        $result = "Kasir";
    }
    return $result;
}

function getTypeTrx($expression){
    $result = 'Kasir';
    switch ($expression){
        case 1:
        $result = 'Pemasukan';
        break;
        case 2:
        $result = 'Pengeluaran';
        break;
        default:
        $result = "Pemasukan";
    }
    return $result;
}

function getStsMemberName($expression){
    $result = 'Kasir';
    switch ($expression){
        case 1:
        $result = 'Aktif';
        break;
        case 9:
        $result = 'Tidak Aktif';
        break;
        default:
        $result = "Aktif";
    }
    return $result;
}

function formatRupiah($expression){
    return number_format($expression,0,',','.');
}

function getStsTF($expression){
    $result = 'Aktif';
    switch ($expression){
        case 1:
        $result = 'Aktif';
        break;
        case 2:
        $result = 'EOD';
        break;
        case 9:
        $result = 'Cancel';
        break;
        default:
        $result = "Aktif";
    }
    return $result;
}

function getStsHutang($expression){
    $result = 'Belum Lunas';
    switch ($expression){
        case 0:
        $result = 'Belum Lunas';
        break;
        case 1:
        $result = 'Lunas';
        break;
        default:
        $result = "Belum Lunas";
    }
    return $result;
}

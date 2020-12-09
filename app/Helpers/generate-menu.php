<?php

use Illuminate\Support\Facades\DB;

function generateMenu(){
    $parentMenu = DB::select('select id,name,url,icon,(SELECT count(id) from menu B where B.parent=A.id and B.status=1) AS count from menu A Where A.parent=0 and A.status=1');
        // $parentMenu = Menu::select('id','name','url')->where('parent',0)->get();

        $menu = [];
        foreach ($parentMenu as $pm){
            $child = DB::select('select id,name,url,icon from menu where parent = ? and status=1', [$pm->id]);

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



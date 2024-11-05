<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_controller extends Controller
{
    public function menu() {
        $menu = DB::table('code_menus')->orderBy('menu_id')->get();
        return $menu;
    }

    public function submenu() {
        $submenu = DB::table('code_submenus')->orderBy('menu', 'asc')->orderBy('sub_id', 'asc')->get();
        return $submenu;
    }

    public function addMenu(Request $request){
        $check = DB::table('code_menus')->where('name', $request->name);
        if ($check->count()){
            $success = false;
            $message = 'ລາຍການນີ້ມີຢູ່ໃນຖານຂໍ້ມູນແລ້ວ ກະລຸນາກວດຄືນ!';
        } else {

            // $datetime = now("Asia/Bangkok")->toDateTimeString();
            // $username = Str::lower(auth()->user()->username);

            $max = DB::table('code_menus')->max('menu_id');
            $newId = $max + 1;
            $id = substr(str_repeat(0, 2).$newId, - 2);

            DB::table('code_menus')
                ->insert([
                    'menu_id' => $id,
                    'menu' => "M".$id,
                    'name' => $request->name,
                    'descr' => $request->descr
                ]);

            $success = true;
            $message = "Insert completed!";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function addSubmenu(Request $request){
        $check = DB::table('code_submenus')
                    ->where('menu', $request->menu)
                    ->where('name', $request->name);
        if ($check->count()){
            $success = false;
            $message = 'ລາຍການນີ້ມີຢູ່ໃນຖານຂໍ້ມູນແລ້ວ ກະລຸນາກວດຄືນ!';
        } else {

            $max = DB::table('code_submenus')->where('menu', $request->menu)->max('sub_id');
            $newId = $max + 1;
            $id = substr(str_repeat(0, 2).$newId, - 2);

            DB::table('code_submenus')
                ->insert([
                    'menu' => $request->menu,
                    'sub_id' => $id,
                    'sub' => $request->menu.'S'.$id,
                    'name' => $request->name,
                    'descr' => $request->descr
                ]);

            $success = true;
            $message = "Insert completed!";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }
}

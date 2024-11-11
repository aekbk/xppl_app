<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_controller extends Controller
{
    // * Menu
    public function menu() {
        $menu = DB::table('lkp_menu')->orderBy('menu_code')->get();
        return $menu;
    }
    public function addMenu(Request $request){
        $check = DB::table('lkp_menu')->where('menu_name', $request->menu_name);
        if ($check->count()){
            $success = false;
            $message = 'ລາຍການນີ້ມີຢູ່ໃນຖານຂໍ້ມູນແລ້ວ ກະລຸນາກວດຄືນ!';
        } else {
            $max = DB::table('lkp_menu')->max('menu_id');
            $newId = $max + 1;
            $id = substr(str_repeat(0, 2).$newId, - 2);

            DB::table('lkp_menu')
            ->insert([
                'menu_id' => $id,
                'menu_code' => "M".$id,
                'menu_name' => $request->menu_name,
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
    public function updMenu(Request $request){
        DB::table('lkp_menu')
        ->where('menu_id', $request->menu_id)
        ->update([
            'menu_name' => $request->menu_name,
            'descr' => $request->descr
        ]);
    }
    public function delMenu(Request $request){
        $check = DB::table('lkp_menu_sub')->where('menu_code', $request->menu_code);
        if ($check->count()) {
            $success = false;
            $message = 'This menu has already been used; it cannot be deleted.';
        } else {

            DB::table('lkp_menu')->where('menu_code', $request->menu_code)->delete();

            $success = true;
            $message = "Delete completed.";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    // * Menu Sub
    public function menusub() {
        $sub = DB::table('lkp_menu_sub')->orderBy('menu_code', 'asc')->orderBy('sub_code', 'asc')->get();
        return $sub;
    }
    public function addMenusub(Request $request){
        $check = DB::table('lkp_menu_sub')
                    ->where('menu_code', $request->menu_code)
                    ->where('sub_name', $request->sub_name);
        if ($check->count()){
            $success = false;
            $message = 'ລາຍການນີ້ມີຢູ່ໃນຖານຂໍ້ມູນແລ້ວ ກະລຸນາກວດຄືນ!';
        } else {

            $max = DB::table('lkp_menu_sub')->where('menu_code', $request->menu_code)->max('sub_id');
            $newId = $max + 1;
            $id = substr(str_repeat(0, 2).$newId, - 2);

            DB::table('lkp_menu_sub')
                ->insert([
                    'sub_id' => $id,
                    'menu_code' => $request->menu_code,
                    'sub_code' => $request->menu_code.'S'.$id,
                    'sub_name' => $request->sub_name,
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
    public function updMenusub(Request $request){
        DB::table('lkp_menu_sub')
        ->where('sub_code', $request->sub_code)
        ->update([
            'sub_name' => $request->sub_name,
            'descr' => $request->descr
        ]);
    }
    public function delMenusub(Request $request){
        $check = DB::table('user_auth_submenus')->where('sub', $request->sub_code);
        if ($check->count()) {
            $success = false;
            $message = 'This submenu has already been used; it cannot be deleted.';
        } else {

            DB::table('lkp_menu_sub')->where('sub_code', $request->sub_code)->delete();

            $success = true;
            $message = "Delete completed.";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    // * Email
    public function email() {
        $email = DB::select('select * from user_email_registers order by email');
        return $email;
    }
    public function addEmail(Request $request){
        $check = DB::table('user_email_registers')->where('email', $request->email);
        if ($check->count()){
            $success = false;
            $message = 'This email already registered.';
        } else {

            $explo = explode('@', $request->email);
            $userName = $explo[0];

            DB::table('user_email_registers')
            ->insert([
                'email' => $request->email,
                'name' => $request->name,
                'surname' => $request->surname,
                'username' => $userName,
                'position' => $request->position,
                'dept' => $request->dept,
                'office' => $request->office,
                'phone' => $request->phone
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
    public function updEmail(Request $request){
        $check = DB::table('users')->where('email', $request->email_ori);
        if ($check->count()) {
            $success = false;
            $message = 'This email has already been used; it cannot be update.';
        } else {

            $explo = explode('@', $request->email);
            $userName = $explo[0];

            DB::table('user_email_registers')
            ->where('id', $request->id)
            ->update([
                'email' => $request->email,
                'name' => $request->name,
                'surname' => $request->surname,
                'username' => $userName,
                'position' => $request->position,
                'dept' => $request->dept,
                'office' => $request->office,
                'phone' => $request->phone
            ]);

            $success = true;
            $message = "Update completed.";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }
    public function delEmail(Request $request){
        $check = DB::table('users')->where('email', $request->email);
        if ($check->count()) {
            $success = false;
            $message = 'This email has already been used; it cannot be deleted.';
        } else {

            DB::table('user_email_registers')->where('id', $request->id)->delete();

            $success = true;
            $message = "Delete completed.";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }
}

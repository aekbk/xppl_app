<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class employee_controller extends Controller
{
    public function category() {
        $category = DB::select('select * from emp_category order by category');
        return $category;        
    }

    public function code() {
        $code = DB::select('select * from emp_codes order by category, code');
        return $code;        
    }

    public function department() {
        $department = DB::select('select * from lkp_departments order by company, department');
        return $department;        
    }

    public function province() {
        $province = DB::select('select * from lkp_province order by country, province');
        return $province;        
    }

    public function district() {
        $district = DB::select('select * from lkp_district order by province, district');
        return $district;        
    }

    public function village() {
        $village = DB::select('select * from lkp_village order by district, village');
        return $village;        
    }

    // public function roomZone() {
    //     $zone = DB::select('select * from lkp_room_zone order by camp, room_zone');
    //     return $zone;        
    // }

    // public function roomNumber() {
    //     $room = DB::select('select * from lkp_room_number order by room_zone, room_number');
    //     return $room;        
    // }

    public function addCode(Request $request){
        $check = DB::table('emp_codes')
                    ->where('category', $request->category)
                    ->where('code', $request->code);

        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database!';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('emp_codes')
                ->insert([
                    'category' => $request->category,
                    'code' => $request->code,
                    'descr_eng' => $request->descr_eng,
                    'descr_lao' => $request->descr_lao,
                    'active' => $request->active,
                    'created_at' => $datetime,
                    'created_by' => $username
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

    public function updCode(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('emp_codes')
            ->where('code_id', $request->code_id)
            ->update([
                'code' => $request->code,
                'descr_eng' => $request->descr_eng,
                'descr_lao' => $request->descr_lao,
                'active' => $request->active,
                'updated_at' => $datetime,
                'updated_by' => $username
            ]);

        $param = [
            $request->ori_code,
            $request->code,
            $request->tbl_name,
            $request->col_name
        ];
        DB::update('exec usp_code_update ?,?,?,?', $param);
    }

    public function delCode(Request $request){
        $check = DB::select('exec usp_code_delete ?,?,?', [$request->code, $request->tbl_name, $request->col_name]);
        if ($check) {
            $success = false;
            $message = 'ລາຍການນີ້ໄດ້ຖືກນຳໃຊ້ແລ້ວ ທ່ານບໍ່ສາມາດລົບໄດ້.';
        } else {

            DB::table('emp_codes')
                ->where('code_id', $request->code_id)
                ->delete();

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

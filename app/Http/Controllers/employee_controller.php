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

    public function room() {
        $room = DB::select('select * from emp_lkp_rooms order by camp, room_no');
        return $room;        
    }

    // =========== GENERAL CODE =============================================================
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
        
        // Update other related tables
        if ($request->code !== $request->code_ori) {
            $table = $request->tbl_name;
            $column = $request->col_name;

            DB::table($table)
            ->where($column, $request->code_ori)
            ->update([
                $column => $request->code
            ]);

            // if ($request->category === 'Company') {
            //     $tables = ['lkp_departments'];
            //     $column = 'company';
            // } elseif ($request->category === 'Country') {
            //     $tables = ['lkp_province', 'lkp_district', 'lkp_village'];
            //     $column = 'country';
            // };

            // if ($tables) {
            //     foreach($tables as $table) {
            //         DB::table($table)
            //         ->where($column, $request->code_ori)
            //         ->update([
            //             $column => $request->code
            //         ]);
            //     };
            // };
        };
    }
    public function delCode(Request $request){
        $check = DB::table($request->tbl_name)->where($request->col_name, $request->code);
        if ($check->count()) {
            $success = false;
            $message = 'This code has already been used; it cannot be deleted.';
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

    // =========== ROOM CODE =============================================================
    public function addRoom(Request $request){
        $check = DB::table('emp_lkp_rooms')
                ->where('camp_id', $request->camp_id)
                ->where('room_no', $request->room_no);
        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database.';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('emp_lkp_rooms')
            ->insert([
                'camp_id' => $request->camp_id,
                'room_no' => $request->room_no,
                'room_type' => $request->room_type,
                'capacity' => $request->capacity,
                'no_bed' => $request->no_bed,
                'remark' => $request->remark,
                'room_condition' => $request->room_condition,
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
    public function updRoom(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('emp_lkp_rooms')
        ->where('room_id', $request->room_id)
        ->update([
            'camp_id' => $request->camp_id,
            'room_no' => $request->room_no,
            'room_type' => $request->room_type,
            'capacity' => $request->capacity,
            'no_bed' => $request->no_bed,
            'remark' => $request->remark,
            'room_condition' => $request->room_condition,
            'updated_at' => $datetime,
            'updated_by' => $username
        ]);
    }
    public function delRoom(Request $request){
        DB::table('emp_lkp_rooms')->where('room_id', $request->room_id)->delete();
    }















}

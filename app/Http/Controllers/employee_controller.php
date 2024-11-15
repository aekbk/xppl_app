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

    public function company() {
        $company = DB::select('select * from lkp_companies order by company_eng');
        return $company;        
    }

    public function department() {
        $department = DB::select('select a.company_code, a.company_eng, b.* from dbo.lkp_companies a, lkp_departments b where b.company_id = a.company_id order by a.company_eng, b.department_eng');
        return $department;        
    }

    public function country() {
        $country = DB::select('select * from lkp_countries order by country_eng');
        return $country;        
    }

    public function province() {
        $province = DB::select('select a.country_eng, b.* from lkp_countries a, lkp_provinces b where a.country_id = b.country_id order by a.country_eng, b.province_eng');
        return $province;        
    }

    public function district() {
        $district = DB::select('select a.country_id, a.country_eng, b.province_eng, c.* from lkp_countries a, lkp_provinces b, lkp_districts c where a.country_id = b.country_id and b.province_id = c.province_id order by a.country_eng, b.province_eng, c.district_eng');
        return $district;        
    }

    public function village() {
        $village = DB::select('select a.country_id, a.country_eng, b.province_id, b.province_eng, c.district_eng, d.* from lkp_countries a, lkp_provinces b, lkp_districts c, lkp_villages d where a.country_id = b.country_id and b.province_id = c.province_id and c.district_id = d.district_id order by a.country_eng, b.province_eng, c.district_eng, d.village_eng');
        return $village;        
    }

    public function camp() {
        $camp = DB::select('select * from emp_lkp_camps order by camp_code');
        return $camp;        
    }

    public function room() {
        $room = DB::select('select a.camp_id, a.camp_code, b.* from emp_lkp_camps a, emp_lkp_rooms b where a.camp_id = b.camp_id order by a.camp_code, b.room_no');
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

    // =========== COMPANY CODE =============================================================
    public function addCompany(Request $request){
        $check = DB::table('lkp_companies')
                    ->where('company_code', $request->code);
        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database!';
        } else {
            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('lkp_companies')
            ->insert([
                'company_code' => $request->code,
                'company_eng' => $request->descr_eng,
                'company_lao' => $request->descr_lao,
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
    public function updCompany(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('lkp_companies')
            ->where('company_id', $request->code_id)
            ->update([
                'company_code' => $request->code,
                'company_eng' => $request->descr_eng,
                'company_lao' => $request->descr_lao,
                'active' => $request->active,
                'updated_at' => $datetime,
                'updated_by' => $username
            ]);
        
        // Update other related tables
        // if ($request->code !== $request->code_ori) {
        //     $table = $request->tbl_name;
        //     $column = $request->col_name;

        //     DB::table($table)
        //     ->where($column, $request->code_ori)
        //     ->update([
        //         $column => $request->code
        //     ]);

        //     if ($request->category === 'Company') {
        //         $tables = ['lkp_departments'];
        //         $column = 'company';
        //     } elseif ($request->category === 'Country') {
        //         $tables = ['lkp_province', 'lkp_district', 'lkp_village'];
        //         $column = 'country';
        //     };

        //     if ($tables) {
        //         foreach($tables as $table) {
        //             DB::table($table)
        //             ->where($column, $request->code_ori)
        //             ->update([
        //                 $column => $request->code
        //             ]);
        //         };
        //     };
        // };
    }
    public function delCompany(Request $request){
        DB::table('lkp_companies')->where('company_id', $request->code_id)->delete();
    }

    // =========== COUNTRY CODE =============================================================
    public function addCountry(Request $request){
        $check = DB::table('lkp_countries')
                    ->where('country_eng', $request->descr_eng);
        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database!';
        } else {
            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('lkp_countries')
            ->insert([
                'country_code' => $request->code,
                'country_eng' => $request->descr_eng,
                'country_lao' => $request->descr_lao,
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
    public function updCountry(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('lkp_countries')
            ->where('country_id', $request->code_id)
            ->update([
                'country_code' => $request->code,
                'country_eng' => $request->descr_eng,
                'country_lao' => $request->descr_lao,
                'active' => $request->active,
                'updated_at' => $datetime,
                'updated_by' => $username
            ]);
        
        // Update other related tables
        // if ($request->code !== $request->code_ori) {
        //     $table = $request->tbl_name;
        //     $column = $request->col_name;

        //     DB::table($table)
        //     ->where($column, $request->code_ori)
        //     ->update([
        //         $column => $request->code
        //     ]);

        //     if ($request->category === 'Company') {
        //         $tables = ['lkp_departments'];
        //         $column = 'company';
        //     } elseif ($request->category === 'Country') {
        //         $tables = ['lkp_province', 'lkp_district', 'lkp_village'];
        //         $column = 'country';
        //     };

        //     if ($tables) {
        //         foreach($tables as $table) {
        //             DB::table($table)
        //             ->where($column, $request->code_ori)
        //             ->update([
        //                 $column => $request->code
        //             ]);
        //         };
        //     };
        // };
    }
    public function delCountry(Request $request){
        DB::table('lkp_countries')->where('country_id', $request->code_id)->delete();
    }

    // =========== DEPARTMENT CODE =============================================================
    public function addDepartment(Request $request){
        $check = DB::table('lkp_departments')
                    ->where('company_id', $request->company_id)
                    ->where('department_eng', $request->department_eng);

        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database!';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('lkp_departments')
                ->insert([
                    'company_id' => $request->company_id,
                    'department_eng' => $request->department_eng,
                    'department_lao' => $request->department_lao,
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
    public function updDepartment(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('lkp_departments')
        ->where('department_id', $request->department_id)
        ->update([
            'company_id' => $request->company_id,
            'department_eng' => $request->department_eng,
            'department_lao' => $request->department_lao,
            'active' => $request->active,
            'updated_at' => $datetime,
            'updated_by' => $username
        ]);
    }
    public function delDepartment(Request $request){
        DB::table('lkp_departments')->where('department_id', $request->department_id)->delete();
    }

    // =========== PROVINCE CODE =============================================================
    public function addProvince(Request $request){
        $check = DB::table('lkp_provinces')
                    ->where('country_id', $request->country_id)
                    ->where('province_eng', $request->province_eng);

        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database!';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('lkp_provinces')
                ->insert([
                    'country_id' => $request->country_id,
                    'province_eng' => $request->province_eng,
                    'province_lao' => $request->province_lao,
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
    public function updProvince(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('lkp_provinces')
        ->where('province_id', $request->province_id)
        ->update([
            'country_id' => $request->country_id,
            'province_eng' => $request->province_eng,
            'province_lao' => $request->province_lao,
            'active' => $request->active,
            'updated_at' => $datetime,
            'updated_by' => $username
        ]);

        // This code is to delete from back end
        // if ($request->province !== $request->province_ori) {
        //     $updTable = ['emp_names', 'lkp_district', 'lkp_village'];
        //     foreach($updTable as $table) {
        //         DB::table($table)
        //         ->where('province', $request->province_ori)
        //         ->update([
        //             'province' => $request->province
        //         ]);
        //     };
        // };
    }
    public function delProvince(Request $request){
        // $check = DB::table('lkp_district')->where('province', $request->province);
        // if ($check->count()){
        //     $success = false;
        //     $message = 'This code has already been used; it cannot be deleted.';
        // } else {
            
        DB::table('lkp_provinces')->where('province_id', $request->province_id)->delete();
            
        //     $success = true;
        //     $message = "Delete completed.";
        // }
        // $response = [
        //     'success' => $success,
        //     'message' => $message
        // ];
        // return response()->json($response);
    }

    // =========== DISTRICT CODE =============================================================
    public function addDistrict(Request $request){
        $check = DB::table('lkp_districts')
                    ->where('province_id', $request->province_id)
                    ->where('district_eng', $request->district_eng);

        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database.';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('lkp_districts')
            ->insert([
                'province_id' => $request->province_id,
                'district_eng' => $request->district_eng,
                'district_lao' => $request->district_lao,
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
    public function updDistrict(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('lkp_districts')
        ->where('district_id', $request->district_id)
        ->update([
            'province_id' => $request->province_id,
            'district_eng' => $request->district_eng,
            'district_lao' => $request->district_lao,
            'active' => $request->active,
            'updated_at' => $datetime,
            'updated_by' => $username
        ]);
    }
    public function delDistrict(Request $request){
        DB::table('lkp_districts')->where('district_id', $request->district_id)->delete();
    }

    // =========== VILLAGE CODE =============================================================
    public function addVillage(Request $request){
        $check = DB::table('lkp_villages')
                    ->where('district_id', $request->district_id)
                    ->where('village_eng', $request->village_eng);

        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database.';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('lkp_villages')
            ->insert([
                'district_id' => $request->district_id,
                'village_eng' => $request->village_eng,
                'village_lao' => $request->village_lao,
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
    public function updVillage(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('lkp_villages')
        ->where('village_id', $request->village_id)
        ->update([
            'district_id' => $request->district_id,
            'village_eng' => $request->village_eng,
            'village_lao' => $request->village_lao,
            'active' => $request->active,
            'updated_at' => $datetime,
            'updated_by' => $username
        ]);
    }
    public function delVillage(Request $request){
        DB::table('lkp_villages')->where('village_id', $request->village_id)->delete();
    }

    // =========== CAMP CODE =============================================================
    public function addCamp(Request $request){
        $check = DB::table('emp_lkp_camps')->where('camp_code', $request->code);
        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database.';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('emp_lkp_camps')
            ->insert([
                'camp_code' => $request->code,
                'camp_eng' => $request->descr_eng,
                'camp_lao' => $request->descr_lao,
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
    public function updCamp(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('emp_lkp_camps')
        ->where('camp_id', $request->code_id)
        ->update([
            'camp_code' => $request->code,
            'camp_eng' => $request->descr_eng,
            'camp_lao' => $request->descr_lao,
            'active' => $request->active,
            'updated_at' => $datetime,
            'updated_by' => $username
        ]);
    }
    public function delCamp(Request $request){
        DB::table('emp_lkp_camps')->where('camp_id', $request->code_id)->delete();
    }
}

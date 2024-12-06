<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class clinic_controller extends Controller
{
    public function category() {
        $category = DB::select('select * from clinic_category order by category');
        return $category;
    }
    public function code() {
        $code = DB::select('select * from clinic_codes order by category, code');
        return $code;
    }

    public function addCode(Request $request){
        $check = DB::table('clinic_codes')
                ->where('category', $request->category)
                ->where('code', $request->code);

        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database!';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('clinic_codes')
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

    public function updateCode(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('clinic_codes')
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
        if ($request->code !== $request->code_old && $request->tbl_name) {
            DB::table($request->tbl_name)
                ->where($request->col_name, $request->code_old)
                ->update([$request->col_name => $request->code]);
        }
    }

    public function deleteCode(Request $request){
        $check = DB::table($request->tbl_name)->where($request->col_name, $request->code);
        if ($check->count()) {
            $success = false;
            $message = 'This code has already been used; it cannot be deleted.';
        } else {

            DB::table('clinic_codes')->where('code_id', $request->code_id)->delete();

            $success = true;
            $message = "Delete completed.";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function medicine() {
        $medicine = DB::select('select a.*, b.descr_eng as unit_eng, b.descr_lao as unit_lao from clinic_medicines a, clinic_codes b where b.code_id = a.unit_id order by a.medicine_eng');
        return $medicine;        
    }

    public function addMedicine(Request $request){
        $check = DB::table('clinic_medicines')->where('medicine_eng', $request->medicine_eng);
        if ($check->count()){
            $success = false;
            $message = 'This medicine already exists in the database!';
        } else {

            DB::table('clinic_medicines')
                ->insert([
                    'medicine_eng' => $request->medicine_eng,
                    'medicine_lao' => $request->medicine_lao,
                    'descr' => $request->descr,
                    'unit_id' => $request->unit_id,
                    'unit_price' => $request->unit_price,
                    'min_remind' => $request->min_remind,
                    'created_at' => now('Asia/Bangkok')->toDateTimeString(),
                    'created_by' => auth()->user()->username,
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

    public function updateMedicine(Request $request){
        DB::table('clinic_medicines')
            ->where('medicine_id', $request->medicine_id)
            ->update([
                'medicine_eng' => $request->medicine_eng,
                'medicine_lao' => $request->medicine_lao,
                'descr' => $request->descr,
                'unit_id' => $request->unit_id,
                'unit_price' => $request->unit_price,
                'min_remind' => $request->min_remind,
                'updated_at' => now('Asia/Bangkok')->toDateTimeString(),
                'updated_by' => auth()->user()->username,
        ]);
    }

    public function deleteMedicine(Request $request){
        $check = DB::table('clinic_medications')->where('medicine_id', $request->medicine_id);
        if ($check->count()) {
            $success = false;
            $message = 'This medicine has already been used; it cannot be deleted.';
        } else {

            DB::table('clinic_medicines')->where('medicine_id', $request->medicine_id)->delete();

            $success = true;
            $message = "Delete completed.";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function addPatient(Request $request){

        $check = DB::table('clinic_patients')->where('patient_name', $request->patient_name);

        if ($check->count()){
            $success = false;
            $message = 'This name already exists in the database!';
        } else {

            $datetime = now("Asia/Bangkok")->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            $pMax = DB::table('clinic_patients')->max('patient_id');
            $pId = $pMax + 1;

            // DB::table('cs_contracts')
            //     ->insert([
            //         'contract_id' => $newId,
            //         'customer_id' => $request->customer_id,
            //         'contract_no' => $request->contract_no,
            //         'contract_quantity' => $request->contract_quantity,
            //         'contract_grade_id' => $request->contract_grade_id,
            //         'contract_appendix' => $request->contract_appendix,
            //         'signed_date' => $request->signed_date,
            //         'loading_place' => $request->loading_place,
            //         'delivery_place' => $request->delivery_place,
            //         'contract_status' => $request->contract_status,
            //         'contract_remark' => $request->contract_remark,
            //         'created_at' => $datetime,
            //         'created_by' => $username
            //     ]);

            //Order list
            // DB::table('cs_orders')
            // ->insert([
            //     'contract_id' => $newId,
            //     'order_date' => $request->signed_date,
            //     'grade_id' => $request->grade_id,
            //     'quantity' => $request->quantity,
            //     'initial_price' => $request->initial_price,
            //     'currency' => $request->currency,
            //     'vat_remark' => $request->vat_remark,
            //     'price_term' => $request->price_term,
            //     'order_appendix' => $request->order_appendix,
            //     'co_number' => $request->co_number,
            //     'order_status' => $request->order_status,
            //     'order_remark' => $request->order_remark,
            //     'created_at' => $datetime,
            //     'created_by' => $username
            // ]);

            //Attachments
            // if ($request->hasFile('files')) {
            //     foreach ($request->file('files') as $file) {
            //         $fileName = $newId.'-'.$file->getClientOriginalName();
            //         $file->move(public_path('assets/images/contracts/'), $fileName);
            //         $fileSize = (round(filesize(public_path('assets/images/contracts/'.$fileName))/1024,0)).' KB';

            //         DB::table('cs_contract_files')
            //         ->insert([
            //             'contract_id' => $newId,
            //             'file_name' => $file->getClientOriginalName(),
            //             'file_type' => strtolower($file->getClientOriginalExtension()),
            //             'new_name' => $fileName,
            //             'size' => $fileSize
            //         ]); 
            //     }
            // }

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
 
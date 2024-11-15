<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Exports\SaleExport;
use Maatwebsite\Excel\Facades\Excel;

class sale_controller extends Controller
{
    public function code() {
        $code = DB::table('cs_codes')
                    ->orderBy('category', 'asc')
                    ->orderBy('code', 'asc')
                    ->get();
        return $code;
    }

    public function addCode(Request $request){
        $check = DB::table('cs_codes')
                    ->where('category', $request->category)
                    ->where('code', $request->code);

        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database!';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('cs_codes')
                ->insert([
                    'category' => $request->category,
                    'code' => $request->code,
                    'descr' => $request->descr,
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
        
        DB::table('cs_codes')
            ->where('code_id', $request->code_id)
            ->update([
                'descr' => $request->descr,
                'active' => $request->active,
                'updated_at' => $datetime,
                'updated_by' => $username
            ]);
    }

    public function delCode(Request $request){
        // $check = DB::table("cs_codes")
        //             ->where("code", $request->code);

        // if ($check->count()){
        //     $success = false;
        //     $message = 'ລາຍການນີ້ໄດ້ຖືກນຳໃຊ້ແລ້ວ ທ່ານບໍ່ສາມາດລົບໄດ້!';
        // } else {
      
            DB::table('cs_codes')
                ->where('code_id', $request->id)
                ->delete();

        //     $success = true;
        //     $message = "Delete completed!";
        // }
        // $response = [
        //     'success' => $success,
        //     'message' => $message
        // ];
        // return response()->json($response);
    }

    public function grade() {
        $grade = DB::table('cs_grades')
                    ->orderBy('grade_type', 'asc')
                    ->orderBy('grade', 'asc')
                    ->get();
        return $grade;
    }

    public function addGrade(Request $request){
        $check = DB::table('cs_grades')
                    ->where('grade_name', $request->grade_name);

        if ($check->count()){
            $success = false;
            $message = 'This grade name already exists in the database!';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);
            $max = DB::table('cs_grades')->max('grade_id');
            $newId = $max + 1;

            DB::table('cs_grades')
                ->insert([
                    'grade_id' => $newId,
                    'grade' => $request->grade,
                    'grade_type' => $request->grade_type,
                    'grade_name' => $request->grade_name,
                    'grade_gar' => $request->grade_gar,
                    'descr' => $request->descr,
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

    public function updGrade(Request $request){
        // $check = DB::table("cs_grades")
        //             ->where("grade_name", $request->grade_name);

        // if ($check->count()){
        //     $success = false;
        //     $message = 'ລາຍການນີ້ໄດ້ຖືກນຳໃຊ້ແລ້ວ ທ່ານບໍ່ສາມາດແກ້ໄຂໄດ້!';
        // } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);
        
            DB::table('cs_grades')
                ->where('grade_id', $request->grade_id)
                ->update([
                    'grade' => $request->grade,
                    'grade_type' => $request->grade_type,
                    'grade_name' => $request->grade_name,
                    'grade_gar' => $request->grade_gar,
                    'descr' => $request->descr,
                    'active' => $request->active,
                    'updated_at' => $datetime,
                    'updated_by' => $username
                ]);

        //     $success = true;
        //     $message = "Delete completed!";
        // }
        // $response = [
        //     'success' => $success,
        //     'message' => $message
        // ];
        // return response()->json($response);
    }

    public function delGrade(Request $request){
        // $check = DB::table('cs_grades')
        //             ->where("grade_name", $request->gradeName);

        // if ($check->count()){
        //     $success = false;
        //     $message = 'ລາຍການນີ້ໄດ້ຖືກນຳໃຊ້ແລ້ວ ທ່ານບໍ່ສາມາດແກ້ໄຂໄດ້!';
        // } else {

            DB::table('cs_grades')
                ->where('grade_name', $request->gradeName)
                ->delete();

        //     $success = true;
        //     $message = "Delete completed!";
        // }
        // $response = [
        //     'success' => $success,
        //     'message' => $message
        // ];
        // return response()->json($response);
    }

    public function customer() {
        $customer = DB::table('cs_customers')->orderBy('customer_name', 'asc')->get();
        return $customer;
    }

    public function addCustomer(Request $request){
        $check = DB::table('cs_customers')
                    ->where('customer_name', $request->customer_name);

        if ($check->count()){
            $success = false;
            $message = 'This customer already exists in the database!';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);
            $max = DB::table('cs_customers')->max('customer_id');
            $newId = $max + 1;

            DB::table('cs_customers')
                ->insert([
                    'customer_id' => $newId,
                    'customer_code' => $request->customer_code,
                    'customer_name' => $request->customer_name,
                    'full_address' => $request->full_address,
                    'country' => $request->country,
                    'destination' => $request->destination,
                    'tax_code' => $request->tax_code,
                    'contract' => $request->contract,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'remarks' => $request->remarks,
                    'created_at' => $datetime,
                    'created_by' => $username
                ]);

            //add attachments
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileName = $newId.'-'.$file->getClientOriginalName();
                    $file->move('assets/images/customers/', $fileName);
                    $fileSize = (round(filesize('assets/images/customers/'.$fileName)/1024,0)).' KB';

                    DB::table('cs_customer_files')
                    ->insert([
                        'customer_id' => $newId,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => strtolower($file->getClientOriginalExtension()),
                        'new_name' => $fileName,
                        'size' => $fileSize
                    ]); 
                }
            }

            $success = true;
            $message = 'Insert completed!';
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function updCustomer(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);

        DB::table('cs_customers')
            ->where('customer_id', $request->customer_id)
            ->update([
                'customer_code' => $request->customer_code,
                'customer_name' => $request->customer_name,
                'full_address' => $request->full_address,
                'country' => $request->country,
                'destination' => $request->destination,
                'tax_code' => $request->tax_code,
                'contract' => $request->contract,
                'phone' => $request->phone,
                'email' => $request->email,
                'remarks' => $request->remarks,
                'updated_at' => $datetime,
                'updated_by' => $username
            ]);
    }

    public function delCustomer(Request $request){
        $check = DB::table('cs_contracts')
                    ->where('customer_id', $request->id);

        if ($check->count()){
            $success = false;
            $message = "Can't delete since this customer is already in the contracts table!";
        } else {

            DB::table('cs_customers')->where('customer_id', $request->id)->delete();
            DB::table('cs_customer_files')->where('customer_id', $request->id)->delete();

            foreach($request->listFile as $list) {
                if(file_exists('assets/images/customers/'.$list['new_name'])){
                    unlink('assets/images/customers/'.$list['new_name']);
                }
            }
            
            $success = true;
            $message = 'Insert completed!';
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function customerFile() {
        $customerFile = DB::table('cs_customer_files')
                            ->orderBy('customer_id', 'asc')
                            ->orderBy('file_name', 'asc')
                            ->get();
        return $customerFile;
    }

    public function addCustomerFile(Request $request) {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $fileName = $request->customer_id.'-'.$file->getClientOriginalName();
                $file->move('assets/images/customers/', $fileName);
                $fileSize = (round(filesize('assets/images/customers/'.$fileName)/1024,0)).' KB';

                DB::table('cs_customer_files')
                ->insert([
                    'customer_id' => $request->customer_id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => strtolower($file->getClientOriginalExtension()),
                    'new_name' => $fileName,
                    'size' => $fileSize
                ]); 
            }
        }  
    }

    public function delCustomerFile(Request $request){
        DB::table('cs_customer_files')->where('file_id', $request->id)->delete();

        if(file_exists('assets/images/customers/'.$request->file)){
            unlink('assets/images/customers/'.$request->file);
        }
    }

    public function downloadCustomerFile($file){
        return response()->download('assets/images/customers/'.$file);
    }

    public function contract() {
        // $contract = DB::select('select a.customer_name, a.country, a.destination, a.full_address, a.tax_code, a.contract, a.phone, a.email, a.customer_code, a.remarks, c.grade_name as contract_grade_name, c.grade_GAR as contract_grade_gar, b.* from cs_customers a, cs_contracts b LEFT JOIN dbo.cs_grades c on c.grade_id = b.contract_grade_id where a.customer_id = b.customer_id order by b.signed_date, a.customer_name');
        $contract = DB::table('cs_customers as a')
                        ->join('cs_contracts as b', 'a.customer_id', 'b.customer_id')
                        ->leftJoin('cs_grades as c', 'b.contract_grade_id', 'c.grade_id')
                        ->select('a.customer_name', 'a.country', 'a.destination', 'a.full_address', 'a.tax_code', 'a.contract', 'a.phone', 'a.email', 'a.customer_code', 'a.remarks', 'c.grade_name as contract_grade_name', 'c.grade_gar as contract_grade_gar', 'b.*')
                        ->orderBy('b.signed_date', 'asc')
                        ->orderBy('a.customer_name', 'asc')
                        ->get();
        return $contract;
    }

    public function addContract(Request $request){
        $check = DB::table('cs_contracts')->where('contract_no', $request->contract_no);

        if ($check->count()){
            $success = false;
            $message = 'This contract already exists in the database!';
        } else {

            $datetime = now("Asia/Bangkok")->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            $max = DB::table('cs_contracts')->max('contract_id');
            $newId = $max + 1;

            DB::table('cs_contracts')
                ->insert([
                    'contract_id' => $newId,
                    'customer_id' => $request->customer_id,
                    'contract_no' => $request->contract_no,
                    'contract_quantity' => $request->contract_quantity,
                    'contract_grade_id' => $request->contract_grade_id,
                    'contract_appendix' => $request->contract_appendix,
                    'signed_date' => $request->signed_date,
                    'loading_place' => $request->loading_place,
                    'delivery_place' => $request->delivery_place,
                    'contract_status' => $request->contract_status,
                    'contract_remark' => $request->contract_remark,
                    'created_at' => $datetime,
                    'created_by' => $username
                ]);

            //Order list
            DB::table('cs_orders')
            ->insert([
                'contract_id' => $newId,
                'order_date' => $request->signed_date,
                'grade_id' => $request->grade_id,
                'quantity' => $request->quantity,
                'initial_price' => $request->initial_price,
                'currency' => $request->currency,
                'vat_remark' => $request->vat_remark,
                'price_term' => $request->price_term,
                'order_appendix' => $request->order_appendix,
                'co_number' => $request->co_number,
                'order_status' => $request->order_status,
                'order_remark' => $request->order_remark,
                'created_at' => $datetime,
                'created_by' => $username
            ]);

            //Attachments
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileName = $newId.'-'.$file->getClientOriginalName();
                    $file->move('assets/images/contracts/', $fileName);
                    $fileSize = (round(filesize('assets/images/contracts/'.$fileName)/1024,0)).' KB';

                    DB::table('cs_contract_files')
                    ->insert([
                        'contract_id' => $newId,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => strtolower($file->getClientOriginalExtension()),
                        'new_name' => $fileName,
                        'size' => $fileSize
                    ]); 
                }
            }

            $success = true;
            $message = "Insert completed!";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function updContract(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);

        DB::table('cs_contracts')
            ->where('contract_id', $request->contract_id)
            ->update([
                'customer_id' => $request->customer_id,
                'contract_no' => $request->contract_no,
                'contract_quantity' => $request->contract_quantity,
                'contract_grade_id' => $request->contract_grade_id,
                'contract_appendix' => $request->contract_appendix,
                'signed_date' => $request->signed_date,
                'loading_place' => $request->loading_place,
                'delivery_place' => $request->delivery_place,
                'contract_status' => $request->contract_status,
                'hide' => $request->hide,
                'contract_remark' => $request->contract_remark,
                'updated_at' => $datetime,
                'updated_by' => $username
            ]);
    }

    public function delContract(Request $request){
        DB::table('cs_contracts')->where('contract_id', $request->contract_id)->delete();
        DB::table('cs_orders')->where('contract_id', $request->contract_id)->delete();
        DB::table('cs_contract_files')->where('contract_id', $request->contract_id)->delete();

        foreach($request->fileList as $list) {
            if(file_exists('assets/images/contracts/'.$list['new_name'])){
                unlink('assets/images/contracts/'.$list['new_name']);
            };
        };   
    }

    public function order() {
        $order = DB::table('cs_orders as a')
                    ->join('cs_grades as b', 'a.grade_id', 'b.grade_id')
                    ->select('a.*', 'b.grade_name', 'b.grade_gar')
                    ->orderBy('a.contract_id', 'asc')
                    ->orderBy('a.order_date', 'asc')
                    ->get();
        return $order;
    }

    public function addOrder(Request $request){
        $check = DB::table('cs_orders')
                    ->where('contract_id', $request->contract_id)
                    ->where('order_date', $request->order_date)
                    ->where('grade_id', $request->grade_id);

        if ($check->count()){
            $success = false;
            $message = 'Duplicates record';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('cs_orders')
            ->insert([
                'contract_id' => $request->contract_id,
                'order_date' => $request->order_date,
                'grade_id' => $request->grade_id,
                'quantity' => $request->quantity,
                'initial_price' => $request->initial_price,
                'currency' => $request->currency,
                'vat_remark' => $request->vat_remark,
                'price_term' => $request->price_term,
                'co_number' => $request->co_number,
                'order_appendix' => $request->order_appendix,
                'order_status' => $request->order_status,
                'order_remark' => $request->order_remark,
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

    public function updOrder(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);

        DB::table('cs_orders')
        ->where('order_id', $request->order_id)
        ->update([
            'order_date' => $request->order_date,
            'grade_id' => $request->grade_id,
            'quantity' => $request->quantity,
            'initial_price' => $request->initial_price,
            'currency' => $request->currency,
            'vat_remark' => $request->vat_remark,
            'price_term' => $request->price_term,
            'co_number' => $request->co_number,
            'order_appendix' => $request->order_appendix,
            'order_status' => $request->order_status,
            'order_remark' => $request->order_remark,
            'updated_at' => $datetime,
            'updated_by' => $username
        ]);
    }

    public function delOrder(Request $request) {
        DB::table('cs_orders')
            ->where('order_id', $request->id)
            ->delete();
    }

    public function contractFile() {
        $contractFile = DB::table('cs_contract_files')
                            ->orderBy('contract_id', 'asc')
                            ->orderBy('file_name', 'asc')
                            ->get();
        return $contractFile;
    }

    public function addContractFile(Request $request) {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $fileName = $request->contract_id.'-'.$file->getClientOriginalName();
                $file->move('assets/images/contracts/', $fileName);
                $fileSize = (round(filesize('assets/images/contracts/'.$fileName)/1024,0)).' KB';

                DB::table('cs_contract_files')
                ->insert([
                    'contract_id' => $request->contract_id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => strtolower($file->getClientOriginalExtension()),
                    'new_name' => $fileName,
                    'size' => $fileSize
                ]); 
            }
        }  
    }

    public function delContractFile(Request $request){
        DB::table('cs_contract_files')->where('file_id', $request->id)->delete();

        if(file_exists('assets/images/contracts/'.$request->file)){
            unlink('assets/images/contracts/'.$request->file);
        }
    }

    public function downloadContractFile($file){
        return response()->download('assets/images/contracts/'.$file);
    }

    public function saleYear() {
        $year = DB::table('dbo.utf_cs_sale_datas()')
                    ->distinct()
                    ->select('y as value', 'y as label') 
                    ->orderBy('y', 'desc')
                    ->get();
        return $year;
    }

    public function saleData(Request $request) {
        $by = $request->by;
        $value = $request->value;

        if ($by == 'd') {
            $sales = DB::select('select * from dbo.utf_cs_sale_datas() where [date]= ? order by [date], dateOut', [$value]);
            return $sales;
        } elseif ($by == 'm') {
            $sales = DB::select("select * from dbo.utf_cs_sale_datas() where format([date],'yyyy-MM') = ? order by [date], dateOut", [$value]);
            return $sales;
        } elseif ($by == 'y') {
            $sales = DB::select("select * from dbo.utf_cs_sale_datas() where y = ? order by [date], dateOut", [$value]);
            return $sales;
        } else {
            $sales = DB::select("select * from dbo.utf_cs_sale_datas() where [date] between ? and ? order by [date], dateOut", [$request->dateFr, $request->dateTo]);
            return $sales;
        }

    }

    public function saleDataExport() {
        
        $filename = 'Sales Data.xlsx';
        return Excel::download(new SaleExport, $filename);
        
    }


}

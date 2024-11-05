<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class geology_controller extends Controller
{
    public function sampleTicket() {
        $sampleid = DB::select('select * from geo_sample_tickets order by item, sample_id desc');
        return $sampleid;
    }

    public function addSampleTicket(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);

        foreach($request->list as $lst) {
            DB::table('geo_sample_tickets')
            ->insert([
                'item' => $request->item,
                'sample_id' => $lst['sample_id'],
                'status' => 0,
                'created_at' => $datetime,
                'created_by' => $username,
            ]);
        }

        $success = true;
        $message = "Insert completed!";

        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function delSampleTicket (Request $request) {
        DB::table('geo_sample_tickets')->whereBetween('sample_id', [$request->from, $request->to])->delete();
    }

    public function updSampleTicket(Request $request) {
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);

        DB::table('geo_sample_tickets')
            ->whereBetween('sample_id', [$request->from, $request->to])
            ->update([
                'status' => 1,
                'printed1_at' => $datetime,
                'printed1_by' => $username
            ]);
         
    }





    public function getSaleData(Request $request) {
        $data = DB::select('select * from cs_sale_datas where date between ? and ?', [$request->datefrom, $request->dateto]);
        return response()->json($data);
    }


}

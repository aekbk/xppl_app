<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dash_sale_controller extends Controller
{
    public function dashboard1(Request $request) {
        $dash1 = DB::select('exec dbo.usp_sale_dashboard1 ?', [$request->date]);
        return response()->json($dash1);
    }

    public function dashboard2(Request $request) {
        $dash2 = DB::select('exec dbo.usp_sale_dashboard2 ?', [$request->date]);
        return response()->json($dash2);
    }

    public function dashboard3(Request $request) {
        $dash3 = DB::select('exec dbo.usp_sale_dashboard3 ?', [$request->year]);
        return response()->json($dash3);
    }

    public function dashboard4(Request $request) {
        $dash4 = DB::select('exec dbo.usp_sale_dashboard4 ?', [$request->date]);
        return response()->json($dash4);
    }

    public function dashboard5(Request $request) {
        $dash5 = DB::select('exec dbo.usp_sale_dashboard5 ?', [$request->date]);
        return response()->json($dash5);
    }

    public function dashboard6(Request $request) {
        $dash6 = DB::select('exec dbo.usp_sale_dashboard6 ?', [$request->date]);
        return response()->json($dash6);
    }

    public function dashboard7(Request $request) {
        $dash7 = DB::select('exec dbo.usp_sale_dashboard7 ?', [$request->date]);
        return response()->json($dash7);
    }

    public function dashboard8(Request $request) {
        $dash8 = DB::select("select concat(Grade_GAR, ' GAR') as grade, count(DataId) as trip, sum(NetWeight)/1000 as ton from dbo.utf_sale_datas() where [Date] = ? and DestPort = 'domestic' group by Grade_GAR order by Grade_GAR", [$request->date]);
        return $dash8;
    }

    public function dashboard9(Request $request) {
        $dash9 = DB::select("select concat(Grade_GAR, ' GAR') as grade, count(DataId) as trip, sum(NetWeight)/1000 as ton from dbo.utf_sale_datas() where [Date] = ? and DestPort = 'oversea' group by Grade_GAR order by Grade_GAR", [$request->date]);
        return $dash9;
    }

    public function dashboard10(Request $request) {
        $dash10 = DB::select('exec dbo.usp_sale_dashboard8 ?, ?', [$request->dateFr, $request->dateTo]);
        return response()->json($dash10);
    }

    public function hideContract(Request $request) {
        DB::table('sale_contracts')
        ->where('contract_id', $request->id)
        ->update([
            'hide' => 1
        ]);
    }

    public function lastDate() {
        $lastDate = DB::select('select convert(nvarchar(10), max(Date),23) as lastDate, convert(nvarchar(20), max(DateOut), 8) as lastTime from dbo.utf_sale_datas()');
        return $lastDate;        
    }
    
}

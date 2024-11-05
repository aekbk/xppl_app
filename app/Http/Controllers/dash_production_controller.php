<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dash_production_controller extends Controller
{   
    public function lastDate() {
        $lastDate = DB::select('select convert(nvarchar(10), max(mined_date),23) as lastDate from [XPPL-DBGEO\DBGEO].XPPL_PRODUCTION.dbo.mine_productions');
        return $lastDate;        
    }
    
    public function dashboard1(Request $request) {
        $dash1 = DB::select('exec dbo.usp_prod_deshboard1 ?', [$request->date]);
        return response()->json($dash1);
    }

    public function dashboard2(Request $request) {
        $dash2 = DB::select('exec dbo.usp_prod_deshboard2 ?', [$request->date]);
        return response()->json($dash2);
    }

    public function dashboard3(Request $request) {
        $dash3 = DB::select('exec dbo.usp_prod_deshboard3 ?', [$request->date]);
        return response()->json($dash3);
    }

    public function dashboard4(Request $request) {
        $dash4 = DB::select('exec dbo.usp_prod_deshboard4 ?', [$request->year]);
        return response()->json($dash4);
    }

    public function dashboard5(Request $request) {
        $dash5 = DB::select('exec dbo.usp_prod_deshboard5 ?', [$request->date]);
        return response()->json($dash5);
    }

    public function dashboard6(Request $request) {
        $dash6 = DB::select('exec dbo.usp_prod_deshboard6 ?', [$request->date]);
        return response()->json($dash6);
    }

    public function dashboard7(Request $request) {
        $dash7 = DB::select('exec dbo.usp_prod_deshboard7 ?, ?', [$request->dateFr, $request->dateTo]);
        return response()->json($dash7);
    }

}

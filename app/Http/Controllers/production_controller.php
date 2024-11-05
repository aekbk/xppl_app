<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class production_controller extends Controller
{
    public function mineProductionData(Request $request) {

        $getBy = $request->getBy;
        $value = $request->value;

        if ($getBy == 'd') {
            $prodGeo = DB::select('select * from [XPPL-DBGEO\DBGEO].XPPL_PRODUCTION.dbo.mine_productions where mined_date = ? order by data_id', [$value]);
        } elseif ($getBy == 'm') {
            $explo = explode('-', $request->value);
            $y = $explo[0];
            $m = $explo[1];
            $prodGeo = DB::select("select * from [XPPL-DBGEO\DBGEO].XPPL_PRODUCTION.dbo.mine_productions where year(mined_date) = ? and month(mined_date) = ? order by data_id, mined_date", [$y, $m]);
        } elseif ($getBy == 'y') {
            $prodGeo = DB::select("select * from [XPPL-DBGEO\DBGEO].XPPL_PRODUCTION.dbo.mine_productions where year(mined_date) = ? order by data_id, mined_date", [$value]);
        } else {
            $prodGeo = DB::select("select * from [XPPL-DBGEO\DBGEO].XPPL_PRODUCTION.dbo.mine_productions where mined_date between ? and ? order by data_id, mined_date", [$request->dateFr, $request->dateTo]);        
        }

        return $prodGeo;
    }

    public function mineYear() {
        $year = DB::select('select year(mined_date) as value, year(mined_date) as label from [XPPL-DBGEO\DBGEO].XPPL_PRODUCTION.dbo.mine_productions group by year(mined_date) order by year(mined_date) desc');
        return $year;
    } 
    
    public function report1(Request $request) {
        $report1 = DB::select('exec dbo.usp_prod_report1 ?, ?', [$request->dateFr, $request->dateTo]);
        return response()->json($report1);
    }

    
}

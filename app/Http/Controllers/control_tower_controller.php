<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class control_tower_controller extends Controller
{
  public function mining_data(Request $request)
    {
        // Retrieve query string parameters with default values
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        // Validate the input
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Fetch data from the database
        $mining_data = DB::select("
            SELECT 
                date,
                SUM(coal_actual_kt) AS total_coal_actual_kt,
                SUM(coal_plan_kt) AS total_coal_plan_kt
            FROM ct_coal_production
            WHERE date >= ? AND date < ?
            GROUP BY date
            ORDER BY date;
        ", [$start_date, $end_date]);

        // Return the data as JSON response
        return response()->json($mining_data);
    }

    public function processing_data(Request $request)
    {
        // Retrieve query string parameters with default values
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        // Validate the input
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Fetch data from the database
        $mining_data = DB::select("
            SELECT 
                date,
                SUM(coal_actual_kt) AS total_coal_actual_kt,
                SUM(coal_plan_kt) AS total_coal_plan_kt
            FROM ct_coal_production
            WHERE date >= ? AND date < ?
            GROUP BY date
            ORDER BY date;
        ", [$start_date, $end_date]);

        // Return the data as JSON response
        return response()->json($mining_data);
    }
}

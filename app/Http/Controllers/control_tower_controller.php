<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class control_tower_controller extends Controller
{
    public function mining_detail(Request $request)
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
            SELECT *
            FROM ct_coal_production
            WHERE date >= ? AND date <= ?;
        ", [$start_date, $end_date]);

        // Return the data as JSON response
        return response()->json($mining_data);
    }

    public function processing_detail(Request $request)
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
        $processing_data = DB::select("
            SELECT *
            FROM ct_plant_processing
            WHERE date >= ? AND date <= ?
        ", [$start_date, $end_date]);

        // Return the data as JSON response
        return response()->json($processing_data);
    }

    public function sales_logistics_detail(Request $request)
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
        $sales_logistics_data = DB::select("
            SELECT *
            FROM ct_sales_logistics
            WHERE date >= ? AND date <= ?
        ", [$start_date, $end_date]);

        // Return the data as JSON response
        return response()->json($sales_logistics_data);
    }

    public function waste_detail(Request $request)
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
            SELECT *
            FROM ct_waste_production
            WHERE date >= ? AND date <= ?;
        ", [$start_date, $end_date]);

        // Return the data as JSON response
        return response()->json($mining_data);
    }

    public function uoa_detail(Request $request)
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
        $uoa_data = DB::select("
            SELECT *
            FROM ct_plant_utilization
            WHERE date >= ? AND date <= ?;
        ", [$start_date, $end_date]);

        // Return the data as JSON response
        return response()->json($uoa_data);
    }
}

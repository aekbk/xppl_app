<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class SaleExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() {
        $data = DB::table('tempSales')->get();
        return $data;
    }

    public function headings(): array {
        return [
            '#',
            'User',
            'Date',
        ];
    }
}

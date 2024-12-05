<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class download_controller extends Controller
{
    




    public function saleFile($file){
        return response()->download('assets/images/sale-filemanager/'.$file);
    }

    public function incidentFile($file){
        return response()->download('assets/images/incidents/'.$file);
    }


}

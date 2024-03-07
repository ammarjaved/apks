<?php

namespace App\Http\Controllers\web\Tiang;

use App\Http\Controllers\Controller;
use App\Models\Tiang;
use Illuminate\Http\Request;

class TiangSBUMReportController extends Controller
{
    //
    public function generateSBUMReport(Request $req){

        $query = Tiang::where('talian_utama_connection', 'm,s')->count();
    
    }
}

<?php

namespace App\Http\Controllers\web\Tiang;

use App\Http\Controllers\Controller;
use App\Models\Tiang;
use Illuminate\Http\Request;

class TiangSearchController extends Controller
{
    //

    public function getTiangByPolygon(Request $request)
    {
        
        try {
            $data = Tiang::whereRaw("ST_Intersects(geom, ST_GeomFromGeoJSON('$request->json'))")->select('id', 'fp_name', 'tiang_no', 'review_date','total_defects' , 'qa_status' )
            ->whereNotNull('review_date')->get();
        } catch (\Throwable $th) {
            return response()->json(['data'=>'' ,'status'=> 400]);   
        }
       
        return response()->json(['data'=> $data , 'status' => 200]);
    }
}

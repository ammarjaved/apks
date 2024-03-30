<?php

namespace App\Http\Controllers\web\Tiang;

use App\Http\Controllers\Controller;
use App\Models\Substation;
use App\Models\Tiang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiangSearchController extends Controller
{
    //

    public function getTiangByPolygon(Request $request)
    {
        
        try {
            $data = Tiang::whereRaw("ST_Intersects(geom, ST_GeomFromGeoJSON('$request->json'))")->select('id', 'fp_name', 'tiang_no', 'review_date','total_defects' , 'qa_status' ,'reject_remarks', 'fp_road' , 'ba' ,'pole_image_1','pole_image_2' , 'jenis_tiang' ,'size_tiang')
            ->whereNotNull('review_date')->orderBy('id')->get();
        } catch (\Throwable $th) {
            return response()->json(['data'=>'' ,'status'=> 400]);   
        }
       
        return response()->json(['data'=> $data , 'status' => 200]);
    }


    public function seacrhSubstation($lang , $type, $q)
    {

        $ba = \Illuminate\Support\Facades\Auth::user()->ba;

        $data = Substation::where('ba', 'LIKE', '%' . $ba . '%');
        if ($type == 'substation_name') {
           $data->where('name' , 'LIKE' , '%' . $q . '%')->select('name');
        }else{
            $data->where('id' , 'LIKE' , '%' . $q . '%')->select(DB::raw('id as name'));
        }
        $data = $data->limit(10)->get();

        return response()->json($data, 200);
    }

    public function seacrhSubstationCoordinated($lang , $name, $searchBy)
    {
        // return $searchBy;
        $name = urldecode($name);
        $data = Substation::query();
        if ($searchBy == 'substation_name') {
          $data =  $data->where('name' ,$name );
        }
        if ($searchBy == 'substation_id') {
            $data = $data->where('id' ,$name );
        }
        $data =$data->select( DB::raw('ST_X(geom) as x'),DB::raw('ST_Y(geom) as y'))->first();

        return response()->json($data, 200);
    }
}

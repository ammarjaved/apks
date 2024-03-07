<?php

namespace App\Repositories;

use App\Constants\TiangConstants;
use App\Models\Tiang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

class TiangRepository
{

    public function storeTiang($request)
    {

        
    }


    public function getRecoreds($id)
    {
        // dd($id);
        $data = Tiang::find($id);
        // dd($data);
        if ($data) {
            $data['abc_span'] = json_decode($data->abc_span);
            $data['bare_span'] = json_decode($data->bare_span);
            $data['pvc_span'] = json_decode($data->pvc_span);
            $data['tiang_defect'] = json_decode($data->tiang_defect, true);
            $data['talian_defect'] = json_decode($data->talian_defect, true);
            $data['umbang_defect'] = json_decode($data->umbang_defect, true);
            $data['blackbox_defect'] = json_decode($data->blackbox_defect, true);
            $data['jumper'] = json_decode($data->jumper, true);
            $data['kilat_defect'] = json_decode($data->kilat_defect, true);
            $data['servis_defect'] = json_decode($data->servis_defect, true);
            $data['pembumian_defect'] = json_decode($data->pembumian_defect, true);
            $data['bekalan_dua_defect'] = json_decode($data->bekalan_dua_defect, true);
            $data['kaki_lima_defect'] = json_decode($data->kaki_lima_defect, true);
            $data['tapak_condition'] = json_decode($data->tapak_condition, true);
            $data['kawasan'] = json_decode($data->kawasan, true); 
            $data['ipc_defect'] = json_decode($data->ipc_defect, true);
            $data['tiang_defect_image'] = json_decode($data->tiang_defect_image, true);
            $data['talian_defect_image'] = json_decode($data->talian_defect_image, true);
            $data['umbang_defect_image'] = json_decode($data->umbang_defect_image, true);
            $data['ipc_defect_image'] = json_decode($data->ipc_defect_image, true);
            $data['blackbox_defect_image'] = json_decode($data->blackbox_defect_image, true);
            $data['jumper_image'] = json_decode($data->jumper_image, true);
            $data['kilat_defect_image'] = json_decode($data->kilat_defect_image, true);
            $data['servis_defect_image'] = json_decode($data->servis_defect_image, true);
            $data['pembumian_defect_image'] = json_decode($data->pembumian_defect_image, true);
            $data['bekalan_dua_defect_image'] = json_decode($data->bekalan_dua_defect_image, true);
            $data['kaki_lima_defect_image'] = json_decode($data->kaki_lima_defect_image, true);

            $talian = $data->talian_utama_connection ;
            $talian = $talian != '' ? explode(',',$talian) : '';
            
            $data['service_line'] = isset($talian[0]) ? $talian[0] : '';
            $data['main_line'] = isset($talian[1]) ? $talian[1] : '';
          

        }

        return $data;
    }


    
    public function store($request){
        $data = new Tiang();
        $data->qa_status = 'pending';
        $user = Auth::user()->name;
        $data->created_by = $user;
        if ($request->lat != '' && $request->log != '') {
            $data->geom = DB::raw("ST_GeomFromText('POINT(" . $request->log . ' ' . $request->lat . ")',4326)");
            $data->coords = number_format( $request->log , 5 )  .' , ' . number_format( $request->lat , 5);
        }
        return $data;
    }

    public $total_defects = 0;

    public function prepareData($data , $request)
    {
        //  dd($data);
        $data->abc_span = $request->has('abc_span') ? json_encode($request->abc_span) : null;
        $data->pvc_span = $request->has('pvc_span') ? json_encode($request->pvc_span) : null;
        $data->bare_span = $request->has('bare_span') ? json_encode($request->bare_span) : null;
        $data->jarak_kelegaan = $request->jarak_kelegaan;
        $data->ba = $request->ba;
        $data->fp_name = $request->fp_name;
        $data->review_date = $request->review_date;
        $data->fp_road = $request->fp_road;
        $data->section_from = $request->section_from;
        $data->section_to = $request->section_to;
        $data->tiang_no = $request->tiang_no;
        $data->size_tiang = $request->size_tiang;
        $data->jenis_tiang = $request->jenis_tiang;
        $data->talian_utama = $request->talian_utama;

        $talian = '';
        $talian .= $request->has('service_line') ? 's' : '';
        $talian .= $request->has('service_line') && $request->has('main_line') ? ',' : '';
        $talian .= $request->has('main_line') ? 'm' : '';

        $data->talian_utama_connection = $talian;

        $defectsKeys = TiangConstants::TIANG_DEFECT;

        

        $total_defects = 0;

        // START DEFECT FOR EACH
        foreach ($defectsKeys as $key => $defect) 
        {
            $def = [];
            // CHECK IF REQUEST ARRAY ITEM HAS KEY THEN ITEM KEY = TRUE ELSE FALSE . IF TRUE ADD 1 IN TOTAL DEFECTS EXPECT tapak_condition and kawasan
            foreach ($defect as $item) 
            {
                $def[$item] = $request->has("$key.$item") ? true : false;
                if ($def[$item] && $key != 'tapak_condition' && $key!= 'kawasan') {
                    $total_defects++;
                }
            }
            // GET OTHER INPUT VALUE FOR ALL ITEMS EXCEPT tapak_condition
            if ($key != 'tapak_condition') {
                $def['other_value'] = $request->{"$key.other_value"};
            }
            // IF KEY IS tiang_defect OR umbang_defect THEN CHECK THERE CURRENT LEAKAGE  ALSO
            if ($key == 'tiang_defect'  || $key == 'umbang_defect') {
                if ($request->has($key.'_current_leakage') && $request->{$key.'_current_leakage'} == 'Yes') {
                    $def['current_leakage'] = true;
                    $total_defects++;
                }else{
                    $def['current_leakage'] = false;
                }
            
                $def['current_leakage_val'] = $request->{"$key.current_leakage_val"};

                if ($key == 'tiang_defect') {
                    $data->arus_pada_tiang = $def['current_leakage'] == true ?'Yes':'No';
                    $data->arus_pada_tiang_amp = $def['current_leakage_val'];
                }
            }
            $data->{$key} = json_encode($def);
        }
        // END DEFECT FOR EACH


        $defectsImg = TiangConstants::TIANG_IMAGES;
        $destinationPath = 'assets/images/tiang/';

        foreach ($defectsImg as $file) {
            if (is_a($request->{$file}, 'Illuminate\Http\UploadedFile') && $request->{$file}->isValid()) {
                $uploadedFile = $request->{$file};
                $img_ext = $request->{$file}->getClientOriginalExtension();
                $filename = $file . '-' . strtotime(now()) .rand(10,100) . '.' . $img_ext;
                $uploadedFile->move($destinationPath, $filename);
                $data->{$file} = $destinationPath . $filename;
            }
        }

        $data->total_defects = $total_defects; 
        $data->talian_spec = $request->talian_spec;

        return $data;
    }


    public function getDefects(){

    }


}

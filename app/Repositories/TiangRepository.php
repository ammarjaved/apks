<?php

namespace App\Repositories;

use App\Models\Tiang;
use Illuminate\Support\Facades\DB;

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

        }

        return $data;
    }


}

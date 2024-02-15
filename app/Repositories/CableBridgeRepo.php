<?php

namespace App\Repositories;

use App\Models\Substation;
use Illuminate\Support\Carbon;

class CableBridgeRepo
{
    
    public function store($data, $request)
    {
        $currentDate = Carbon::now()->toDateString();
        $combinedDateTime = $currentDate . ' ' . $request->patrol_time;

            $defects = [];
            $defects = ['pipe_staus', 'vandalism_status', 'collapsed_status', 'rust_status', 'bushes_status' , 
                'danger_sign', 'anti_crossing_device','condong','pencerobohan','kebersihan_jabatan'];

            if ($data->qa_status == '') {
                $data->qa_status = 'pending';
            }
            $total_defects =0;
 
            $data->zone = $request->zone;
            $data->ba = $request->ba;
            $data->team = $request->team;
            $data->visit_date = $request->visit_date;
            $data->patrol_time = $combinedDateTime;
            $data->feeder_involved = $request->feeder_involved;

            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->voltage = $request->voltage;


            foreach ($defects as  $value) {
                $data->{$value} = $request->{$value};
                $request->has($value)&& $request->{$value} == 'Yes' ? $total_defects++ : '';
            }
            $data->total_defects = $total_defects;

            $destinationPath = 'assets/images/cable-bridge/';

            foreach ($request->all() as $key => $file) {
                // Check if the input is a file and it is valid
                if ($request->hasFile($key) && $request->file($key)->isValid()) {
                    $uploadedFile = $request->file($key);
                    $img_ext = $uploadedFile->getClientOriginalExtension();
                    $filename = $key . '-' . strtotime(now()).rand(10,100)  . '.' . $img_ext;
                    $uploadedFile->move($destinationPath, $filename);
                    $data->{$key} = $destinationPath . $filename;
                }
            }

        return $data;
    }

}

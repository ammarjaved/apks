<?php

namespace App\Repositories;

use App\Models\Substation;
use App\Models\Tiang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use DataTables;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SubstationRepository
{
    public function dataTableIndex(Request $request)
    {
        $query = Substation::query();

        return DataTables::eloquent($query)
            ->addColumn('unlocked', function ($substation) {
                return $substation->gate_status['unlocked'] ? 'Yes' : 'No';
            })
            // Add other columns as needed
            ->rawColumns(['unlocked', 'other_gate', 'building_other', 'qa_status'])
            ->make(true);
    }

    public function store($data, $request)
    {
        $currentDate = Carbon::now()->toDateString();
        $combinedDateTime = $currentDate . ' ' . $request->patrol_time;

        if ($data->qa_status == '') {
            $data->qa_status = 'pending';
        }
        $data->zone = $request->zone;
        $data->ba = $request->ba;
        $data->team = $request->team;
        $data->visit_date = $request->visit_date;
        $data->patrol_time = $combinedDateTime;
        $data->fl = $request->fl;

        $data->voltage = $request->voltage;
        $data->name = $request->name;
        $data->type = $request->type;

        $total_defects = 0;
        $request->grass_status == 'Yes' ? $total_defects++ : '';
        $request->tree_branches_status == 'Yes' ? $total_defects++ : '';
        $request->advertise_poster_status == 'Yes' ? $total_defects++ : '';

        $data->grass_status = $request->grass_status;
        $data->tree_branches_status = $request->tree_branches_status;

        $data->advertise_poster_status = $request->advertise_poster_status;
        $gate = ['locked' => 'false', 'unlocked' => 'false', 'demaged' => 'false', 'other' => 'false', 'other_value' => ''];

        if ($request->has('gate_status')) {
            $gateStatus = $request->gate_status;

            foreach ($gate as $key => $value) {
                if ($key == 'other_value') {
                    $gate['other_value'] = $request->gate_status['other_value'];
                } else {
                    if ($key == 'locked' || $key == 'unlocked') {
                        $gate[$key] = array_key_exists('locked', $gateStatus) && $gateStatus['locked'] == $key ? 'true' : 'false';
                    } else {
                        if (array_key_exists($key, $gateStatus)) {
                            $gate[$key] = 'true';

                            $total_defects++;
                        } else {
                            $gate[$key] = 'false';
                        }
                    }
                }
            }
            $gate['unlocked'] == 'true' ? $total_defects++ : '';
        }

        $data->gate_status = json_encode($gate);

        $building = ['broken_roof' => 'false', 'broken_gutter' => 'false', 'broken_base' => 'false', 'other' => 'false', 'other_value' => ''];

        if ($request->has('building_status')) {
            $buildingStatus = $request->building_status;

            foreach ($building as $key => $value) {
                if (array_key_exists($key, $buildingStatus)) {
                    if ($key == 'other_value') {
                        $building['other_value'] = $request->building_status['other_value'];
                    } else {
                        $building[$key] = 'true';
                        $total_defects++;
                    }
                }
            }
        }
        $data->building_status = json_encode($building);
        $data->total_defects = $total_defects;

        $destinationPath = 'assets/images/link-box/';
        $imageStoreUrlPath = config('globals.APP_IMAGES_STORE_URL').$destinationPath;
       // $externalPath = config('globals.APP_IMAGES_STORE_URL_TEMP').'/link-box/';

        foreach ($request->allFiles() as $key => $file) {
            // Check if the input is a file and it is valid
            if ($request->hasFile($key) && $request->file($key)->isValid()) {
                $uploadedFile = $request->file($key);
                $img_ext = $uploadedFile->getClientOriginalExtension();
                $filename = $key . '-' . strtotime(now()) . rand(10, 100) . '.' . $img_ext;

                // Move the file to the first location
                $uploadedFile->move($imageStoreUrlPath, $filename);
                $data->{$key} = $destinationPath . $filename;

                // Copy the file to the second location
             //   $sourcePath = $imageStoreUrlPath . $filename;
            //    $destinationPath2 = $externalPath . $filename;
           //     copy($sourcePath, $destinationPath2);
            }

        }

        return $data;
    }

    public function getSubstation($id )  {


        $data = Substation::find($id);
        if ($data) {
            $data->gate_status = json_decode($data->gate_status);
            $data->building_status = json_decode($data->building_status);

            return $data;
        }
        return '';
    }
}

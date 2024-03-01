<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\ThirdPartyDiging;
use App\Models\Tiang;
use App\Repositories\TiangRepository;
use App\Traits\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class TiangContoller extends Controller
{
    use Filter;
    private $tiangRepository;

    public function __construct(TiangRepository $tiaRepository)
    {
        $this->tiangRepository = $tiaRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $ba = $request->filled('ba') ? $request->ba : Auth::user()->ba;
            $result = Tiang::query();

           $result = $this->filter($result , 'review_date' , $request);

            $result->when(true, function ($query) {
                return $query->select('id', 'ba' ,'qa_status' , 'reject_remarks', 'review_date', 'tiang_no', 'total_defects' );
            });

            return datatables()
                ->of($result->get())->addColumn('tiang_id', function ($row) {
                    
                    return "SAVR-" .$row->id;
                })
                ->make(true);
        }

        return view('Tiang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Tiang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
// return $request->tiang_defect['current_leakage'];
        try {
            // $this->tiangRepository->store($request->all());

            $destinationPath = 'assets/images/tiang/';

            $data = new Tiang();
            $data->abc_span = $request->has('abc_span') ? json_encode($request->abc_span) : null;
            $data->pvc_span = $request->has('pvc_span') ? json_encode($request->pvc_span) : null;
            $data->bare_span = $request->has('bare_span') ? json_encode($request->bare_span) : null;
            $data->jarak_kelegaan = $request->jarak_kelegaan;
            $data->qa_status = 'pending';
            $user = Auth::user()->id;

            $data->created_by = $user;
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
            $data->talian_utama_connection = $request->talian_utama_connection;

            $defectsKeys = [];
            $defectsKeys['tiang_defect'] = ['cracked', 'leaning', 'dim', 'creepers', 'other'];
            $defectsKeys['talian_defect'] = ['joint', 'need_rentis', 'ground', 'other'];
            $defectsKeys['umbang_defect'] = ['breaking', 'creepers', 'cracked', 'stay_palte', 'other'];

            $defectsKeys['ipc_defect'] = ['burn', 'other'];
            $defectsKeys['blackbox_defect'] = ['cracked', 'other'];
            $defectsKeys['jumper'] = ['sleeve', 'burn', 'other'];

            $defectsKeys['kilat_defect'] = ['broken', 'other'];
            $defectsKeys['servis_defect'] = ['roof', 'won_piece', 'other'];

            $defectsKeys['pembumian_defect'] = ['netural', 'other'];
            $defectsKeys['bekalan_dua_defect'] = ['damage', 'other'];
            $defectsKeys['kaki_lima_defect'] = ['date_wire', 'burn', 'other'];
            $defectsKeys['tapak_condition'] = ['road', 'side_walk', 'vehicle_entry'];
            $defectsKeys['kawasan'] = ['road', 'bend', 'forest', 'other'];

            $defectsImg = ['tapak_road_img', 'tapak_sidewalk_img', 'tapak_no_vehicle_entry_img', 'kawasan_bend_img', 'kawasan_road_img', 'kawasan_forest_img', 'kawasan_other_img', 'pole_image_1', 'pole_image_2'];

            $total_defects = 0;
            foreach ($defectsKeys as $key => $defect) {
                $def = [];
                $arr = [];

                foreach ($defect as $item) {
                    if ($request->has("$key.$item")) {
                        $def[$item] = true;

                        if ($key != 'tapak_condition' && $key != 'kawasan') {
                            if ($request->{$key . '_image'} != '') {
                                foreach ($request->{$key . '_image'} as $keyy => $file) {
                                    if (is_a($file, 'Illuminate\Http\UploadedFile') && $file->isValid()) {
                                        $uploadedFile = $file;
                                        $img_ext = $uploadedFile->getClientOriginalExtension();
                                        $filename = $keyy . '-' . strtotime(now()).rand(10,100)  . '.' . $img_ext;
                                        $uploadedFile->move($destinationPath, $filename);
                                        $arr[$keyy] = $destinationPath . $filename;
                                    }
                                }
                            }
                        }
                    } else {
                        $def[$item] = false;
                    }
                }

                if ($key != 'tapak_condition') {
                    $def['other_value'] = $request->{"$key.other_value"};
                }

            
                if ($key == 'tiang_defect'  || $key == 'umbang_defect') {
                    // return "$key.'current_leakage'";
                    if ($request->has('tiang_defect_current_leakage') && $request->{$key.'_current_leakage'} == 'Yes') {
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

                if ($key != 'tapak_condition' || $key!= 'kawasan') {
                    $total_defects++;

                }
                if ($key != 'tapak_condition' && $key != 'kawasan') {
                    $data->{$key . '_image'} = json_encode($arr);
                }
            }

            foreach ($defectsImg as $file) {
                if (is_a($request->{$file}, 'Illuminate\Http\UploadedFile') && $request->{$file}->isValid()) {
                    $uploadedFile = $request->{$file};
                    $img_ext = $request->{$file}->getClientOriginalExtension();
                    $filename = $file . '-' . strtotime(now()) .rand(10,100) . '.' . $img_ext;
                    $uploadedFile->move($destinationPath, $filename);
                    $data->{$file} = $destinationPath . $filename;
                }
            }
            // $request->arus_pada_tiang == 'Yes' ? $total_defects++ : '';
            // $data->arus_pada_tiang = $request->arus_pada_tiang;
            // return $data;
            $data->total_defects = $total_defects;
            

            $data->talian_spec = $request->talian_spec;

            if ($request->lat != '' && $request->log != '') {
                $data->geom = DB::raw("ST_GeomFromText('POINT(" . $request->log . ' ' . $request->lat . ")',4326)");
                $data->coords = number_format( $request->log , 5 )  .' , ' . number_format( $request->lat , 5);
            }
            // return "Sds";
            $data->save();
            // return 'asdasd';

            return redirect()
                ->route('tiang-talian-vt-and-vr.index', app()->getLocale())
                ->with('success', 'Form Intserted');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()
                ->route('tiang-talian-vt-and-vr.index', app()->getLocale())
                ->with('failed', 'Form Intserted Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($language, $id)
    {
        try {
            $data = $this->tiangRepository->getRecoreds($id);

            return view('Tiang.detail', ['data' => $data]);
        } catch (\Throwable $th) {
            return redirect()
                ->route('tiang-talian-vt-and-vr.index')
                ->with('failed', 'Request Failed');
        }

        // dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $id)
    {
        $data = $this->tiangRepository->getRecoreds($id);

        // return $data->tapak_condition;
        return $data ? view('Tiang.edit', ['data' => $data]) : abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $language, $id)
    {
        //
        try {
            //  return $request->abc_span;
            //code...
            $destinationPath = 'assets/images/tiang/';
            $data = Tiang::find($id);
            foreach ($request->all() as $mainkey => $mainvalue) {
                if (is_array($mainvalue)) {
                    $json = json_decode($data[$mainkey], true) ?? []; // Decode existing JSON or create an empty array if not exists

                    foreach ($mainvalue as $key => $file) {
                        if (is_a($file, 'Illuminate\Http\UploadedFile') && $file->isValid()) {
                            $uploadedFile = $file;
                            $img_ext = $uploadedFile->getClientOriginalExtension();
                            $filename = $key . '-' . strtotime(now()).rand(10,100)  . '.' . $img_ext;
                            $uploadedFile->move($destinationPath, $filename);
                            $json[$key] = $destinationPath . $filename;
                        }
                    }

                    $data[$mainkey] = json_encode($json);
                } else {
                    if (is_a($mainvalue, 'Illuminate\Http\UploadedFile') && $mainvalue->isValid()) {
                        $uploadedFile = $mainvalue;
                        $img_ext = $uploadedFile->getClientOriginalExtension();
                        $filename = $mainkey . '-' . strtotime(now()).rand(10,100)  . '.' . $img_ext;
                        $uploadedFile->move($destinationPath, $filename);
                        $data[$mainkey] = $destinationPath . $filename;
                    }
                }
            }

            $data->ba = $request->ba;
            $user = Auth::user()->id;
            if ($data->qa_status == '') {
                $data->qa_status = 'pending';
            }
            $data->updated_by = $user;
            $data->fp_name = $request->fp_name;

            $data->fp_road = $request->fp_road;
            $data->section_from = $request->section_from;
            $data->section_to = $request->section_to;
            $data->tiang_no = $request->tiang_no;
            $data->talian_utama = $request->talian_utama;
            $data->talian_utama_connection = $request->talian_utama_connection;
            $data->size_tiang = $request->size_tiang;
            $data->jenis_tiang = $request->jenis_tiang;
            $data->abc_span = $request->has('abc_span') ? json_encode($request->abc_span) : null;
            $data->pvc_span = $request->has('pvc_span') ? json_encode($request->pvc_span) : null;
            $data->bare_span = $request->has('bare_span') ? json_encode($request->bare_span) : null;

            $defectsKeys = [];
            $defectsKeys['tiang_defect']        = ['cracked', 'leaning', 'dim', 'creepers', 'other'];
            $defectsKeys['talian_defect']       = ['joint', 'need_rentis', 'ground', 'other'];
            $defectsKeys['umbang_defect']       = ['breaking', 'creepers', 'cracked', 'stay_palte', 'other'];
            $defectsKeys['ipc_defect']          = ['burn', 'other'];
            $defectsKeys['blackbox_defect']     = ['cracked', 'other'];
            $defectsKeys['jumper']              = ['sleeve', 'burn', 'other'];
            $defectsKeys['kilat_defect']        = ['broken', 'other'];
            $defectsKeys['servis_defect']       = ['roof', 'won_piece', 'other'];
            $defectsKeys['pembumian_defect']    = ['netural', 'other'];
            $defectsKeys['bekalan_dua_defect']  = ['damage', 'other'];
            $defectsKeys['kaki_lima_defect']    = ['date_wire', 'burn', 'other'];
            $defectsKeys['tapak_condition']     = ['road', 'side_walk', 'vehicle_entry'];
            $defectsKeys['kawasan']             = ['road', 'bend', 'forest', 'other'];

            $total_defects = 0;
            foreach ($defectsKeys as $key => $defect) {
                $def = [];
                $arr = [];

                foreach ($defect as $item) {
                    if ($request->has("$key.$item")) {
                        $def[$item] = true;
                        if ($key != 'tapak_condition' || $key!= 'kawasan') {
                            $total_defects++;

                        }
                    } else {
                        $def[$item] = false;
                    }
                }
        

                if ($key != 'tapak_condition') {
                    $def['other_value'] = $request->{"$key.other_value"};
                }

                
                if ($key == 'tiang_defect'  || $key == 'umbang_defect') {
                    // return "$key.'current_leakage'";
                    if ($request->has('tiang_defect_current_leakage') && $request->{$key.'_current_leakage'} == 'Yes') {
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

            // $request->arus_pada_tiang == 'Yes' ? $total_defects++ : '';
        
            $data->total_defects = $total_defects;
            // return $data;
            $data->jarak_kelegaan = $request->jarak_kelegaan;

            $data->talian_spec = $request->talian_spec;

            // $data->arus_pada_tiang = $request->arus_pada_tiang;

            $data->update();

            return redirect()
                ->route('tiang-talian-vt-and-vr.index', app()->getLocale())
                ->with('success', 'Form Update');
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return redirect()
                ->route('tiang-talian-vt-and-vr.index', app()->getLocale())
                ->with('failed', 'Form Update Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($language, $id)
    {
        //
        try {
            Tiang::find($id)->delete();

            return redirect()
                ->route('tiang-talian-vt-and-vr.index', app()->getLocale())
                ->with('success', 'Record Removed');
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return redirect()
                ->route('tiang-talian-vt-and-vr.index', app()->getLocale())
                ->with('failed', 'Request Failed');
        }
    }


    public function updateQAStatus(Request $req)
    {
        try {
            $qa_data = Tiang::find($req->id);
            $qa_data->qa_status = $req->status;
            if ($req->status == 'Reject') {
                $qa_data->reject_remarks = $req->reject_remakrs;
            }
            $user = Auth::user()->id;

            $qa_data->updated_by = $user;
            $qa_data->update();

            return redirect()->back();
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Request failed']);
        }
    }
}

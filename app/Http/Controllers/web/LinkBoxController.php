<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\LinkBox;
use App\Models\Team;
use App\Traits\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LinkBoxController extends Controller
{
    use Filter;
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
            $result = LinkBox::query();

           $result = $this->filter($result , 'visit_date' , $request);

            $result->when(true, function ($query) {
                return $query->select('id','qa_status' , 'reject_remarks', 'ba', 'zone', 'team', 'visit_date','total_defects' , 'qa_status');
            });

            return datatables()
                ->of($result->get())->addColumn('link_box_id', function ($row) {
                    
                    return "LB-" .$row->id;
                })
                ->make(true);
        }
        return view('link-box.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $team_id = auth()->user()->id_team;
        $team = Team::find($team_id)->team_name;
        return view('link-box.create', ['team' => $team]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentDate = Carbon::now()->toDateString();
        $combinedDateTime = $currentDate . ' ' . $request->patrol_time;

        try {
            $defects = [];
            $defects =['leaning_status','vandalism_status','advertise_poster_status','rust_status','bushes_status' ,'cover_status' ,'paint_status'];
            $total_defects = 0;

            $data = new LinkBox();
            $data->zone = $request->zone;
            $data->ba = $request->ba;
            $data->team = $request->team;
            $data->visit_date = $request->visit_date;
            $data->patrol_time = $combinedDateTime;
            $data->leaning_angle = $request->leaning_angle;

            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->type = $request->type;
            $data->qa_status = 'pending';
            $user = Auth::user()->name;

            $data->created_by = $user;
            $data->coordinate = $request->coordinate;

            foreach ($defects as  $value) {
                $data->{$value} = $request->{$value};
               $request->has($value)&& $request->{$value} == 'Yes' ? $total_defects++ : '';
            }
           $data->total_defects = $total_defects;

            $destinationPath = 'assets/images/link-box/';

            foreach ($request->all() as $key => $file) {
                // Check if the input is a file and it is valid
                if ($request->hasFile($key) && $request->file($key)->isValid()) {
                    $uploadedFile = $request->file($key);
                    $img_ext = $uploadedFile->getClientOriginalExtension();
                    $filename = $key . '-' . strtotime(now()) .rand(10,100) . '.' . $img_ext;
                    $uploadedFile->move($destinationPath, $filename);
                    $data->{$key} = $destinationPath . $filename;
                }
            }

            $data->geom = DB::raw("ST_GeomFromText('POINT(" . $request->log . ' ' . $request->lat . ")',4326)");

            $data->save();

            return redirect()
                ->route('link-box-pelbagai-voltan.index', app()->getLocale())
                ->with('success', 'Form Intserted');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()
                ->route('link-box-pelbagai-voltan.index', app()->getLocale())
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
        //
        $data = LinkBox::find($id);
        return view('link-box.show', ['data' => $data, 'disabled'=>true]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $id)
    {
        //
        $data = LinkBox::find($id);
        return view('link-box.edit', ['data' => $data, 'disabled'=>false]);
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

        $currentDate = Carbon::now()->toDateString();
        $combinedDateTime = $currentDate . ' ' . $request->patrol_time;
        try {

            $defects = [];
            $defects =['leaning_status','vandalism_status','advertise_poster_status','rust_status','bushes_status' ,'cover_status' , 'paint_status'];
            $total_defects = 0;
            $data = LinkBox::find($id);
            $data->zone = $request->zone;
            $data->ba = $request->ba;
            // $data->team = $request->team;
            $data->visit_date = $request->visit_date;
            $data->patrol_time = $combinedDateTime;
            $data->feeder_involved = $request->feeder_involved;
            $user = Auth::user()->name;

            $data->updated_by = $user;
            if ($data->qa_status == '') {
                $data->qa_status = 'pending';
            }
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->type = $request->type;
            $data->coordinate = $request->coordinate;
            foreach ($defects as  $value) {
                $data->{$value} = $request->{$value};
               $request->has($value)&& $request->{$value} == 'Yes' ? $total_defects++ : '';
            }
           $data->total_defects = $total_defects;
           $data->leaning_angle = $request->leaning_angle;
            $destinationPath = 'assets/images/link-box/';

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

            $data->save();

            return redirect()
                ->route('link-box-pelbagai-voltan.index', app()->getLocale())
                ->with('success', 'Form Update');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()
                ->route('link-box-pelbagai-voltan.index', app()->getLocale())
                ->with('failed', 'Request Failed');
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
            LinkBox::find($id)->delete();

            return redirect()
                ->route('link-box-pelbagai-voltan.index', app()->getLocale())
                ->with('success', 'Recored Removed');
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return redirect()
                ->route('link-box-pelbagai-voltan.index', app()->getLocale())
                ->with('failed', 'Request Failed');
        }
    }

    public function updateQAStatus(Request $req)
    {
        try {
            $qa_data = LinkBox::find($req->id);
            $qa_data->qa_status = $req->status;
            if ($req->status == 'Reject') {
                $qa_data->reject_remarks = $req->reject_remakrs;
            }
            $user = Auth::user()->name;
            
            $qa_data->qc_by = $user;
            $qa_data->update();

            return redirect()->back();
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Request failed']);
        }
    }
}

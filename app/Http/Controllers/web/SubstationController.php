<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Substation;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\Filter;
use App\Repositories\SubstationRepository;
use Illuminate\Support\Facades\Session;
use DataTables;

class SubstationController extends Controller
{
    use Filter;

    private $substationRepository;

    public function __construct(SubstationRepository $substationRepository)
    {
        $this->substationRepository = $substationRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return strtotime(now());
        if ($request->ajax()) {
            $result = Substation::query();

            $result = $this->filter($result, 'visit_date', $request);

            $result->when(true, function ($query) {
                return $query->select('id','updated_at', 'name', DB::raw("CASE WHEN (gate_status->>'unlocked')::text='true' THEN 'Yes' ELSE 'No' END as unlocked"), DB::raw("CASE WHEN (gate_status->>'demaged')::text='true' THEN 'Yes' ELSE 'No' END as demaged"), DB::raw("CASE WHEN (gate_status->>'other')::text='true' THEN 'Yes' ELSE 'No' END as other_gate"), DB::raw("CASE WHEN (building_status->>'broken_roof')::text='true' THEN 'Yes' ELSE 'No' END as broken_roof"), DB::raw("CASE WHEN (building_status->>'broken_gutter')::text='true' THEN 'Yes' ELSE 'No' END as broken_gutter"), DB::raw("CASE WHEN (building_status->>'broken_base')::text='true' THEN 'Yes' ELSE 'No' END as broken_base"), DB::raw("CASE WHEN (building_status->>'other')::text='true' THEN 'Yes' ELSE 'No' END as building_other"), 'grass_status', 'tree_branches_status', 'advertise_poster_status', 'total_defects', 'visit_date', 'substation_image_1', 'substation_image_2', 'qa_status' ,'reject_remarks');
            });

            return datatables()
                ->of($result->get())->addColumn('substation_id', function ($row) {
                    
                    return "SUB-" .$row->id;
                })  
                ->make(true);

                // $result->orderBy('visit_date', 'desc');
 

                // $result->orderBy('created_at', 'desc');
                // $dataTable = new DataTables;
    
                // $dataTable = $dataTable->eloquent($result)
                //     ->make(true);
                //     return $dataTable;

        }

        return view('substation.index');
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
        return view('substation.create', ['team' => $team]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user()->name;
            $data = new Substation();
            $data->created_by = $user;
            $data->geom = DB::raw("ST_GeomFromText('POINT(" . $request->log . ' ' . $request->lat . ")',4326)");
            $data->coordinate = $request->coordinate;
            // $data->qa_status = 'pending';

            $res = $this->substationRepository->store($data, $request);

            $res->save();

            Session::flash('success', 'Request Success');

        } catch (\Throwable $th) {
            Session::flash('failed', 'Request Failed');
        }

        return redirect()->route('substation.index', app()->getLocale());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($language, $id)
    {
        $data = $this->substationRepository->getSubstation($id );
       
        if ($data) {
            return view('substation.show', ['data' => $data, 'disabled' => true]);
        }
        return abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $id)
    {
       $data = $this->substationRepository->getSubstation($id);

        if ($data) {
            return view('substation.edit', ['data' => $data, 'disabled' => false]);
        }
        return abort('404');
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
        try {


            $data = Substation::find($id);
            if (!$data) {
               return abort(404);
            }
        
            $user = Auth::user()->name;
            $data->updated_by = $user;
           
            $res = $this->substationRepository->store($data, $request);
            $res->update();
        Session::flash('success', 'Request Success');


        } catch (\Throwable $th) {
            Session::flash('failed', 'Request Failed');
        }

        return redirect()->route('substation.index', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($language, $id)
    {
        try {
            Substation::find($id)->delete();

            Session::flash('success', 'Request Success');

        } catch (\Throwable $th) {
            Session::flash('failed', 'Request Failed');
        }

        return redirect()->route('substation.index', app()->getLocale());
    }

    public function updateQAStatus(Request $req)
    {
        try {
            // return $req;
            $qa_data = Substation::find($req->id);
            $qa_data->qa_status = $req->status;
            if ($req->status == 'Reject') {
                $qa_data->reject_remarks = $req->reject_remakrs;
            }
            $user = Auth::user()->name;
            
            $qa_data->qc_by = $user;
            $qa_data->update();

            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
            return response()->json(['status' => 'Request failed']);
        }
    }
}

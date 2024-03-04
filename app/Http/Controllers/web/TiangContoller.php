<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Tiang;
use App\Repositories\TiangRepository;
use App\Traits\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


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
        try {

            $create = $this->tiangRepository->store($request);
            $data = $this->tiangRepository->prepareData($create , $request);
            $data->save();
            
            Session::flash('success', 'Request Success');
        } catch (\Throwable $th) {
            // return $th->getMessage();
            Session::flash('failed', 'Request Failed');
        }
        return redirect()->route('tiang-talian-vt-and-vr.index', app()->getLocale());

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
        try {
            $recored = Tiang::find($id);
            if ($recored) {
                $user = Auth::user()->name;
                $recored->updated_by = $user;
                $data = $this->tiangRepository->prepareData($recored , $request);
                $data->update();

                Session::flash('success', 'Request Success');
            }else{
                Session::flash('failed', 'Request Failed');
            }

        } catch (\Throwable $th) {
            Session::flash('failed', 'Request Failed');
        }
        return redirect()->route('tiang-talian-vt-and-vr.index', app()->getLocale());
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

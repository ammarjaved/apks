<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Substation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SubstationRepository;
use Illuminate\Support\Facades\DB;

class SubstationMapController extends Controller
{
    //

    public function editMap($lang, $id, SubstationRepository $substationRepository)
    {
        $data = $substationRepository->getSubstation($id);

        if ($data) {
            return $data ? view('substation.edit-form', ['data' => $data, 'disabled' => false]) : abort(404);
        }
        return abort('404');
    }
    public function update(Request $request, $language, $id, SubstationRepository $substationRepository)
    {
        try {
            $data = Substation::find($id);
            if (!$data) {
                return abort(404);
            }

            $user = Auth::user()->id;
            $data->updated_by = $user;

            $res = $substationRepository->store($data, $request);

            $res->update();

            return view('components.map-messages', ['id' => $id, 'success' => true, 'url' => 'substation'])->with('success', 'Form Update');
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return view('components.map-messages', ['id' => $id, 'success' => false, 'url' => 'substation'])->with('failed', 'Form Update Failed');
        }
    }

    public function seacrh($lang, $q)
    {
        $ba = \Illuminate\Support\Facades\Auth::user()->ba;

        $data = Substation::where('ba', 'LIKE', '%' . $ba . '%')
            ->where('name', 'LIKE', '%' . $q . '%')
            ->select('name')
            ->limit(10)
            ->get();

        return response()->json($data, 200);
    }

    public function seacrhCoordinated($lang, $name)
    {
        $name = urldecode($name);
        $data = Substation::where('name', 'LIKE', '%' . $name . '%')
            ->select('name', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))
            ->first();

        return response()->json($data, 200);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SelectData;
use App\Models\DataKuisioner;

class SelectDataController extends Controller
{
    public function index(Request $request, $id)
    {
        $dataKuisioner = DataKuisioner::where('kode_kuisioner',$id)->get();
        return view('superadmin.select-data.index',['id' => $id,'list' => $dataKuisioner]);
    }

    public function listOption(Request $request, $id)
    {
        $listOption = SelectData::where('kode_kuisioner','=',$id)->orderBy('no_urut','ASC')->get();
        if($request->ajax()){
            return datatables()->of($listOption)
                ->addColumn('action', function($data){
                    return '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('superadmin.select-data.index');
    }

    public function store(Request $request)
    {
        $post  = SelectData::updateOrCreate(['id' => $request->id],
                [
                    'kode_kuisioner'    => $request->kode_kuisioner,
                    'isi_data'          => $request->isi_data,
                    'no_urut'           => $request->no_urut,
                    'is_archived'       => 0,
                ]);
        return response()->json($post);
    }

    public function show(Request $request, $id)
    {
        $listOption = SelectData::leftJoin('data_kuisioners','data_kuisioners.kode_kuisioner','=','select_data.kode_kuisioner')
            ->select('select_data.id AS id','select_data.isi_data','data_kuisioners.nama_data')
            ->where('select_data.kode_kuisioner','=',$id)
            ->get();
        $dataKuisioner = DataKuisioner::where('kode_kuisioner',$id)->get();
        return view('superadmin.select-data.index',['id' => $id,'list' => $dataKuisioner]);
    }

    public function destroy($id)
    {
        $post = SelectData::where('id',$id)->delete();     
        return response()->json($post);
    }
}

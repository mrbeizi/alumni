<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataKuisioner;
use DataTable;

class DataKuisionerController extends Controller
{
    public function index(Request $request)
    {
        $dataKuisioner = DataKuisioner::all();
                
        if($request->ajax()){
            return datatables()->of($dataKuisioner)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })->addColumn('isSelected', function($data){
                    if($data->is_selected == 1){
                        return '<a href="'.Route('select.data',['id' => $data->kode_kuisioner]).'"><button type="button" name="opsi" id="'.$data->kode_kuisioner.'" class="opsi btn btn-info btn-xs"><i class="bx bx-xs bx-check"></i></button></a>';
                    } else {
                        return '<button type="button" class="opsi btn btn-secondary btn-xs"><i class="bx bx-xs bx-x"></i></button>';
                    }
                })
                ->rawColumns(['action','isSelected'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('superadmin.data-kuisioner.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kuisioner' => 'required',
            'nama_data'      => 'required',
            'no_urut'        => 'required',
            'is_selected'    => 'required',
            'is_required'    => 'required',
            'kategori'       => 'required',
        ],[
            'kode_kuisioner.required' => 'Anda belum menginputkan nip',
            'nama_data.required'      => 'Anda belum menginputkan nama',
            'no_urut.required'        => 'Anda belum memilih jenis kelamin',
            'is_selected.required'    => 'Anda belum menginputkan tempat lahir',
            'is_required.required'    => 'Anda belum menginputkan tanggal lahir',
            'kategori.required'       => 'Anda belum memilih kategori'
        ]);

        $post = DataKuisioner::updateOrCreate(['id' => $request->id],
                [
                    'kode_kuisioner'  => $request->kode_kuisioner,
                    'nama_data'       => $request->nama_data,
                    'no_urut'         => $request->no_urut,
                    'is_archived'     => 0,
                    'is_selected'     => $request->is_selected,
                    'is_required'     => $request->is_required,
                    'kategori'        => $request->kategori
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = DataKuisioner::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = DataKuisioner::where('id',$id)->delete();     
        return response()->json($post);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use Yajra\Datatables\Datatables;

class KategoriController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    public function index(Request $request)
    {
          if ($request->ajax()) {
            $data = Kategori::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-edit"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('kategori.index');
    	// $kategori = Kategori::all();
     //    return view('kategori.index', compact('kategori'));
    }
    public function store(Request $request)
    {
    	$this->validate($request,[
    		'nama_kategori'	=> 'required',
    	]);
    	 Kategori::updateOrCreate(['id' => $request->id],
                ['nama_kategori' => $request->nama_kategori]);
        return response()->json(['pesan'=>'Item saved success']);
    	 // return redirect('/kategori')->with('pesan','Data Master berhasil di tambahkan');
    }
    public function edit($id)
    {
    	$item = Kategori::find($id);
        return response()->json($item);
    }
   
    public function destroy($id)
    {
       Kategori::find($id)->delete();
     
       return response()->json(['success'=>'Item deleted successfully.']);
    }
}

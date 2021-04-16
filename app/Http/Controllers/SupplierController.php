<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use Yajra\Datatables\Datatables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct(){
        $this->middleware('admin');
    }
    public function index(Request $request)
    {
        $max = Supplier::where('kode_supplier', \DB::raw("(select max(`kode_supplier`) from suppliers)"))->pluck('kode_supplier');
        $check_max = Supplier::all()->count();
        if($check_max == null){
            $kode_supplier = "SP0001";
        }else{
            $kode_supplier = $max[0];
            $kode_supplier++;
        }
        if ($request->ajax()) {
            $data = Supplier::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-edit"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('supplier.index',compact('kode_supplier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'kode_supplier'       => 'required',
            'nama_supplier'     => 'required',
        ]);
        Supplier::updateOrCreate(['id' => $request->id],
                ['kode_supplier' => $request->kode_supplier, 'nama_supplier' => $request->nama_supplier, 'no_wa' => $request->no_wa]);

        return redirect('/supplier')->with('pesan','Data berhasil di input');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json($supplier);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

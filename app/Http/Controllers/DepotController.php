<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Depot;
use Illuminate\Support\Facades\Validator;
use App\Exports\DepotExport;
use Excel;
use Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepotController extends Controller
{
   public function __construct()
    {
        $this->middleware('checkrole')->except('index');
        $this->middleware('checkMK');

    }
    public function index()
    {
        $data['users'] = User::all();
        $data['depots'] = Depot::orderBy('id', 'desc')->get();
        return view('admin.depot.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['users'] = User::all();
        return view('admin.depot.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $valid = Validator::make($request->all(), [
            'name' => 'required|unique:depots,name',
            'user_id' => 'required',
        ], [
            'name.required' => 'nhập tên kho',
            'user_id.required' => 'chon nguoi quan ly',
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $depot = Depot::create([
                'name' => $request->input('name'),
                'user_id' => $request->input('user_id'),
            ]);
            return redirect()->route('admin.depot.index')->with('message', "Thêm kho $depot->name thành công");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['users'] = User::all();
        $data['depot'] = Depot::find($id);
        if ($data['depot'] !== null) {
            return view('admin.depot.show', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'user_id' => 'required',
        ], [
            'name.required' => 'nhập tên kho',
            'user_id.required' => 'chọn người quản lý',
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $depot = Depot::find($id);
            if ($depot !== null) {
                $depot->name = $request->name;
                $depot->user_id= $request->user_id;
                $depot->save();
                return redirect()->route('admin.depot.index')->with('message', "Đã cập nhật kho $depot->name");
            }
            return redirect()->route('admin.depot.index')->with('error', 'Không tìm thấy kho này');
        }
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
        $depot = Depot::find($id);
        if ($depot !== null) {
            $depot->delete();
            return redirect()->route('admin.depot.index')->with('message', "Đã xóa kho $depot->name");
        }
        return redirect()->route('admin.depot.index')->with('error', 'Không tìm thấy kho này');
    }
    public function export()
    {       
        return Excel::download(new DepotExport(), 'depots.xls');
    }
}

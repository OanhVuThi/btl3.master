<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use App\Depot;
use App\depotProduct;
use App\History;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Exports\HistoryExport;
use Excel;
use Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class depotProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        $id = Auth::id();
        $data['historys'] = depotProduct::where('depot_id', '=', Auth::id())->get();
        return view('admin.product.history', $data);
    }

    
    public function show($id)
    {
       
        $data['depots'] = Depot::where('user_id', '=', Auth::id())->get();
        $data['product'] = Product::find($id);
        if ($data['product'] !== null) {
            return view('admin.product.import', $data);
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
        $data['depots'] = Depot::where('user_id', '=', Auth::id())->get();
        $data['product'] = Product::find($id);
        if ($data['product'] !== null) {
            return view('admin.product.export', $data);
        }      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $productd)
    {
        $valid = Validator::make($request->all(), [
            'count' => 'bail|required|numeric|min:0|max:500000',        
            'depot_id' => 'required',        
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } 
        else {
            $depot = Depot::find($request->get('depot_id'));
            $depot->product()->attach($productd, [
                'count' => $request->get('count', 0),
            ]);   


            $product = Product::find($productd);
            if ($product !== null) { 
                $product->count+= $request['count'];
                $product->save();
            }   
            $depot->save(); 
            return redirect()->route('product.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update2(Request $request, $product)
    { 
     
       $valid = Validator::make($request->all(), [
            'count' => 'bail|required|numeric|min:0|max:500000',        
            'depot_id' => 'required',        
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } 
        else {
            $depot = Depot::find($request->get('depot_id'));
            $depot->product()->attach($product, [
                'count' => $request->get('count', 0),
            ]);   


            $product = Product::find($product);
            if ($product !== null && $product->count > $request['count']) { 
                $product->count-= $request['count'];
                $product->save();
            } else { 
                return redirect()->back()->with('error', ' so luong san pham hien co khong du');
            }
            $depot->save(); 
            return redirect()->route('product.index');
        }
    }
    public function export()
    {       
        return Excel::download(new HistoryExport(), 'historys.xls');
    }

}


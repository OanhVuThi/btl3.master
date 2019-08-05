<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Validator;
use Excel;
use App\Exports\ProductExport;


class ProductController extends Controller
{
    protected $model;
    public function __construct(Product $product)
    {
        $this->middleware('auth');
        $this->model = $product;
    }


    public function index()
    {
        
        $data['products'] =Product::orderBy('id', 'desc')->get();
        return view('admin.product.index', $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
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
            'name' => 'required|unique:products,name',
            
        ], [
            'name.required' => 'nhập tên sản phẩm',
           
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $product = Product::create([
                'name' => $request->input('name'),
                
            ]);
            return redirect()->route('product.index')->with('message', "Thêm sản phẩm $product->name thành công");
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

        $data['product'] = Product::find($id);
        if ($data['product'] !== null) {
            return view('admin.product.show', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProduct(Request $request)
    {
        return $this->model->getUpdate1($request->product_id, $request->name);
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
            'name' => 'required|unique:products,name',
            
        ], [
            'name.required' => 'nhập tên sản phẩm',
            
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $product = Product::find($id);
            if ($product !== null) {
                $product->name = $request->name;              
                $product->save();
                return redirect()->route('product.index')->with('message', "Đã cập nhật sản phẩm $product->name");
            }
            return redirect()->route('product.index')->with('error', 'Không tìm thấy sản phẩm này');
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
        $product = Product::find($id);
        if ($product !== null) {
            $product->delete();
            return redirect()->route('product.index')->with('message', "Đã xóa sản phẩm $product->name");
        }
        return redirect()->route('product.index')->with('error', 'Không tìm thấy sản phẩm này');
    }
     public function export()

    {
       
        return Excel::download(new ProductExport(), 'Product.xls');
    }
      


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Response;
use DataTables;

class ProductController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()::of(
                Product::select('*')
            )->addColumn('action', 'product.action')
                ->addColumn('image', 'product.image')
                ->rawColumns(['action', 'image'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('product.home');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $productId = $request->product_id;
        $image = $request->hidden_image;

        if ($file = $request->file('image')) {

            \File::delete('public/product/' . $request->hidden_image);

            $destinationPath = 'public/product/';
            $profileImage = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $profileImage);
            $image = "$profileImage";
        }

        $product = Product::find($productId) ?? new Product();
        $product->id = $productId;
        $product->title = $request->title;
        $product->category = $request->category;
        $product->price = $request->price;
        $product->image = $image;

        $product->save();

        return Response::json($product);
    }

    public function destroy($id)
    {
        $data = Product::where('id', $id)->first(['image']);

        \File::delete('public/product/' . $data->image);

        $product = Product::where('id', $id)->delete();
        return Response::json($product);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $product = Product::where($where)->first();

        return Response::json($product);
    }
}

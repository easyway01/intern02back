<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // 显示产品列表
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('productDetail', compact('product')); // ✅ 文件路径：resources/views/productDetail.blade.php
    }    
    
    public function index()
{
    $products = Product::all();
    return view('showProduct', compact('products'));
}


    // 显示添加产品表单
    public function create()
    {
        return view('addProduct'); // Show the add product form
    }

    // 存储新产品
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'productName' => 'required|max:255',
            'productDescription' => 'required',
            'productImage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;

        // Handle file upload if an image is provided
        if ($request->hasFile('productImage')) {
            $image = $request->file('productImage');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName); // Store the image in the 'images' directory
        }

        // Create the product
        Product::create([
            'name' => $request->input('productName'),
            'description' => $request->input('productDescription'),
            'category_id' => 1,  // Assuming category_id is 1, you may want to adjust this
            'image' => $imageName,
        ]);

        return redirect()->route('showProduct'); // Redirect back to product list after storing
    }

    // 查看产品详细信息
    public function productDetail($id)
    {
        $product = Product::findOrFail($id);
        return view('productDetail', compact('product'));
    }
    
    
    

    // 编辑产品信息
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('editProduct', compact('product'));
    }

    // 更新产品信息
    public function update(Request $request, $id)
    {
        $request->validate([
            'productName' => 'required|max:255',
            'productDescription' => 'required',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('productImage')) {
            $image = $request->file('productImage');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $product->name = $request->input('productName');
        $product->description = $request->input('productDescription');
        $product->category_id = $request->input('category_id');
        $product->save();

        return redirect()->route('showProduct');
    }

    // 删除产品
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('showProduct');
    }

    // 产品搜索
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $products = Product::where('name', 'LIKE', '%' . $query . '%')->get();
    
        return view('showProduct', compact('products'));
    }

    // 自动完成功能
    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->get(['id', 'name']);
        return response()->json($results);
    }
    
}

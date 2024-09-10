<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {

        // 檢查用戶是否為 admin，如果不是則返回 403 未授權
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        return view('products.create');
    }

    public function store(Request $request)
    {
        // 檢查用戶是否為 admin，如果不是則返回 403 未授權
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // 驗證輸入數據
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 保存圖片並存儲其路徑
        $imagePath = $request->file('image')->store('images', 'public');

        // 創建產品
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        // 重定向到產品列表頁面並顯示成功訊息
        return redirect()->route('products.index')->with('success', '產品創建成功');
    }

    public function getProducts()
    {
        // 返回所有產品的 JSON 數據
        return response()->json(Product::all());
    }
    public function edit($id)
    {
        // 檢查用戶是否為 admin，如果不是則返回 403 未授權
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // 檢查用戶是否為 admin，如果不是則返回 403 未授權
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // 驗證輸入數據
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 找到要更新的產品
        $product = Product::findOrFail($id);

        // 更新產品信息
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;

        // 更新圖片如果有新圖片上傳
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }

        // 保存產品
        $product->save();

        // 重定向回產品列表並顯示成功訊息
        return redirect()->route('products.index')->with('success', '產品更新成功');
    }
    public function destroy($id)
    {
        // 檢查用戶是否為 admin，如果不是則返回 403 未授權
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // 查找對應的商品
        $product = Product::findOrFail($id);

        // 刪除商品圖片 (如果需要刪除圖片文件)
        if (Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }

        // 刪除商品
        $product->delete();

        // 重定向回商品列表頁面並顯示成功訊息
        return redirect()->route('products.index')->with('success', '商品刪除成功');
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
}

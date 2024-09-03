<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // 顯示購物車頁面，並計算總金額
    public function index()
    {
        // 獲取購物車數據
        $cart = Session::get('cart', []);
        $totalAmount = 0;

        // 計算購物車中所有商品的總金額
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // 返回視圖，並傳遞購物車數據和總金額
        return view('cart.index', compact('cart', 'totalAmount'));
    }

    // 添加商品到購物車
    public function add(Product $product)
    {
        $cart = Session::get('cart', []);

        // 如果商品已經在購物車中，增加數量
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            // 否則，將商品添加到購物車
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        // 保存購物車到 Session 中
        Session::put('cart', $cart);

        // 重定向到購物車頁面
        return redirect()->route('cart.index');
    }

    // 從購物車中移除商品
    public function remove(Product $product)
    {
        $cart = Session::get('cart', []);

        // 如果商品存在於購物車中，則移除它
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
        }

        // 保存變更後的購物車
        Session::put('cart', $cart);

        // 重定向到購物車頁面
        return redirect()->route('cart.index');
    }

    // 更新購物車中的商品數量
    public function update(Request $request)
    {
        $cart = Session::get('cart', []);
        $productId = $request->product_id;

        // 如果商品存在於購物車中，更新數量
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            Session::put('cart', $cart);

            // 計算商品的小計和總金額
            $itemTotal = $cart[$productId]['price'] * $cart[$productId]['quantity'];
            $totalAmount = 0;
            foreach ($cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // 返回 JSON 響應給前端
            return response()->json([
                'itemTotal' => $itemTotal,
                'totalAmount' => $totalAmount,
            ]);
        }

        // 如果商品未找到，返回錯誤信息
        return response()->json(['error' => 'Product not found in cart'], 404);
    }

    // 清空購物車
    public function clear()
    {
        // 清空 Session 中的購物車數據
        Session::forget('cart');

        // 重定向到購物車頁面
        return redirect()->route('cart.index');
    }
}

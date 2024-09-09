<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;



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
                'id' => $product->id,  // 添加商品 ID
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
    public function checkout(Request $request)
    {
        // 檢查用戶是否登入
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', '請先登入後再進行結帳');
        }

        $user = auth()->user();
        DB::beginTransaction();

        try {
            $cart = session()->get('cart', []);
            $totalAmount = 0;

            // 計算購物車中的商品總金額
            foreach ($cart as $item) {
                if (!isset($item['id'])) {
                    DB::rollBack();
                    return redirect()->back()->with('error', '購物車數據錯誤');
                }

                $product = Product::find($item['id']);
                if (!$product) {
                    DB::rollBack();
                    return redirect()->back()->with('error', '找不到商品');
                }

                if ($product->stock < $item['quantity']) {
                    DB::rollBack();
                    return redirect()->back()->with('error', '庫存不足');
                }

                // 累加商品的總價格
                $totalAmount += $product->price * $item['quantity'];
            }

            // 檢查用戶點數是否足夠
            if ($user->points < $totalAmount) {
                DB::rollBack();
                return redirect()->back()->with('error', '點數不足，無法結帳');
            }

            // 創建訂單
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'completed',
            ]);

            // 扣除商品庫存並扣除用戶點數，並記錄訂單項目
            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                $product->stock -= $item['quantity'];
                $product->save();

                // 創建訂單項目，包含商品名稱快照
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'product_name' => $product->name, // 這裡添加商品名稱
                ]);
            }

            // 扣除用戶的點數
            $user->points -= $totalAmount;
            $user->save();

            DB::commit();

            // 清空購物車
            session()->forget('cart');

            return redirect()->route('cart.index')->with('success', '結帳成功，點數已扣除');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('結帳失敗: ' . $e->getMessage());
            return redirect()->back()->with('error', '結帳失敗，請稍後再試');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction(); // 開啟數據庫事務

        try {
            // 從 session 中取得購物車數據
            $cart = session()->get('cart', []);
            $user = auth()->user(); // 獲取當前登入的用戶
            $totalAmount = 0;

            // 計算購物車中所有商品的總金額
            foreach ($cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // 創建訂單
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
            ]);

            // 確保訂單創建成功，然後創建訂單項目
            if ($order) {
                foreach ($cart as $item) {
                    // 查找商品，確保商品存在
                    $product = Product::find($item['id']);
                    if ($product) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id, // 確保是從產品表取得產品ID
                            'quantity' => $item['quantity'],
                            'price' => $product->price, // 確保儲存產品的價格
                            'product_name' => $product->name, // 儲存商品名稱快照
                        ]);
                    } else {
                        // 如果找不到商品，回滾事務並返回錯誤
                        DB::rollBack();
                        return redirect()->back()->with('error', '找不到商品，請稍後再試');
                    }
                }

                // 成功創建訂單後，提交事務
                DB::commit();
                session()->forget('cart'); // 清空購物車
                return redirect()->route('orders.show', $order->id)->with('success', '訂單成功建立');
            } else {
                // 如果訂單創建失敗，回滾事務
                DB::rollBack();
                return redirect()->back()->with('error', '無法創建訂單，請稍後再試');
            }
        } catch (\Exception $e) {
            // 如果發生異常，回滾事務
            DB::rollBack();
            \Log::error('訂單創建失敗: ' . $e->getMessage());
            return redirect()->back()->with('error', '無法創建訂單，請稍後再試');
        }
    }

    public function show($id)
    {
        // 獲取訂單並加載相關的訂單項目
        $order = Order::with('items')->find($id);
        return view('orders.show', compact('order'));
    }

    public function index()
    {
        // 獲取當前用戶的所有訂單
        $orders = Order::where('user_id', auth()->id())->get();

        // 傳遞訂單數據到視圖
        return view('orders.index', compact('orders'));
    }
}

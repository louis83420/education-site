<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class SyncProductsFromCloud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-products-from-cloud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步產品數據從雲端到本地';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 設定你的雲端 API 的 URL
        $cloudApiUrl = 'https://joychiao.com/api/products';

        // 向雲端 API 發送請求，獲取產品數據
        $response = Http::get($cloudApiUrl);

        // 檢查請求是否成功
        if ($response->successful()) {
            // 獲取 API 返回的產品數據
            $products = $response->json();

            // 將每個產品保存到本地資料庫
            foreach ($products as $productData) {
                Product::updateOrCreate(
                    ['name' => $productData['name']], // 根據產品名稱更新或創建產品
                    [
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'stock' => $productData['stock'],
                        'image' => $productData['image'],
                    ]
                );
            }

            // 命令執行成功後的訊息
            $this->info('Products synchronized successfully.');
        } else {
            // 如果請求失敗，輸出錯誤訊息
            $this->error('Failed to synchronize products from cloud.');
        }
    }
}

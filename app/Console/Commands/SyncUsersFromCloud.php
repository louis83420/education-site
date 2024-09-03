<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class SyncUsersFromCloud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-users-from-cloud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 設定你的雲端 API 的 URL
        $cloudApiUrl = 'https://joychiao.com/api/new-users';

        // 向雲端 API 發送請求，獲取新註冊的用戶數據
        $response = Http::get($cloudApiUrl);

        // 檢查請求是否成功
        if ($response->successful()) {
            // 獲取 API 返回的用戶數據
            $users = $response->json();

            // 將每個用戶保存到本地資料庫
            foreach ($users as $userData) {
                User::updateOrCreate(
                    ['email' => $userData['email']], // 根據 email 更新或創建用戶
                    [
                        'name' => $userData['name'],
                        'password' => bcrypt($userData['password']), // 確保密碼被加密
                        // 添加其他必要的字段
                    ]
                );
            }

            // 命令執行成功後的訊息
            $this->info('Users synchronized successfully.');
        } else {
            // 如果請求失敗，輸出錯誤訊息
            $this->error('Failed to synchronize users from cloud.');
        }
    }
}

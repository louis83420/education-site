<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SyncProductsFromCloud;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // 在這裡註冊自定義命令
        \App\Console\Commands\SyncUsersFromCloud::class,
        \App\Console\Commands\SyncProductsFromCloud::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // 設置調度任務，例如每小時執行一次同步任務
        $schedule->command('app:sync-users-from-cloud')->hourly();
        $schedule->command('app:sync-products-from-cloud')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // 自動加載位於 app/Console/Commands 目錄下的命令
        $this->load(__DIR__ . '/Commands');

        // 加載 routes/console.php 文件中的命令
        require base_path('routes/console.php');
    }
}

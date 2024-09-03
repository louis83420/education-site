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
    protected $description = 'Synchronize users from cloud to local database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->syncUsers();
    }

    /**
     * Sync users from the cloud.
     */
    protected function syncUsers()
    {
        $cloudApiUrl = 'https://joychiao.com/api/new-users';

        $response = Http::get($cloudApiUrl);

        if ($response->successful()) {
            $users = $response->json();

            foreach ($users as $userData) {
                User::updateOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'password' => bcrypt($userData['password']),
                        // 添加其他必要的字段
                    ]
                );
            }

            $this->info('Users synchronized successfully.');
        } else {
            $this->error('Failed to synchronize users from cloud.');
        }
    }
}

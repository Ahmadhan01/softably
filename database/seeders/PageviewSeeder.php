<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pageview;
use Carbon\Carbon;

class PageviewSeeder extends Seeder
{
    public function run(): void
    {
        $paths = ['admin/dashboard', 'home', 'linktree/user1', 'linktree/user2'];

        foreach ($paths as $path) {
            for ($i = 0; $i < 7; $i++) {
                Pageview::create([
                    'path' => $path,
                    'viewed_at' => Carbon::now()->subDays($i)->setTime(rand(0, 23), rand(0, 59)),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Link;
use Illuminate\Support\Str;

class LinkSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = User::where('role', 'seller')->get();

        foreach ($sellers as $seller) {
            Link::factory()->count(3)->create([
                'user_id' => $seller->id,
                'status' => 'active',
            ]);
        }
    }
}

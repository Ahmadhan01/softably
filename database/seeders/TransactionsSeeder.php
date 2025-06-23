<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Carbon;

class TransactionsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => rand(5000, 100000),
                    'status' => 'completed',
                    'created_at' => Carbon::now()->subDays(rand(0, 30)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}


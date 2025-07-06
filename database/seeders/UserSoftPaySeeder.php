<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSoftPaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh: Beri saldo 1.000.000 kepada user dengan ID 1
        User::find(2)->update(['softpay_balance' => 1000000.00]);
        // Atau untuk semua user
        // User::all()->each(function ($user) {
        //     $user->update(['softpay_balance' => 500000.00]);
        // });
    }
}
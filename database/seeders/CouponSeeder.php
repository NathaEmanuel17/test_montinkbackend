<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $users = User::factory()->count(5)->create();
        }

        for ($i = 0; $i < 20; $i++) {
            Coupon::create([
                'code' => strtoupper(Str::random(8)),
                'discount' => rand(5, 50),
                'min_value' => rand(50, 500),
                'expires_at' => Carbon::now()->addDays(rand(-10, 30)),
                'status' => rand(0, 1),
                'user_id' => $users->random()->id,
            ]);
        }
    }
}

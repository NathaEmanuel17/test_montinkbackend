<?php

namespace App\Jobs;

use App\Models\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ExpireOldCoupons implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Coupon::where('status', true)
            ->whereDate('expires_at', '<', Carbon::today())
            ->update(['status' => false]);
    }
}

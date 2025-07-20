<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExpireCoupons extends Command
{
    protected $signature = 'coupons:expire';
    protected $description = 'Desativa cupons expirados automaticamente';

    public function handle(): int
    {
        $count = Coupon::where('status', true)
            ->whereDate('expires_at', '<', Carbon::today())
            ->update(['status' => false]);

        $this->info("{$count} cupom(ns) expirado(s) com sucesso.");

        return Command::SUCCESS;
    }
}

<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class OrderProcess implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 4;
    public $maxEceptions = 2;

    public function __construct(
        public User $user,
        public array $req,
    ) {
    }

    public function handle(): void
    {
        Log::info('order-process-' . $this->user->id);
        Redis::funnel('order-process-' . $this->user->id)
            ->limit(1)
            ->block(0)
            ->releaseAfter(1 * 60)
            ->then(function () {
                DB::beginTransaction();

                Order::create([
                    'user_id' => $this->user->id,
                    'amount' => $this->req['amount'],
                    'status' => 'success',
                    'timestamp' => $this->req['timestamp'] ?? now()->format('Y-m-d H:i:s.v'),
                ]);

                $this->user->balance += $this->req['amount'];
                $this->user->save();

                DB::commit();
            }, function () {
                DB::rollBack();
                return $this->release(1 * 60);
            });
    }
}

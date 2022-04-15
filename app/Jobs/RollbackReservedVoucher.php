<?php

namespace App\Jobs;

use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RollbackReservedVoucher implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * The voucher instance.
     *
     * @var \App\Models\Voucher
     */
    protected $voucher;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $voucher = $this->voucher;
        if(!$voucher->redeemable && !$voucher->photo) {
            $voucher->customer()->disassociate($voucher->customer->id);
            $voucher->reserved_datetime = null;
            $voucher->max_upload_datetime = null;
            $voucher->save();
        }
    }
}

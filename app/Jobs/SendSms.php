<?php

namespace App\Jobs;

use App\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
protected $sms;
public $tries=5;
    /**
     * Create a new job instance.
     *
     * @param Sms $sms
     */
    public function __construct(Sms $sms)
    {
        $this->sms=$sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Sms::send($this->sms);
    }
}

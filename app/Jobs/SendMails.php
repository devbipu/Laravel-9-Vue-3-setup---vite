<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use App\Mail\NotifyUser;
use Illuminate\Support\Facades\Mail;



class SendMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data = null)
    {
        $this->data = $data;
        //Log::info("mailSended jobs log");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($data)
    {
        //Queue work here 
    }
}

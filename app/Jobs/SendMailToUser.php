<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;

class SendMailToUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Data to be send 
     * @return 0
     */
    public $datas;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($datas)
    {
        $this->datas = $datas; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //execute the job works 
        
        $userNotify = Mail::to('devbipu@gmail.com')->queue(new VerificationMail($this->datas));
    }
}

<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Queueable;

    protected $emailDetails;

    /**
     * Create a new job instance.
     */
    public function __construct($emailDetails)
    {
        $this->emailDetails = $emailDetails;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('send_email_job_handle:');
        Log::info($this->emailDetails);
        // Mail::to($this->emailDetails['to_email'])->send(new \App\Mail\YourMailable($this->emailDetails));
    }
}

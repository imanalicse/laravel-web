<?php

namespace App\Console\Commands;

class SendEmailsCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a marketing email to a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = $this->argument('user');
        $this->customLog('Send email user: '. $user, 'send_email', 'command');
    }
}

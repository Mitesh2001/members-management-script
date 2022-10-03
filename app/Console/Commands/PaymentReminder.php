<?php

namespace App\Console\Commands;

use App\Jobs\PaymentReminderJob;
use Illuminate\Console\Command;

class PaymentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paymentreminder:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an automatic reminder email of Members which plan expire soon and expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        PaymentReminderJob::dispatch();
    }
}

<?php

namespace App\Jobs;

use App\Mail\PaymentReminder as PaymentMail;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PaymentReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $members = Member::select('id', 'email', 'first_name', 'last_name', 'validity_date')
            ->whereDate('validity_date', '<', (new Carbon)->addDays(10))
            ->orderBy('validity_date')
            ->get()
        ;

        foreach ($members as $member) {
            Mail::to($member->email)->send(new PaymentMail($member));
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Mails\SubscriptionAboutToExpired;
use App\Mails\SubscriptionExpired;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class QuickCronHourly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:quick-cron-hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run QuickCMS Cron Job Hourly';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* Delete old unpaid transactions */
        Transaction::where('created_at', '<=', Carbon::now()->subHours(3))
            ->where('status', Transaction::STATUS_UNPAID)
            ->delete();


        /* Send notification on membership expiring soon */
        if (email_template('subscription_about_expired')->status) {

            $future_date = Carbon::now()->addDays(5);

            $users = User::where([
                ['status', 1],
                ['plan_id', '!=', 'free'],
                ['plan_about_to_expire_reminder', false],
                ['plan_expiration_date', '<=', $future_date]
            ])->get();

            foreach ($users as $user) {
                $user->sendMail(new SubscriptionAboutToExpired($user));
                $user->update(['plan_about_to_expire_reminder' => true]);
            }
        }

        /* Reset user's plan and send email */
        $users = User::where([
            ['plan_id', '!=', 'free'],
            ['plan_expiration_date', '<=', Carbon::now()]
        ])->get();

        foreach ($users as $user) {
            if (email_template('subscription_expired')->status) {
                $user->sendMail(new SubscriptionExpired($user));
            }

            $user->update([
                'plan_id' => 'free',
                'plan_settings' => config('settings.free_membership_plan')->settings,
                'plan_expiration_date' => null,
                'plan_interval' => null,
            ]);
        }

        return 0;
    }
}

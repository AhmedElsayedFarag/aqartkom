<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Subscription\Entities\Subscription;

class ExpireSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire subscriptions that are expired';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Subscription::where('status', 'approved')
            ->where('end_at', '<', now())
            ->update(['status' => 'expired']);

        return Command::SUCCESS;
    }
}
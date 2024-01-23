<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemoveFeaturedAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:expired-feature-ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove expired featured ads from the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Modules\Ad\Entities\Ad::where('is_featured', true)
            ->where('featured_expires_at', '<', now())
            ->update(['is_featured' => false, 'featured_expires_at' => null, 'featured_at' => null]);

        return Command::SUCCESS;
    }
}
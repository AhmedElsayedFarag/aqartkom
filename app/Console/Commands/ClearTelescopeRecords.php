<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearTelescopeRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:telescope-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear telescope records';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \DB::table('telescope_entries')->truncate();
        \DB::table('telescope_entries_tags')->truncate();
        \DB::table('telescope_monitoring')->truncate();
        return Command::SUCCESS;
    }
}
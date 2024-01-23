<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Ad\Entities\Ad;
use Modules\Auction\Entities\Auction;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SitemapGenerator::create(config('app.url'))
            ->getSitemap()
            ->add(Ad::all())
            ->add(Auction::all())
            ->writeToFile(public_path('sitemap.xml'));
        return Command::SUCCESS;
    }
}
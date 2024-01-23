<?php

namespace App\Console\Commands;

use App\Jobs\UploadMediaJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Modules\Estate\Entities\Estate;

class MoveEstateMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:estate-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move Estate Media from local to s3';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Estate::select(['id'])->with(['media'])->chunk(100, function ($estates) {
            UploadMediaJob::dispatch($estates)->onQueue('upload-media');
        });
        return Command::SUCCESS;
    }
}

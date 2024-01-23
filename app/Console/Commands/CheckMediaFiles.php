<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Modules\Estate\Entities\EstateMedia;
use Modules\Media\Entities\Media;

class CheckMediaFiles extends Command
{
    protected $signature = 'media:check';

    protected $description = 'Check if media files exist and insert missing names into a text file';

    public function handle()
    {
        $mediaDirectory = storage_path('app/public/media'); // Update this with the path to your media directory

        $mediaFiles = File::allFiles($mediaDirectory);

        $missingFiles = [];
        EstateMedia::query()->chunk(500, function ($media) {
            foreach ($media as $m) {
                if (!File::exists(\public_path($m->url))) {
                    $missingFiles[] = $m->url;
                }
            }
        });
        // Insert missing file names into the text file
        File::put(storage_path('app/public/missing_files.txt'), implode("\n", $missingFiles));

        $this->info('Media files checked and missing files written to the text file.');
    }
}

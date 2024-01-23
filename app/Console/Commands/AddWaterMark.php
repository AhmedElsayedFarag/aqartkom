<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Estate\Entities\EstateMedia;

class AddWaterMark extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:water-mark';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add watermarks to all images in the media folder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        EstateMedia::query()->where('is_converted', false)->where('type', 'image')->chunk(500, function ($images) {
            foreach ($images as $image) {
                $img = \Image::make(public_path($image->url));
                $img->insert(public_path('watermark.png'), 'bottom-right', 10, 10);
                $img->save(public_path($image->url));
                $image->update(['is_converted' => true]);
            }
        });
        return Command::SUCCESS;
    }
}

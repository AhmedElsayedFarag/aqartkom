<?php

use Modules\Media\Services\LocalMediaService;

uses(Tests\TestCase::class);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Services\RemoteMediaService;

test('test_files_is_stored_in_local', function () {
    $service = new LocalMediaService();
    $file = UploadedFile::fake()->image('avatar.jpg');
    $service->store($file, 'media');
    Storage::disk("media")->assertExists($file->hashName());
});
// test('test_files_is_stored_in_remote', function () {
//     $service = new RemoteMediaService();
//     $file = UploadedFile::fake()->image('avatar.jpg');
//     Storage::disk("s3")->assertExists($service->store($file, 'media'));
// });

test('test_files_is_deleted_from_local', function () {
    $service = new LocalMediaService();
    $file = UploadedFile::fake()->image('avatar.jpg');
    $url = $service->store($file, 'media');
    $service->delete($url);
    $this->assertFalse(Storage::exists($url));
});
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;

use Illuminate\Support\Facades\Notification;
use Modules\Notification\DataTransferObjects\NotificationDto;
use Modules\Notification\Services\NotificationsService;
use Illuminate\Support\Str;

class AddNotificationsToUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public NotificationDto $notificationDto,
        public string $userType,
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table('users')->where('type', $this->userType)->orderBy('id')
            ->chunk(100, function ($users) {
                $formattedNotifications = [];
                foreach ($users as $user) {

                    $formattedNotifications[] = [
                        'id' => Str::uuid(),
                        'type' => $this->notificationDto->type,
                        'notifiable_id' => $user->id,
                        'notifiable_type' => User::class,
                        'data' => \json_encode([
                            'title' =>  $this->notificationDto->title,
                            'body' =>  $this->notificationDto->body,
                        ]),
                        'created_at' => now()->toDateTimeString(),
                        'updated_at' => now()->toDateTimeString(),
                    ];
                }
                DB::table('notifications')->insert($formattedNotifications);
            });
    }
}
<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;
use Illuminate\Support\Str;

class AdminNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithBroadcasting;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public string $message,
    ) {
        //get admins and send notification to them
        $admins = User::role('admin')->select(['id'])->get();
        foreach ($admins as $user) {

            $formattedNotifications[] = [
                'id' => Str::uuid(),
                'type' =>
                'Modules\Notification\Notifications\SendAdminNotification',
                'notifiable_id' => $user->id,
                'notifiable_type' => User::class,
                'data' => \json_encode([
                    'title' =>  $message,
                    'body' =>  $message,
                ]),
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];
        }
        DB::table('notifications')->insert($formattedNotifications);

        $this->broadcastVia('admin_pusher');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('AdminNotificationChannel');
    }

    public function broadcastAs()
    {
        return 'AdminNotificationEvent';
    }
}
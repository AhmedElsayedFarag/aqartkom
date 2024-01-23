<?php

namespace App\Notifications;

use App\DataTransferObjects\FCMDTO;
use App\Helpers\FCMHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdIsAcceptedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public string $token)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $notification = [
            "body" => __('messages.ad_is_accepted'),
            "title" => __('messages.ad_is_accepted'),

        ];
        $dto = new FCMDTO(
            $notification['title'],
            $notification['body'],
            $this->token
        );
        FCMHelper::sendMessage($dto);
        $notification['is_accepted'] = true;
        return $notification;
    }
}
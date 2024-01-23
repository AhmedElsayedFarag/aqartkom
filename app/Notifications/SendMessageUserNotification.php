<?php

namespace App\Notifications;

use App\DataTransferObjects\FCMDTO;
use App\Helpers\FCMHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMessageUserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public string $token, public string $title, public string $body)
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
            "body" => $this->body,
            "title" => $this->title,

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

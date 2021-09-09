<?php

namespace Modules\Message\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Registrant\Entities\Registrant;

class SendStageEmailToRegistrant extends Notification implements ShouldQueue
{
    use Queueable;

    public $registrant;
    public $messageLine;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($registrant, $messageLine)
    {
        $this->messageLine = $messageLine;
        $this->registrant = $registrant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Untuk '.$this->registrant->name.' di tempat,')
                    ->subject('PPDB Yayasan Pendidikan Warga')
                    ->line(new HtmlString(nl2br($this->messageLine, false)));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

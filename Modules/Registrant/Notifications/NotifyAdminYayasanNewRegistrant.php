<?php

namespace Modules\Registrant\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Modules\Registrant\Entities\Registrant;

class NotifyAdminYayasanNewRegistrant extends Notification
{
    use Queueable;

    public $registrant;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Registrant $registrant)
    {
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
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
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

    /**
     * Send to notification database
     *
     * @param mixed $notifiable
     * @return array
     */

    public function toDatabase($notifiable)
    {
        $registrant = $this->registrant;
        $user = $notifiable;

        $text = 'Pendaftar Baru | <strong>'.$registrant->name.'</strong> dengan ID <strong>'.$registrant->registrant_id.'</strong>  dibuat oleh <strong>'.auth()->user()->name.'</strong>';

        return [
            'title'         => 'Pendaftar Baru!',
            'module'        => 'Registrant',
            'type'          => 'created',
            'icon'          => 'fas fa-feather-alt',
            'text'          => $text,
            'url_backend'   => '',
            'url_frontend'  => '',
        ];
    }
}

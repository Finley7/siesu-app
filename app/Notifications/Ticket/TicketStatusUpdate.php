<?php

namespace App\Notifications\Ticket;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketStatusUpdate extends Notification
{
    use Queueable;
    private Ticket $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        #TODO: Use localization function
        return (new MailMessage)
            ->line('De status van ticket ' . $this->ticket->title . ' is bijgewerkt')
            ->line('De huidige status is: ' . $this->ticket->status)
            ->action('Je kunt het ticket hier bekijken', route('ticket.view', ['ticket' => $this->ticket]))
            ->line(__('Deze e-mail kan niet beantwoord worden'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

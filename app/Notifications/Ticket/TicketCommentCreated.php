<?php

namespace App\Notifications\Ticket;

use App\Models\TicketComment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCommentCreated extends Notification
{
    use Queueable;

    private TicketComment $ticketComment;

    /**
     * Create a new notification instance.
     */
    public function __construct(TicketComment $ticketComment)
    {
        $this->ticketComment = $ticketComment;
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
            ->line('Gebruiker ' . $this->ticketComment->author->name . ' reageerde op ticket ' . $this->ticketComment->ticket->title)
            ->line('"' . strip_tags($this->ticketComment->body) . '"')
            ->action('Je kunt het ticket hier bekijken', route('ticket.view', ['ticket' => $this->ticketComment->ticket]))
            ->line('Deze e-mail kan niet beantwoord worden');
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

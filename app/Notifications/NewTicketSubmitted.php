<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Notifications\Notification;

class NewTicketSubmitted extends Notification
{

    public function __construct(public Ticket $ticket) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "New ticket from {$this->ticket->user->name}: {$this->ticket->subject}",
            'url'     => route('officer.tickets.show', $this->ticket),
            'type'    => 'ticket_new',
        ];
    }

}

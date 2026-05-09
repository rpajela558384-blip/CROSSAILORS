<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Notifications\Notification;

class TicketStatusChanged extends Notification
{

    public function __construct(
        public Ticket $ticket,
        public string $oldStatus,
        public string $newStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "Ticket \"{$this->ticket->subject}\" status changed to {$this->newStatus}",
            'url'     => route('tickets.show', $this->ticket),
            'type'    => 'ticket_status',
        ];
    }

}

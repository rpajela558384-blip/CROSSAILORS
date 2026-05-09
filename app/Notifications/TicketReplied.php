<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Notifications\Notification;

class TicketReplied extends Notification
{

    public function __construct(
        public Ticket $ticket,
        public TicketReply $reply
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "{$this->reply->user->name} replied to your ticket: {$this->ticket->subject}",
            'url'     => route('tickets.show', $this->ticket),
            'type'    => 'ticket_reply',
        ];
    }

}

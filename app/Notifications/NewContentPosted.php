<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class NewContentPosted extends Notification
{

    public function __construct(
        public string $contentType,
        public string $title
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "New {$this->contentType}: {$this->title}",
            'url'     => route('home'),
            'type'    => "content_{$this->contentType}",
        ];
    }

}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DocumentSentNotification extends Notification
{
    use Queueable;

    protected $document;

    /**
     * Create a new notification instance.
     */
    public function __construct($document)
    {
        $this->document = $document;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'document_id' => $this->document->id,
            'document_type' => $this->document->document_type,
            'taxpayer_name' => $this->document->taxpayer_name,
            'docket_owner' => $this->document->docket_owner,
            'recipient_office' => $this->document->recipient_office,
            'time_sent' => $this->document->time_sent,
        ];
    }
}

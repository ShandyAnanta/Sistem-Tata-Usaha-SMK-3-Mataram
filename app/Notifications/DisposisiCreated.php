<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DisposisiCreated extends Notification
{
    use Queueable;

    public function __construct(public int $suratMasukId, public string $perihal, public string $instruksi)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'disposisi',
            'surat_masuk_id' => $this->suratMasukId,
            'perihal' => $this->perihal,
            'instruksi' => $this->instruksi,
        ];
    }
}

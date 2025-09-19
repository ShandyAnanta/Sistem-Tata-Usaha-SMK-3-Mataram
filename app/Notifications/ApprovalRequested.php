<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApprovalRequested extends Notification
{
    use Queueable;

    public function __construct(public int $suratKeluarId, public string $perihal, public int $level)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'approval_request',
            'surat_keluar_id' => $this->suratKeluarId,
            'perihal' => $this->perihal,
            'level' => $this->level,
        ];
    }
}

<?php

namespace App\Listeners;

use App\Events\CaseUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CaseUpdatedNotification;
use App\Notifications\SendTelegramGif;
use NotificationChannels\Telegram\TelegramChannel;

class CaseSpreadNotification
{
    /**
     * Handle the event.
     *
     * @param  CaseUpdated  $event
     * @return void
     */
    public function handle(CaseUpdated $event)
    {

        $message = '';
        $message .= "\nTotal Kasus *bertambah* {$event->kasus->new_case} orang, dari ".($event->kasus->total_case - $event->kasus->new_case)." menjadi {$event->kasus->total_case}.\n";
        $message .= "\nPasien sembuh *bertambah* {$event->kasus->new_recovered} orang, dari ".($event->kasus->total_recovered - $event->kasus->new_recovered)." menjadi {$event->kasus->total_recovered}.\n";
        $message .= "\nPasien meninggal *bertambah* {$event->kasus->new_death} orang, dari ".($event->kasus->total_death - $event->kasus->new_death)." menjadi {$event->kasus->total_death}.\n";
        $message .= "\nTotal dirawat menjadi {$event->kasus->total_case} orang.\n";

        $message .= "\n\nTetap waspada, dan jangan panik ya guys...";

        Notification::route(TelegramChannel::class, config('services.telegram-bot-api.channel'))
            ->notify(new CaseUpdatedNotification($message));
    }
}

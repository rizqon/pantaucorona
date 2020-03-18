<?php

namespace App\Listeners;

use App\Events\CaseUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CaseUpdatedNotification;
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

        if(
            $event->oldcase->total_case != $event->newcase->total_case ||
            $event->oldcase->new_case != $event->newcase->new_case ||
            $event->oldcase->total_death != $event->newcase->total_death ||
            $event->oldcase->new_death != $event->newcase->new_death ||
            $event->oldcase->total_recovered != $event->newcase->total_recovered ||
            $event->oldcase->new_recovered != $event->newcase->new_recovered ||
            $event->oldcase->active_case != $event->newcase->active_case
        )
        {
            $oldcase = $event->oldcase;
            $newcase = $event->newcase;

            $message = '';
            if($oldcase->total_case != $newcase->total_case)
            {
                if( $oldcase->total_case < $newcase->total_case)
                {
                    $message .= "\nTotal Kasus *bertambah* {$newcase->new_case} orang, dari {$oldcase->total_case} menjadi {$newcase->total_case}. \n";
                }
            }

            if($oldcase->total_recovered != $newcase->total_recovered)
            {
                if( $oldcase->total_recovered < $newcase->total_recovered)
                {
                    $message .= "\nPasien sembuh *bertambah* {$newcase->new_recovered} orang, dari {$oldcase->total_recovered} menjadi {$newcase->total_recovered}. \n";
                }else {
                    $message .= "\nPasien sembuh *berkurang* dari {$oldcase->total_recovered} orang, menjadi {$newcase->total_recovered}. \n";
                }
            }

            if($oldcase->total_death != $newcase->total_death)
            {
                if( $oldcase->total_death < $newcase->total_death)
                {
                    $message .= "\nPasien meninggal *bertambah* {$newcase->new_death} orang, dari {$oldcase->total_death} menjadi {$newcase->total_death}. \n";
                }else {
                    $message .= "\nPasien meninggal *berkurang* dari {$oldcase->total_death} menjadi {$newcase->total_death}. \n";
                }
            }

            if($oldcase->active_case != $newcase->active_case)
            {
                if( $oldcase->active_case < $newcase->active_case)
                {
                    $message .= "\nTotal dirawat *bertambah*, dari {$oldcase->active_case} menjadi {$newcase->active_case}. \n";
                }elseif ($newcase->active_case < $oldcase->active_case) {
                    $message .= "\nTotal dirawat *berkurang*, dari {$oldcase->active_case} menjadi {$newcase->active_case}. \n";
                }
            }
            

            $message .= "\n\nTetap waspada, dan jangan panik ya guys...";

            Notification::route(TelegramChannel::class, '@pantaucorona')
                ->notify(new CaseUpdatedNotification($message));
        }
    }
}

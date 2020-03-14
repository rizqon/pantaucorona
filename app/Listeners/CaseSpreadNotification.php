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
            $event->oldcase->active_case != $event->newcase->active_case ||
            $event->oldcase->critical_case != $event->newcase->critical_case
        )
        {
            $oldcase = $event->oldcase;
            $newcase = $event->newcase;

            $message = '';
            if($oldcase->total_case != $newcase->total_case)
            {
                if( $oldcase->total_case < $newcase->total_case)
                {
                    $message .= "Total Kasus *bertambah* {$newcase->new_case} orang, dari {$oldcase->total_case} menjadi {$newcase->total_case}. \n";
                }
            }

            if($oldcase->total_recovered != $newcase->total_recovered)
            {
                if( $oldcase->total_recovered < $newcase->total_recovered)
                {
                    $message .= "Pasien sembuh *bertambah* dari {$oldcase->total_recovered} menjadi {$newcase->total_recovered}. \n";
                }else {
                    $message .= "Pasien sembuh *berkurang* dari {$oldcase->total_recovered} menjadi {$newcase->total_recovered}. \n";
                }
            }

            if($oldcase->total_death != $newcase->total_death)
            {
                if( $oldcase->total_death < $newcase->total_death)
                {
                    $message .= "Pasien meninggal *bertambah* dari {$oldcase->total_death} menjadi {$newcase->total_death}. \n";
                }else {
                    $message .= "Pasien meninggal *berkurang* dari {$oldcase->total_death} menjadi {$newcase->total_death}. \n";
                }
            }

            if( $oldcase->active_case < $newcase->active_case)
            {
                $message .= "\nTotal kasus aktive *bertambah*, dari {$oldcase->active_case} menjadi {$newcase->active_case}. \n";
            }elseif ($oldcase->active_case < $newcase->active_case) {
                $message .= "\nTotal kasus aktive *berkurang*, dari {$oldcase->active_case} menjadi {$newcase->active_case}. \n";
            }else
            {
                $message .= "\nTotal kasus aktive *Tetap* {$newcase->active_case} kasus. \n";
            }

            $message .= "\n\nTetap waspada, dan jangan panik ya guys...";

            Notification::route(TelegramChannel::class, '@pantaucorona')
                ->notify(new CaseUpdatedNotification($message));
        }
    }
}

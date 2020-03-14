<?php

namespace App\Events;

use App\Kasus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CaseUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $oldcase;

    public $newcase;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Kasus $oldcase, Kasus $newcase)
    {
        $this->oldcase = $oldcase;
        $this->newcase = $newcase;
    }
}

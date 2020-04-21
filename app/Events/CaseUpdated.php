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

    public $kasus;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Kasus $kasus)
    {
        $this->kasus = $kasus;
    }
}

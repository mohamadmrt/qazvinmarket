<?php

namespace App\Events;

use App\Sms;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActivation
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
public $sms;

    /**
     * Create a new event instance.
     *
     * @param Sms $sms
     */
    public function __construct(Sms $sms)
    {
        $this->sms=$sms;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

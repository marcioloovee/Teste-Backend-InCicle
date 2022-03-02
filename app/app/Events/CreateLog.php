<?php

namespace App\Events;

use App\Models\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateLog implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public string $action,
        public array $description
    )
    {
        $this->action = $action;
        $this->description = $description;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('channel-create-log');
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'CreateLog';
    }

    /**
     * @return array
     */
    public function broadcastWith()
    {
        $data = [
            'action'      => $this->action,
            'description' => json_encode($this->description)
        ];

        (new Log())->create($data);

        return $data;
    }
}

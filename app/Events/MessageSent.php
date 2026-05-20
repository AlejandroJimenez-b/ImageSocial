<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastWith(): array
    {
        return [
            'id'         => $this->message->id,
            'content'    => $this->message->content,
            'sender_id'  => $this->message->sender_id,
            'sender'     => [
                'id'    => $this->message->sender->id,
                'nick'  => $this->message->sender->nick,
                'image' => $this->message->sender->image,
            ],
            'created_at' => $this->message->created_at->format('H:i'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MessageSent';
    }

    public function broadcastOn(): array
    {
        // Canal privado entre los dos usuarios
        // Ordenamos los IDs para que el canal sea siempre el mismo
        // independientemente de quien envíe
        $ids = collect([
            $this->message->sender_id,
            $this->message->receiver_id
        ])->sort()->values();

        return [
            new PrivateChannel("chat.{$ids[0]}.{$ids[1]}")
        ];
    }
}
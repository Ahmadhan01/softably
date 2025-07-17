<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewChatMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        // Pastikan 'role' juga dimuat di sini
        $this->message = $message->load('sender:id,name,username,role'); // <-- TAMBAHKAN 'role'
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->sender_id),
            new PrivateChannel('chat.' . $this->message->receiver_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'new-message';
    }

    public function broadcastWith(): array
    {
        return [
            'id'           => $this->message->id,
            'sender_id'    => $this->message->sender_id,
            'sender_name'  => $this->message->sender->name,
            'sender_role'  => $this->message->sender->role, // <-- Perbaiki ini: $this->message->sender->role
            'receiver_id'  => $this->message->receiver_id,
            'content'      => $this->message->content,
            'created_at'   => $this->message->created_at->toISOString(),
            'conversation_id' => $this->message->conversation_id,
        ];
    }
}
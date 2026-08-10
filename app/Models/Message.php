<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message',
        'attachment',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function getAttachmentUrlAttribute()
    {
        if (!$this->attachment) {
            return null;
        }

        if (str_starts_with($this->attachment, 'http://') || str_starts_with($this->attachment, 'https://')) {
            return $this->attachment;
        }

        return Storage::url($this->attachment);
    }
}

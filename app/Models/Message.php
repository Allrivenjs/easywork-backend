<?php

namespace App\Models;

use App\Traits\AsReadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    use AsReadTrait;

    protected $casts = [
        'read_at' => 'datetime',
    ];

    protected $fillable = ['message', 'user_id', 'room_id'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}

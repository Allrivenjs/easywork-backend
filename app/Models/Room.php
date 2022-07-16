<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->messages()->orderBy('created_at', 'desc')->limit(1);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'participants');
    }

}

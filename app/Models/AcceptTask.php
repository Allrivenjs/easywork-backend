<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptTask extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'user_id', 'charge', 'remove_at', 'accepted_at', 'paid_out_at'];

    protected $dates = [
        'created_at',
        'updated_at',
        'remove_at',
    ];

    public function task(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

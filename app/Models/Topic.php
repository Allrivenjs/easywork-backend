<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $visible=[
        'id',
        'name',
        'created_at',
        'updated_at'
    ];



    public function tasks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(task::class);
    }
}

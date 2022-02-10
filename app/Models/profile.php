<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class profile extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['ranking', 'slug', 'about', 'user_id'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function images(){
        return $this->morphToMany(Image::class, 'imageable');
    }
    public function files(){
        return $this->morphToMany(Files::class, 'fileable');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function universities(){
        return $this->belongsToMany(university::class);
    }
}

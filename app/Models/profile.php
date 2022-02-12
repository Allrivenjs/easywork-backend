<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function getDeletedAtAttribute($value){
        if ($value==null) return;
        return Carbon::parse($value)->diffForHumans();
    }

    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }
    public function files(){
        return $this->morphMany(Files::class, 'fileable');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function universities(){
        return $this->belongsToMany(university::class);
    }
}

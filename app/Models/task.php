<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\TaskFactory;
use Database\Factories\videoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class task extends Model
{
    use HasFactory;
    protected $fillable=['name','slug','description','difficulty','status_id','own_id','finished_at'];

    protected $dates=[
        'created_at',
        'updated_at',
        'deleted_at',
        'finished_at'
    ];

    /** @return TaskFactory */
    protected static function newFactory()
    {
        return TaskFactory::new();
    }

//    public function getOwnIdAttribute($value){
//
//        return User::query()->find($value)->FullName();
//    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }


    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'own_id')->with('profile');
    }

    public function topics(){
        return $this->belongsToMany(Topic::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function status_last(){
        return $this->hasOne(Status::class)->latest();
    }

    public function files(){
        return $this->morphMany(Files::class, 'fileable');
    }


}

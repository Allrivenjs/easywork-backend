<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function topics(){
        return $this->belongsToMany(Topic::class);
    }

    public function status(){
        return $this->hasOne(Status::class);
    }

    public function status_last(){
        return $this->hasOne(Status::class)->latest();
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\coursesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class course extends Model
{
    use HasFactory;
    use SoftDeletes;
    /** @return coursesFactory */
    protected static function newFactory()
    {
        return coursesFactory::new();
    }


    protected $fillable = ['name','slug','description','owner'];

    public function getOwnerAttribute($value){
        $user= User::query()->findOrFail($value);
        return strtoupper("$user->name $user->lastname");
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function sections(){
        return $this->hasMany(section::class);
    }

    public function owner(){
        return $this->belongsTo(User::class);
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }
}

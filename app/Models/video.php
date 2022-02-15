<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\videoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class video extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['name','url','slug','description','section_id'];

    /** @return videoFactory */
    protected static function newFactory()
    {
        return videoFactory::new();
    }


    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function section(){
        return $this->belongsTo(section::class);
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

}

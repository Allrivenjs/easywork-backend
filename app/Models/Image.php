<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable=['url'];
    protected $hidden=['imageable_id','imageable_type'];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /** @return ImageFactory */
    protected static function newFactory()
    {
        return ImageFactory::new();
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }




    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function imageable(){
        return $this->morphTo();
    }
}

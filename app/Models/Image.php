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
    protected static function newFactory(): ImageFactory
    {
        return ImageFactory::new();
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }




    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function imageable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}

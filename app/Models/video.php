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
    protected static function newFactory(): videoFactory
    {
        return videoFactory::new();
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function section(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(section::class);
    }

    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

}

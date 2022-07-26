<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\sectionsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class section extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'course_id'];

    /** @return sectionsFactory */
    protected static function newFactory(): sectionsFactory
    {
        return sectionsFactory::new();
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(course::class);
    }

    public function videos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(video::class);
    }
}

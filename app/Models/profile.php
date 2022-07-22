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

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getDeletedAtAttribute($value){
        if ($value==null) return;
        return Carbon::parse($value)->diffForHumans();
    }

    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function files(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Files::class, 'fileable');
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function universities(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(university::class);
    }
}

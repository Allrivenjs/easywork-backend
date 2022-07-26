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

    protected $fillable = ['name', 'slug', 'description', 'owner'];

    public function getOwnerAttribute($value): string
    {
        $user = User::query()->findOrFail($value);

        return strtoupper("$user->name $user->lastname");
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function sections(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(section::class);
    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

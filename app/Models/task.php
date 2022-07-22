<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\TaskFactory;

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

    /** @return TaskFactory */
    protected static function newFactory()
    {
        return TaskFactory::new();
    }

//    public function getOwnIdAttribute($value){
//
//        return User::query()->find($value)->FullName();
//    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }


    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'own_id')->with('profile');
    }

    public function topics(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Topic::class);
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function status_last(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->status()->latest();
    }

    public function files(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Files::class, 'fileable');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }
    public function comments_lasted(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->comments()->orderBy('created_at','desc')->take(1);
    }

}

<?php

namespace App\Models;

use App\Jobs\NotificationTaskJob;
use App\Traits\FilesSaveTrait;
use App\Traits\NotificateTrait;
use Carbon\Carbon;
use Database\Factories\TaskFactory;
use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task extends Model
{
    use HasFactory, FilesSaveTrait, NotificateTrait, PivotEventTrait, SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'difficulty', 'status_id', 'own_id', 'finished_at'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'finished_at',
    ];

    const STATUS_CREATED = 1;

    const STATUS_PUBLICADO = 2;

    const STATUS_POR_ASIGNAR = 3;

    const STATUS_ASIGNADO = 4;

    const STATUS_EN_PROCESO = 5;

    const STATUS_FINALIZADO = 6;

    const STATUS_ENTREGADO = 7;

    public static function boot()
    {
        parent::boot();
        if (! \App::runningInConsole()) {
            static::pivotAttached(fn ($model) => self::sendNotification($model));
            static::pivotSynced(fn ($model) => self::sendNotification($model));
        }
    }

    public static function sendNotification($model)
    {
        NotificationTaskJob::dispatch($model)
                  ->onQueue('notifications')
                  ->onConnection('database');
    }

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

//    public function getTasksAttribute($value): string
//    {
//        return route('profile.get.task',['user_id', $this->own_id]);
//    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'own_id')->with(['profile' => ['image']]);
    }

    public function topics(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'task_topic');
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
        return $this->comments()->orderBy('created_at', 'desc');
    }

    public function accept_tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AcceptTask::class);
    }
}

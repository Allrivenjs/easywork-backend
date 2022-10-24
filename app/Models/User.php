<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'birthday',
        'email',
        'password',
        'profile_photo_path',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'roles',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value): ?string
    {
        if ($value == null) {
            return null;
        }

        return Carbon::parse($value)->diffForHumans();
    }

    public function getDeletedAtAttribute($value): ?string
    {
        if ($value == null) {
            return null;
        }

        return Carbon::parse($value)->diffForHumans();
    }

//    public function getBirthdayAttribute($value){
//        return Carbon::parse($value)->format("d-m-y");
//    }

    public function FullName(): string
    {
        return strtoupper("$this->name $this->lastname");
    }

    public function profile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(profile::class);
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(task::class, 'own_id');
    }

    public function tasks_desc(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->tasks()->orderBy('created_at', 'desc');
    }

    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function rooms(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'participants');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'own_id');
    }

    public function tasksAssigned(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AcceptTask::class);
    }
}

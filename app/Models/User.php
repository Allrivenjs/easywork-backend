<?php

namespace App\Models;

use App\Notifications\ApiPasswordResetNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
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
        'profile_photo_path'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function getProfilePhotoPathAttribute($value){
        if ($value==null) return;
        return env('APP_URL').'/storage/'.$value;
    }


    public function getUpdatedAtAttribute($value){
        if ($value==null) return;
        return Carbon::parse($value)->diffForHumans();
    }

    public function getDeletedAtAttribute($value){
        if ($value==null) return;
        return Carbon::parse($value)->diffForHumans();
    }


//    public function getBirthdayAttribute($value){
//        return Carbon::parse($value)->format("d-m-y");
//    }


    public function profile(){
        return $this->hasOne(profile::class);
    }
}

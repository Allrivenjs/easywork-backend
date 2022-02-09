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

class User extends Authenticatable
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


    protected $error_message;

    public function sendPasswordResetLink($user){
        do{
            $token = $this->getResetCode();
            $signature = Hash::make($token);
            $exists =$this->PasswordReset()->where([
                ['user_id', $user->id],
                ["token_signature",$signature]
            ])->exists();
        }while($exists);
        try {
            $user->notify(new ApiPasswordResetNotification($token));
            return $this->PasswordReset()->create([
                "user_id" => $user->id,
                "token_signature" => $signature,
                "expires_at" => Carbon::now()->addMinutes(30)
            ]);
        }catch (\Throwable $th){
            $this->error_message = $th->getMessage();
            return false;
        }
    }
}

<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        //EmailVerification
//        VerifyEmail::toMailUsing(function ($notifiable, $url) {
//            return (new MailMessage)->view('email.email_verify',['url'=>$url]);
//        });
//
//        //ResetPassword route
//        ResetPassword::toMailUsing(function ($notifiable, $token) {
//            return (new MailMessage)->view('email.password_reset',
//                ['url'=> env('APP_URL').'/reset-password/'.$token.'/'.$notifiable->getEmailForPasswordReset()]);
//        });


//        if (! $this->app->routesAreCached()) {
//            Passport::routes();
//        }
        Passport::tokensExpireIn(now()->addDays(1));
    }
}

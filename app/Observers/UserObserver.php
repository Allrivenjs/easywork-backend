<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
//        if(!\App::runningInConsole()){
//            //EmailVerification
//            event(new Registered($user));
//        }

        $random = rand(0, 1000);
        $random2 = rand(2000, 3000);
        $user->assignRole('student');
        $user->Profile()->create([
            'slug' => Str::of($user->name .'-'. $user->lastname.'-'.$random . $random2)->slug('-'),
            'user_id' => $user->id,
        ]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}

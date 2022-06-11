<?php

namespace App\Providers;


use App\Http\Controllers\Chat\Chat;
use App\Interfaces\Chat\RoomInterface;
use App\Models\task;
use App\Observers\TaskObserve;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(125);
        Model::preventLazyLoading(! app()->isProduction());
        task::observe(TaskObserve::class);
        $this->app->singleton(RoomInterface::class, Chat::class);
    }
}

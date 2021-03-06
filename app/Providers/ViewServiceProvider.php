<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Using class based composers...
        View::composer(
            'frontend.layouts.header', 'App\Http\Composers\HeaderComposer'
        );
        View::composer(
            'frontend.layouts.footer', 'App\Http\Composers\FooterComposer'
        );
    }
}

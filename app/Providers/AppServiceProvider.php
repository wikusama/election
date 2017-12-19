<?php

namespace App\Providers;

use App\Models\Graph;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $graph_header = Graph::where('const', 'config.header')->first();
        $bg_image = NULL;
        if($graph_header){
            $bg_image = $graph_header->val;
        }
        View::share('bg_header', $bg_image);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

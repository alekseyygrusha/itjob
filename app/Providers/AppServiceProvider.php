<?php

namespace App\Providers;

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
        //
    }


}
\Blade::directive('svg', function($arguments) {
    list($path, $class) = array_pad(explode(',', trim($arguments, "() ")), 2, '');
    $path = 'images/svg/' . trim($path, "' ");
    $class = trim($class, "' ");

    $svg = new \DOMDocument();
    $svg->load(public_path($path));
    $svg->documentElement->setAttribute("class", $class);
    $output = $svg->saveXML($svg->documentElement);

    return $output;
});

<?php

namespace Modules;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function boot()
    {
    }
    public function register()
    {
        $listModule = array_map('basename', File::directories(__DIR__));
        // dd($listModule);
        foreach ($listModule as $module) {
            $class = "Modules\\" . $module . "\\Providers\\$module" . "ServiceProvider";

            if (class_exists($class)) {
                $this->app->register($class);
            }
        }
    }
}
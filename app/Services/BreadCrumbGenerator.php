<?php

namespace App\Services;

use App\Models\BreadCrumb;
use App\Models\BreadCrump;

class BreadCrumbGenerator
{
    public static function generate()
    {
        $routeName = request()->route()->getName();
        $routeNameArray = explode('.', $routeName);
        \array_shift($routeNameArray);
        $action = array_pop($routeNameArray);
        $breadCrumbs = [
            new BreadCrumb(name: __('breadcrumbs.dashboard'), route: 'dashboard'),

        ];
//        dd($routeNameArray);
        if (isset($routeNameArray[0])) {
            $breadCrumbs[] = new BreadCrumb(name: __('breadcrumbs')[$routeNameArray[0]], route: "#");
        }


        if ($action == 'create')
            $breadCrumbs[] = new BreadCrumb(name: __('admin.add', ['attribute' => '']));

        if ($action == 'edit')
            $breadCrumbs[] = new BreadCrumb(name: __('admin.update', ['attribute' => '']));
        return $breadCrumbs;
    }
}

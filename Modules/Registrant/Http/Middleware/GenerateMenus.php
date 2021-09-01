<?php

namespace Modules\Registrant\Http\Middleware;

use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         *
         * Module Menu for Admin Backend
         *
         * *********************************************************************
         */
        \Menu::make('admin_sidebar', function ($menu) {

            // registrants
            $menu->add('<i class="fas fa-feather-alt c-sidebar-nav-icon"></i> '.trans('menu.registrants'), [
                'route' => 'backend.registrants.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 3,
                'activematches' => ['admin/registrants*'],
                'permission' => ['view_registrants'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

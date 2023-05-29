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

            // $registrant_menu->add('<i class="fas fa-feather-alt c-sidebar-nav-icon"></i> '.trans('menu.registrants_stage'), [
            //     'route' => 'backend.registrants.stage-index',
            //     'class' => 'c-sidebar-nav-item',
            // ])
            // ->data([
            //     'order' => 4,
            //     'activematches' => ['admin/registrants*'],
            //     'permission' => ['view_registrants'],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link',
            // ]);


            $reg_menu = $menu->add('<i class="fas fa-feather-alt c-sidebar-nav-icon"></i> '.trans('menu.registrants'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order' => 3,
                'activematches' => [
                    'admin/registrants*',                  
                ],
                'permission' => ['view_registrants'],
            ]);

            $reg_menu->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href
                '  => '#',
            ]);

            //Pendaftar
            $reg_menu->add('<i class="fas fa-users c-sidebar-nav-icon"></i> List '.trans('menu.registrants'), [
                'route' => 'backend.registrants.index',
                'class' => 'c-sidebar-nav-item ml-3',
            ])
            ->data([
                'order' => 3,
                'activematches' => ['admin/registrants*'],
                'permission' => ['view_registrants'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            //stage
            $reg_menu->add('<i class="fas fa-running c-sidebar-nav-icon"></i> '.trans('menu.registrants_stage'), [
                    'route' => 'backend.registrants.stage-index',
                    'class' => 'c-sidebar-nav-item ml-3',
                ])
                ->data([
                    'order' => 4,
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

<?php

namespace Modules\Referal\Http\Middleware;

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
        \Menu::make('admin_sidebar', function ($menu) {
            //referal dropdown
            $referal_menu = $menu->add('<i class="fas fa-user-friends c-sidebar-nav-icon"></i> '.trans('menu.referal.title'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order' => 49,
                'activematches' => [
                    'admin/referees*',                  
                ],
                'permission' => ['view_referees'],
            ]);

            $referal_menu->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href
                '  => '#',
            ]);

            //Referees
            $referal_menu->add('<i class="fas fa-user-astronaut c-sidebar-nav-icon"></i> '.trans('menu.referal.referees'), [
                'route' => 'backend.referees.index',
                'class' => 'c-sidebar-nav-item ml-3',
            ])
            ->data([
                'order' => 3,
                'activematches' => ['admin/referees*'],
                'permission' => ['view_referees'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
           
        })->sortBy('order');

        return $next($request);
    }
}

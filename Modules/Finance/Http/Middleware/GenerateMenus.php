<?php

namespace Modules\Finance\Http\Middleware;

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
            //finance dropdown
            $finance_menu = $menu->add('<i class="fas fa-coins c-sidebar-nav-icon"></i> '.trans('menu.finance.title'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order' => 49,
                'activematches' => [
                    'admin/installments*',                  
                ],
                'permission' => ['view_installments'],
            ]);

            $finance_menu->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href
                '  => '#',
            ]);

            //Installments
            $finance_menu->add('<i class="fas fa-percentage c-sidebar-nav-icon"></i> '.trans('menu.finance.installments'), [
                'route' => 'backend.installments.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 3,
                'activematches' => ['admin/installments*'],
                'permission' => ['view_installments'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
           
        })->sortBy('order');

        return $next($request);
    }
}

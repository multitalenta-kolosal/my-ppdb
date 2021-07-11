<?php

namespace Modules\Core\Http\Middleware;

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
            //core dropdown
            $core_menu = $menu->add('<i class="fas fa-database c-sidebar-nav-icon"></i> Core Data', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order' => 79,
                'activematches' => [
                    'admin/units*',
                    'admin/periods*',                    
                ],
                'permission' => ['view_units','view_periods'],
            ]);

            $core_menu->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // units
            $core_menu->add('<i class="fas fa-school c-sidebar-nav-icon"></i> Units', [
                'route' => 'backend.units.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 3,
                'activematches' => ['admin/units*'],
                'permission' => ['view_units'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
            
            // periods
            $core_menu->add('<i class="fas fa-calendar-day c-sidebar-nav-icon"></i> Periods', [
                'route' => 'backend.periods.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 3,
                'activematches' => ['admin/periods*'],
                'permission' => ['view_periods'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

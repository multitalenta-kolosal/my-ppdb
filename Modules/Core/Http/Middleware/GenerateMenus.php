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
            $core_menu = $menu->add('<i class="fas fa-server c-sidebar-nav-icon"></i> Core Data', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order' => 50,
                'activematches' => [
                    'admin/units*',
                    'admin/periods*', 
                    'admin/paths*', 
                    'admin/messages*',                    
                ],
                'permission' => ['view_units','view_periods','view_messages','view_paths'],
            ]);

            $core_menu->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href
                '  => '#',
            ]);

            //template
            $core_menu->add('<i class="fas fa-envelope c-sidebar-nav-icon"></i>Template', [
                'route' => 'backend.messages.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 3,
                'activematches' => ['admin/messages*'],
                'permission' => ['view_messages'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

             // paths
             $core_menu->add('<i class="fas fa-map-signs c-sidebar-nav-icon"></i> Paths', [
                'route' => 'backend.paths.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 4,
                'activematches' => ['admin/paths*'],
                'permission' => ['view_paths'],
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
                'order' => 4,
                'activematches' => ['admin/periods*'],
                'permission' => ['view_periods'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            // units
            $core_menu->add('<i class="fas fa-school c-sidebar-nav-icon"></i> Units', [
                'route' => 'backend.units.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 5,
                'activematches' => ['admin/units*'],
                'permission' => ['view_units'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
            
            // tiers
            $core_menu->add('<i class="fas fa-sitemap c-sidebar-nav-icon"></i> Tiers', [
                'route' => 'backend.tiers.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 5,
                'activematches' => ['admin/tiers*'],
                'permission' => ['view_tiers'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
           
        })->sortBy('order');

        return $next($request);
    }
}

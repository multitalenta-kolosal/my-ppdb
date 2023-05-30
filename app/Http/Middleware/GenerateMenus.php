<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

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
            // Dashboard
            $menu->add('<i class="cil-speedometer c-sidebar-nav-icon"></i> '.trans('menu.dashboard'), [
                'route' => 'backend.dashboard',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 1,
                'activematches' => 'admin/dashboard*',
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            $menu->add('<i class="cil-chart c-sidebar-nav-icon"></i> '.trans('Analytics'), [
                'route' => 'backend.analytics',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 2,
                'activematches' => 'admin/analytics*',
                'permission'    => ['view_analytics'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            $menu->add('Data', [
                'class' => 'c-sidebar-nav-title',
            ])
            ->data([
                'order'         => 2,
                'permission'    => ['edit_settings', 'view_backups', 'view_users', 'view_roles', 'view_logs'],
            ]);

            // Notifications
            // $menu->add('<i class="c-sidebar-nav-icon fas fa-bell"></i> Notifications', [
            //     'route' => 'backend.notifications.index',
            //     'class' => 'c-sidebar-nav-item',
            // ])
            // ->data([
            //     'order'         => 87,
            //     'activematches' => 'admin/notifications*',
            //     'permission'    => [],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link',
            // ]);

            // Separator: Access Management
            $menu->add('Management', [
                'class' => 'c-sidebar-nav-title',
            ])
            ->data([
                'order'         => 101,
                'permission'    => ['edit_settings', 'view_backups', 'view_users', 'view_roles', 'view_logs'],
            ]);

            // Settings
            $menu->add('<i class="c-sidebar-nav-icon fas fa-cogs"></i> '.trans('menu.settings'), [
                'route' => 'backend.settings',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 102,
                'activematches' => 'admin/settings*',
                'permission'    => ['edit_settings'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            // Backup
            $menu->add('<i class="c-sidebar-nav-icon fas fa-archive"></i> '.trans('menu.backups'), [
                'route' => 'backend.backups.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 103,
                'activematches' => 'admin/backups*',
                'permission'    => ['view_backups'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            // Purge
            $menu->add('<i class="c-sidebar-nav-icon fas fa-fire-alt"></i> '.trans('menu.purges'), [
                'route' => 'backend.purges.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 103,
                'activematches' => 'admin/purges*',
                'permission'    => ['view_purges'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            // Access Control Dropdown
            $accessControl = $menu->add('<i class="c-sidebar-nav-icon cil-shield-alt"></i> '.trans('menu.access_control.title'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 104,
                'activematches' => [
                    'admin/users*',
                    'admin/roles*',
                ],
                'permission'    => ['view_users', 'view_roles'],
            ]);
            $accessControl->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Users
            $accessControl->add('<i class="c-sidebar-nav-icon cil-people"></i> '.trans('menu.access_control.users'), [
                'route' => 'backend.users.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 105,
                'activematches' => 'admin/users*',
                'permission'    => ['view_users'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            // Submenu: Roles
            $accessControl->add('<i class="c-sidebar-nav-icon cil-people"></i> '.trans('menu.access_control.roles'), [
                'route' => 'backend.roles.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 106,
                'activematches' => 'admin/roles*',
                'permission'    => ['view_roles'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            // Log Viewer
            // Log Viewer Dropdown
            $accessControl = $menu->add('<i class="c-sidebar-nav-icon cil-list-rich"></i> '.trans('menu.log_viewer.title'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 107,
                'activematches' => [
                    'log-viewer*',
                ],
                'permission'    => ['view_logs'],
            ]);
            $accessControl->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Log Viewer Dashboard
            $accessControl->add('<i class="c-sidebar-nav-icon cil-list"></i> '.trans('menu.log_viewer.dashboard'), [
                'route' => 'log-viewer::dashboard',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 108,
                'activematches' => 'admin/log-viewer',
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            // Submenu: Log Viewer Logs by Days
            $accessControl->add('<i class="c-sidebar-nav-icon cil-list-numbered"></i> '.trans('menu.log_viewer.logs_by_days'), [
                'route' => 'log-viewer::logs.list',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 109,
                'activematches' => 'admin/log-viewer/logs*',
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            // Access Permission Check
            $menu->filter(function ($item) {
                if ($item->data('permission')) {
                    if (auth()->check()) {
                        if (auth()->user()->hasRole('super admin')) {
                            return true;
                        } elseif (auth()->user()->hasAnyPermission($item->data('permission'))) {
                            return true;
                        }
                    }

                    return false;
                } else {
                    return true;
                }
            });

            // Set Active Menu
            $menu->filter(function ($item) {
                if ($item->activematches) {
                    $matches = is_array($item->activematches) ? $item->activematches : [$item->activematches];

                    foreach ($matches as $pattern) {
                        if (Str::is($pattern, \Request::path())) {
                            $item->activate();
                            $item->active();
                            if ($item->hasParent()) {
                                $item->parent()->activate();
                                $item->parent()->active();
                            }
                            // dd($pattern);
                        }
                    }
                }

                return true;
            });
        })->sortBy('order');

        return $next($request);
    }
}

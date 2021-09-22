<?php

namespace Modules\Message\Http\Middleware;

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
         *sdfsd
         * *********************************************************************
         */
        \Menu::make('admin_sidebar', function ($menu) {

            //Template move to core data
           

            // Registrant Message
            $menu->add('<i class="fas fa-mail-bulk c-sidebar-nav-icon"></i> '.trans('menu.message.title'), [
                'route' => 'backend.registrantmessages.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 4,
                'activematches' => ['admin/registrantmessages*'],
                'permission' => ['view_registrantmessages'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

<?php

namespace Modules\Article\Http\Middleware;

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
            $menu->add('CMS', [
                'class' => 'c-sidebar-nav-title',
            ])
            ->data([
                'order'         => 81,
                'permission'    => ['view_posts', 'view_categories','view_comments','view_tags'],
            ]);
            // Articles Dropdown
            $articles_menu = $menu->add('<i class="c-sidebar-nav-icon fas fa-newspaper"></i> '.trans('menu.blog.title'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 86,
                'activematches' => [
                    'admin/posts*',
                    'admin/categories*',
                    'admin/comments*',
                    'admin/tags*'
                ],
                'permission' => ['view_posts', 'view_categories','view_comments','view_tags'],
            ]);
            $articles_menu->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Posts
            $articles_menu->add('<i class="c-sidebar-nav-icon fas fa-pencil-alt"></i> '.trans('menu.blog.posts'), [
                'route' => 'backend.posts.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 82,
                'activematches' => 'admin/posts*',
                'permission'    => ['edit_posts'],
            ])
            ->link->attr([
                'class' => "c-sidebar-nav-link",
            ]);
            // Submenu: Categories
            $articles_menu->add('<i class="c-sidebar-nav-icon fas fa-sitemap"></i> '.trans('menu.blog.categories'), [
                'route' => 'backend.categories.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 83,
                'activematches' => 'admin/categories*',
                'permission'    => ['edit_categories'],
            ])
            ->link->attr([
                'class' => "c-sidebar-nav-link",
            ]);

            $articles_menu->add('<i class="fas fa-comments c-sidebar-nav-icon"></i> '.trans('menu.blog.comments'), [
                'route' => 'backend.comments.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 85,
                'activematches' => ['admin/comments*'],
                'permission' => ['view_comments'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            $articles_menu->add('<i class="fas fa-tags c-sidebar-nav-icon"></i> '.trans('menu.blog.tags'), [
                'route' => 'backend.tags.index',
                'class' => "c-sidebar-nav-item",
            ])
            ->data([
                'order' => 84,
                'activematches' => ['admin/tags*'],
                'permission' => ['view_tags'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

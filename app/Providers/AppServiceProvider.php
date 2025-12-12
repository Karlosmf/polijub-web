<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;
use Mary\View\Components\Button;
use Mary\View\Components\Header;
use Mary\View\Components\Icon;
use Mary\View\Components\Input;
use Mary\View\Components\Modal;
use Mary\View\Components\Toast;
use Mary\View\Components\Menu;
use Mary\View\Components\MenuItem;
use Mary\View\Components\MenuSub;
use Mary\View\Components\MenuSeparator;
use Mary\View\Components\ListItem;
use Mary\View\Components\Nav;
use Mary\View\Components\Main;
use Mary\View\Components\Stat;
use Mary\View\Components\Table;
use Mary\View\Components\Badge;
use Mary\View\Components\Toggle;
use Mary\View\Components\File;
use Mary\View\Components\Select;
use Mary\View\Components\Choices;
use Mary\View\Components\Textarea;
use Mary\View\Components\ThemeToggle;
use Mary\View\Components\Form;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('button', Button::class);
        Blade::component('header', Header::class);
        Blade::component('icon', Icon::class);
        Blade::component('input', Input::class);
        Blade::component('modal', Modal::class);
        Blade::component('toast', Toast::class);
        Blade::component('menu', Menu::class);
        Blade::component('menu-item', MenuItem::class);
        Blade::component('menu-sub', MenuSub::class);
        Blade::component('menu-separator', MenuSeparator::class);
        Blade::component('list-item', ListItem::class);
        Blade::component('nav', Nav::class);
        Blade::component('main', Main::class);
        Blade::component('stat', Stat::class);
        Blade::component('table', Table::class);
        Blade::component('badge', Badge::class);
        Blade::component('toggle', Toggle::class);
        Blade::component('file', File::class);
        Blade::component('select', Select::class);
        Blade::component('choices', Choices::class);
        Blade::component('textarea', Textarea::class);
        Blade::component('theme-toggle', ThemeToggle::class);
        Blade::component('form', Form::class);
    }
}

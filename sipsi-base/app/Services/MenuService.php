<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class MenuService
{
    public static function getAvailableMenus()
    {
        $allMenus = Config::get('menu.list_menu');
        $user = Auth::user();
        $availableMenus = [];

        foreach ($allMenus as $menu) {
            if ($user && $user->can($menu['permission'])) {
                $availableMenus[] = $menu;
            }
        }

        return $availableMenus;
    }
}

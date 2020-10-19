<?php namespace Kloos\Toolbox\Classes\Event;

use Cms\Models\ThemeData;
use RainLab\Pages\Classes\Menu;

class ExtendThemeData
{
    public function subscribe()
    {
        ThemeData::extend(function ($model) {
            $model->addDynamicMethod('getMenuOptions', function () use ($model) {
                return Menu::all()
                    ->pluck('name', 'code')
                    ->toArray();
            });
        });
    }
}
<?php namespace Kloos\Toolbox\Classes\Extend\Facade;

use Illuminate\Support\Facades\Facade;
use Kloos\Toolbox\Classes\Extend\ActionManager;

class Actions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ActionManager::class;
    }
}
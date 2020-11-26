<?php namespace Kloos\Toolbox\Classes\Extend;

use System\Classes\PluginManager;
use October\Rain\Support\Traits\Singleton;
use Kloos\Toolbox\Classes\Extend\Facade\Actions;

class ActionPathHelper
{
    use Singleton;

    public $paths = [];

    public function init()
    {
    }

    public function register()
    {
        foreach (PluginManager::instance()->getAllPlugins() as $plugin) {
            if (method_exists($plugin, 'registerActionPaths')) {
                $this->paths = array_merge($this->paths, $plugin->registerActionPaths());
            }
        }

        // Register action paths
        Actions::paths(collect($this->paths)->values());

        // Register actions in provided paths
        Actions::registerAllPaths();

        //dd(Actions::getRegisteredActions());
    }

    public function findByPath($lookup)
    {
        $pathname = explode('/', $lookup);
        $fileName = $pathname[count($pathname) - 1];
        $lookup = str_replace($fileName, '', $pathname);

        foreach ($this->paths as $namespace => $path) {
            if ($path . '/' === implode('/', $lookup)) {
                return '\\' . $namespace . '\\' . explode('.', $fileName)[0];
            }
        }
    }
}
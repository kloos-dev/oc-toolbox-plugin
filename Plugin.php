<?php namespace Kloos\Toolbox;

use Event;
use Backend;
use System\Classes\PluginBase;
use Kloos\Toolbox\Classes\Event\ExtendThemeData;
use Kloos\Toolbox\FormWidgets\PropertyInspector;

/**
 * Toolbox Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Toolbox',
            'description' => 'No description provided yet...',
            'author'      => 'Kloos',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        Event::subscribe(ExtendThemeData::class);
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Kloos\Toolbox\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'kloos.toolbox.some_permission' => [
                'tab' => 'Toolbox',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'toolbox' => [
                'label'       => 'Toolbox',
                'url'         => Backend::url('kloos/toolbox/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['kloos.toolbox.*'],
                'order'       => 500,
            ],
        ];
    }

    public function registerFormWidgets()
    {
        return [
            PropertyInspector::class => 'propertyinspector',
        ];
    }
}

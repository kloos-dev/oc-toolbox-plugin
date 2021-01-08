<?php namespace Kloos\Toolbox\Classes\Base;

use Yaml;
use Event;

class OctoberExtend
{
    private $controller;

    private $model;

    public function __construct()
    {
        $this->load();
    }

    /**
     * This method reloads the extension config
     */
    public function load()
    {
        $this->model        = $this->model();
        $this->controller   = $this->controller();
    }

    public function model()
    {
        return null;
    }

    public function controller()
    {
        return null;
    }

    public function subscribe()
    {
        $this->extendFormFields();
        $this->extendRelationConfig();
    }

    public function addFields()
    {
        return [];
    }

    public function addTabFields()
    {
        return [];
    }

    public function addRelationConfig()
    {
        return [];
    }

    /**
     * Private functions required by the extender
     */

    private function extendRelationConfig()
    {
        if (count($this->addRelationConfig()) < 1) {
            return;
        }

        $controller = new $this->controller;

        $addRelationController = false;
        $configExists = false;
        $configEmpty = true;
        $relationConfig = $this->addRelationConfig();

        if (!array_key_exists('Backend\Behaviors\RelationController', $controller->implement)) {
            $addRelationController = true;
        }

        if (property_exists($controller, 'relationConfig')) {
            $configExists = true;
        }

        if ($configExists && $controller->relationConfig) {
            $configEmpty = false;
        }

        $controller::extend(function ($c) use ($addRelationController, $configExists, $configEmpty, $relationConfig) {
            if ($addRelationController) {
                array_push($c->implement, 'Backend\Behaviors\RelationController');
            }

            if (!$configExists) {
                $c->addDynamicProperty('relationConfig', function ($relationConfig) {
                    return $relationConfig;
                });
            } else {
                if ($configEmpty) {
                    $c->relationConfig = $relationConfig;
                } else {
                    if (is_array($c->relationConfig)) {
                        $c->relationConfig = array_merge($relationConfig, $c->relationConfig);
                    }

                    if (is_string($c->relationConfig)) {
                        $currentRelationConfig = Yaml::parseFile($c->relationConfig);

                        $c->relationConfig = array_merge($currentRelationConfig, $relationConfig);
                    }
                }
            }
        });
    }

    private function extendFormFields()
    {
        Event::listen('backend.form.extendFields', function ($formWidget) {
            if (!$formWidget->getController() instanceof $this->controller) {
                return;
            }

            if (!$formWidget->model instanceof $this->model) {
                return;
            }

            $formWidget->addFields($this->addFields());
            $formWidget->addTabFields($this->addTabFields());
        });
    }
}
<?php namespace Kloos\Toolbox\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * PropertyInspector Form Widget
 */
class PropertyInspector extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'kloos_toolbox_property_inspector';

    public $properties = [];

    public $span = 'auto';

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->fillFromConfig([
            'properties',
            'span',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('propertyinspector');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['properties'] = json_encode($this->properties);
        $this->vars['span'] = $this->span;
    }

    public function getLoadValue()
    {
        return json_encode(parent::getLoadValue());
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/propertyinspector.css');
        $this->addJs('js/propertyinspector.js');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return json_decode($value, true);
    }
}

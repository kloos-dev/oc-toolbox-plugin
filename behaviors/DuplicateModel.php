<?php namespace Kloos\Toolbox\Behaviors;

use Backend\Classes\ControllerBehavior;
use October\Rain\Extension\ExtensionBase;

class DuplicateModel extends ControllerBehavior
{
    public function __construct($controller)
    {
        parent::__construct($controller);

        $this->config = $this->makeConfig($controller->formConfig);
    }

    public function update_onDuplicate($id)
    {
        $record = $this->getConfig('modelClass')::find($id);

        if ($record) {
            $this->duplicateRecord($record);
        }
    }

    public function preview_onDuplicate($id)
    {
        $record = $this->getConfig('modelClass')::find($id);

        if ($record) {
            $this->duplicateRecord($record);
        }
    }

    protected function duplicateRecord($record)
    {
        $copy = $record->replicate();

        if (method_exists($this->controller, 'beforeDuplicate')) {
            $this->controller->beforeDuplicate($copy);
        }

        $copy->save();
    }
}
<?php namespace Kloos\Toolbox\Components;

use Flash;
use October\Rain\Parse\Yaml;
use Cms\Classes\ComponentBase;
use Kloos\Toolbox\Classes\Helper\ClassName;

class FrontendForm extends ComponentBase
{
    public $context;

    public function componentDetails()
    {
        return [
            'name'        => 'FrontendForm Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'modelClass' => [
                'title' => 'Model class',
                'type' => 'string',
            ],
            'id' => [
                'title' => 'Record ID',
                'type' => 'string',
            ],
            'formConfig' => [
                'title' => 'Form config',
                'type' => 'string',
            ],
        ];
    }

    public function prepareVars()
    {
        $id = $this->property('id');
        if ($id == 'nieuw' || $id == 'maken' || $id == 'new' || $id == 'create') {
            $this->context = 'create';
        } else {
            $this->context = 'update';
        }
    }

    public function onRun()
    {
        $this->prepareVars();

        if ($this->property('id')) {
            $id = $this->property('id');
            $modelClass = $this->property('modelClass');

            if ($this->context == 'create') {
                $modelClass = new $modelClass;
            } else {
                $modelClass = $modelClass::find($id);
            }
        } else {
            $modelClass = $this->property('modelClass');
            $modelClass = new $modelClass;
        }

        if ($this->property('formConfig')) {
            $filePath = plugins_path($this->property('formConfig'));
        } else {
            $space = ClassName::fromString($this->property('modelClass'));
            $filePath = $space->modelPath('frontend_form.yaml');
        }

        if (file_exists($filePath)) {
            $parser = new Yaml;
            $formConfig = $parser->parseFile($filePath);

            $this->page['formConfig'] = $formConfig;
            $this->page['modelClass'] = $modelClass;
        }
    }

    public function onSave()
    {
        $this->prepareVars();
        $modelClass = $this->property('modelClass');

        if ($this->context == 'create') {
            $modelClass = new $modelClass;
        } else {
            $id = $this->property('id');
            $modelClass = $modelClass::find($id);
        }

        foreach (input() as $field => $input) {
            $modelClass->{$field} = $input;
        }

        $modelClass->save();

        Flash::success('Wijzigingen zijn opgeslagen');
    }
}

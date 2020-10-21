<?php namespace Kloos\Toolbox\Classes\Item;

use October\Rain\Exception\ApplicationException;
use Kloos\Workflow\Models\Workflow as WorkflowModel;

abstract class AbstractModelItem
{
    public $modelObj;

    public function __construct($modelObj)
    {
        $this->modelObj = $modelObj;
    }

    public static function modelClass()
    {
        return null;
    }

    public static function make($item)
    {
        $modelItem = null;
        $modelClass = static::modelClass();

        if (is_integer($item)) {
            $modelItem = $modelClass::find($item);
        }

        if ($item instanceof $modelClass) {
            $modelItem = $item;
        }

        if (!$modelItem) {
            throw new ApplicationException('Not a valid workflow object');
        }

        return new static($modelItem);
    }
}

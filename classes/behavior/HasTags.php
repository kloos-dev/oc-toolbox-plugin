<?php namespace Kloos\Toolbox\Classes\Behavior;

use Kloos\Toolbox\Models\Tag;
use October\Rain\Database\Model;
use October\Rain\Extension\ExtensionBase;

class HasTags extends ExtensionBase
{
    public function __construct(Model $model)
    {
        $className = get_class($model);
        $modelName = ($exploded = explode('\\', $className))[count($exploded) - 1];

        Tag::extend(function (Tag $tagModel) use ($modelName, $className) {
            $tagModel->morphedByMany[strtolower($modelName) . 's'] = [
                $className,
                'name' => 'taggable',
                'table' => 'kloos_toolbox_tags_taggables',
            ];
        });
    }
}
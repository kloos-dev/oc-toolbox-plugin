<?php namespace Kloos\Toolbox\Classes\Extend;

class ActionManager extends \Lorisleiva\Actions\ActionManager
{
    /**
     * Get the fully-qualified name of a class from its pathname.
     *
     * @param string $pathname
     * @return string
     */
    protected function getClassnameFromPathname(string $pathname): string
    {
        return ActionPathHelper::instance()->findByPath($pathname);
    }
}
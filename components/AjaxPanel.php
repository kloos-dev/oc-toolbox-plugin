<?php namespace Kloos\Toolbox\Components;

use Cms\Classes\ComponentBase;

class AjaxPanel extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AjaxPanel Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function onRun()
    {
        $this->prepareAssets();
    }

    public function prepareAssets()
    {
        $this->addCss('/plugins/kloos/toolbox/components/ajaxpanel/assets/css/jquery-ui.min.css');
        $this->addCss('/plugins/kloos/toolbox/components/ajaxpanel/assets/css/panel.css');
        $this->addJs('/plugins/kloos/toolbox/components/ajaxpanel/assets/js/jquery-ui.min.js');
        $this->addJs('/plugins/kloos/toolbox/components/ajaxpanel/assets/js/panel.js');
    }

    public function render($id, $handler, $position = 'right')
    {
        return $this->renderPartial('@default', [
            'id' => $id,
            'handler' => $handler,
            'position' => $position,
        ]);
    }

    public function defineProperties()
    {
        return [];
    }
}

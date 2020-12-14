<?php namespace Kloos\Toolbox\Classes\Helper;

class ClassName
{
    protected $className;

    protected $explodedString;

    protected $author;

    protected $hasAuthor = false;

    protected $hasPlugin = false;

    protected $hasModel = false;

    public function __construct($className)
    {
        $this->className = $className;

        $this->explodedString = explode('\\', $this->className);
        $this->checkSegments();

        $this->resolveAuthor();
        $this->resolvePlugin();
        $this->resolveModel();
    }

    protected function checkModel()
    {
        return in_array('Models', $this->explodedString);
    }

    protected function resolveAuthor()
    {
        $this->author = strtolower($this->explodedString[0]);
    }

    protected function resolveModel()
    {
        if (!$this->checkModel()) {
            return null;
        }

        $this->model = strtolower($this->explodedString[3]);
    }

    protected function resolvePlugin()
    {
        $this->plugin = strtolower($this->explodedString[1]);
    }

    protected function checkSegments()
    {
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getPlugin()
    {
        return $this->plugin;
    }

    public function modelPath($path)
    {
        $path = [
            $this->author,
            $this->plugin,
            'models',
            $this->model,
            $path
        ];

        return plugins_path(implode('/', $path));
    }

    public static function fromString($className)
    {
        return new static($className);
    }
}
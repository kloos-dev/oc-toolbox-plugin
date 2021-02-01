<?php namespace Kloos\Toolbox\Classes\Helper;

class Trigger
{
    protected $valueToCheck;

    protected $type;

    protected $trueValue;

    protected $result = false;

    public function __construct($valueToCheck, $type, $trueValue)
    {
        $this->valueToCheck = $valueToCheck;
        $this->type = $type;
        $this->trueValue = $trueValue;
    }

    public function runCheck()
    {
        switch ($this->type) {
            case "is":
                $this->checkIsTrue();
                break;
            case "is_not":
                $this->checkIsFalse();
                break;
            case "higher":
                $this->checkIsBigger();
                break;
            case "lower":
                $this->checkIsSmaller();
                break;
            case "checked":
                $this->checkIsChecked();
                break;
            case "unchecked":
                $this->checkIsUnchecked();
                break;
        }

        return $this->result;
    }

    public static function check($valueToCheck, $type, $trueValue)
    {
        $check = new static($valueToCheck, $type, $trueValue);

        return $check->runCheck();
    }

    protected function checkIsTrue()
    {
        if ($this->valueToCheck == $this->trueValue) {
            $this->result = true;
        }
    }

    protected function checkIsFalse()
    {
        if ($this->valueToCheck != $this->trueValue) {
            $this->result = true;
        }
    }

    protected function checkIsBigger()
    {
        if ($this->valueToCheck > $this->trueValue) {
            $this->result = true;
        }
    }

    protected function checkIsSmaller()
    {
        if ($this->valueToCheck < $this->trueValue) {
            $this->result = true;
        }
    }

    protected function checkIsChecked()
    {
        if ($this->valueToCheck) {
            $this->result = true;
        }
    }

    protected function checkIsUnchecked()
    {
        if (!$this->valueToCheck) {
            $this->result = true;
        }
    }
}
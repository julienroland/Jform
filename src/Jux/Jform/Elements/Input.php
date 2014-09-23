<?php

namespace Jux\Jform\Elements;


use Jux\Jform\Build\Build;

abstract class Input extends Build {

    /**
     * @var
     */
    private $required;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $value;
    /**
     * @var
     */
    private $inputValue;
    /**
     * @var
     */
    private $options;
    /**
     * @var
     */
    private $after;

    public function __construct($required = false, $name, $value = null, $inputValue = null, $options = array(), $after
        = null)
    {

        $this->inputRequired = $required;
        $this->inputName = $name;
        $this->labelValue = $value;
        $this->inputVal = $inputValue;
        $this->inputOptions = $options;
        $this->inputAfter = $after;

        return $this->render();
    }

    abstract public function render();

    public function __toString()
    {

        return $this->render();
    }

    public function isRequired()
    {

    }

    public function type()
    {

    }

    public function name()
    {

    }

    public function value()
    {

    }

    public function defaultValue()
    {

    }

    public function options()
    {

    }

    public function after()
    {

    }
}

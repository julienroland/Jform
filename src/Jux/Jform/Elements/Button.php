<?php

namespace Jux\Jform\Elements;

use Jux\Jform\Build\Build;

abstract class Button extends Build{

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

    public function __construct( $value = null, $options = array() )
    {
        $this->submitValue = $value;
        $this->submitOptions = $options;
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
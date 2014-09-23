<?php

namespace Jux\Jform\Elements;

use Jux\Jform\Build\Build;

abstract class Form extends Build {

    /**
     * @var array
     */
    private $form;

    function __construct(array $form = array() )
    {
        $this->formData = $form;

    }

    abstract public function render();

    public function __toString()
    {
        return $this->render();
    }



} 
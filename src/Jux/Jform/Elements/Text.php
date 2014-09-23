<?php

namespace Jux\Jform\Elements;


class Text extends Input {

    private $type = 'text';

    public function isRequired()
    {
        return $this->inputRequired;
    }

    public function render()
    {

        return $this->input(
            $this->inputRequired,
            $this->type,
            $this->inputName,
            $this->labelValue,
            $this->inputVal,
            $this->inputOptions,
            $this->inputAfter
        );
    }
} 
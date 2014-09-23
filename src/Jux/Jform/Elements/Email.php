<?php

namespace Jux\Jform\Elements;

class Email extends Input{

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
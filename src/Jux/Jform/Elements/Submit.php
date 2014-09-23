<?php

namespace Jux\Jform\Elements;

class Submit extends Button{

    public function render()
    {
        return $this->submit($this->submitValue, $this->submitOptions);
    }
} 
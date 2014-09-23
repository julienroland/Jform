<?php

namespace Jux\Jform\Elements;

class OpenForm extends Form{

    public function render()
    {
        return $this->openForm($this->formData);
    }
} 
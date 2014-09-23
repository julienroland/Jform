<?php namespace Jux\Jform;


use \Form;

use \Jux\Jform\Elements\Text;
use \Jux\Jform\Elements\Email;
use \Jux\Jform\Elements\Password;
use \Jux\Jform\Elements\Number;
use \Jux\Jform\Elements\OpenForm;
use \Jux\Jform\Elements\Submit;

class Jform extends Config {

    public function __construct($form)
    {
        $this->form = $form;
    }

    public function open(array $form = array())
    {

        $openForm = new OpenForm($form);

        return $openForm;
    }


    public function submit($value = null, array $options = array())
    {

        $submit = new Submit($value, $options);

        return $submit;

    }

    public function close()
    {
        return '</form>';
    }

    public function text($required = false, $name, $value = null, $inputValue = null, array $options = array(), $after = null)
    {

        $text = new Text($required, $name, $value, $inputValue, $options, $after);

        return $text;

    }

    public function email($required = false, $name, $value = null, $inputValue = null, array $options = array(), $after = null)
    {

        $email = new Email($required, $name, $value, $inputValue, $options, $after);

        return $email;
    }

    public function number($required = false, $name, $value = null, $inputValue = null, array $options = array(), $after = null)
    {
        $number = new Number($required, $name, $value, $inputValue, $options, $after);

        return $number;

    }

    public function password($required = false, $name, $value = null, $inputValue = null, array $options = array(), $after = null)
    {

        $password = new Password($required, $name, $value, $inputValue, $options, $after);

        return $password;
    }


}
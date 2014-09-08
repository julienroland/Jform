<?php namespace Jux\Jform;

use \Form;
use \Helpers;

class Jform {

    private $placeholder = false;

    protected $formClass = 'form';

    protected $submitClass = 'submit';

    protected $hiddenClass = 'section';

    protected $groupClass = 'field';

    protected $afterClass = 'after-form';


    public function __construct( $form ){

        $this->form = $form;

    }
    public function open(array $form = array()){

        if(isset($form['placeholder']) && $form['placeholder'] === true){

            $this->placeholder = true;
        }

        $form['role'] = 'form';
        $form['class'] = $this->formClass;

        if(isset($form['route']) && count($form['route']) > 1 || isset($form['url']) && count($form['url']) > 1 || isset($form['action']) && count($form['action']) > 1){

            $form['method'] = 'PUT';

        }else{

            $form['method'] = 'POST';

        }


        return $this->form->open($form);
    }

    public function close() {
        return $this->form->close();
    }

    public function text($required = false, $name, $value = null,  $inputValue = null, array $options = array(), $after=null){

        return $this->createInput($required, 'text', $name, $value, $inputValue, $options, $after);

    }

    public function email($required = false, $name, $value = null, $inputValue = null, array $options = array(), $after=null){

        return $this->createInput($required, 'email', $name, $value, $inputValue, $options, $after);

    }

    public function number($required = false, $name, $value = null, $inputValue = null, array $options = array(), $after=null){

        return $this->createInput($required, 'number', $name, $value, $inputValue, $options, $after);

    }

    public function password($required = false, $name, $value = null, $inputValue = null, array $options = array(), $after=null){

        return $this->createInput($required, 'password', $name, $value, $inputValue, $options, $after);

    }

    public function submit($value = null, array $options = array()){

        $options['class'] = isset($options['class']) ? $options['class'].' ' :'' .$this->submitClass;
        if(!$value){
            $value = trans('form.submit');
        }
        return $this->form->submit($value, $options);

    }

    public function label($name, $value = null, $required = false){

        $label = '<label for="' . $name . '">';
        $label .= $value ? $value : $name;
        $label .= $required ? $required : '';
        $label .= '</label>';

        return $label;
    }

    public function createInput($required, $type, $name, $value = null, $inputValue = null, array $options = array(), $after=null){

        if($required){
            if(!$this->placeholder){
                $required = ' <span class="' . $this->hiddenClass . '">' . trans('form.required') . '</span><span class="required" aria-hidden="true">*</span>';
            }
        }

        if(Helpers::isNotOk($value)){
            if(trans('form.'.$name)){
                $value = trans('form.'.$name);
            }else{
                $value = ucfirst($name);
            }
        }
        $input = '';
        if(!isset($options['data-nogroup'])){
            $input .= '<div class="' . $this->groupClass . '">';
        }
        if(!$this->placeholder){
            if($required){
                $options['required'] = 'required';
                $options['aria-required'] = true;
            }
            $options['placeholder'] = $value;
            $input .= $this->label($name, $value, $required).$this->form->input($type, $name, $inputValue, $options);

        }else{
            $options['placeholder'] = $value;
            if($required){
                $options['required'] = 'required';
                $options['aria-required'] = true;
            }
            $options['aria-labelledby'] = $name.'-aria';
            $input .= '<span class="' .  $this->hiddenClass . '" id="' . $name. '-aria">' .  $value . ' ' . trans('form.required') . '</span>';
            $input .= $this->form->input($type, $name, $inputValue, $options);

        }
        if(Helpers::isOk($after)){
            $input.= '<span class="' . $this->afterClass . '"> ' .  $after . '</span>';
        }
        if(!isset($options['data-nogroup'])){
            $input .= '</div>';
        }

        return $input;

    }

}
<?php

namespace Jux\Jform\Build;


use Jux\Jform\Config;
use \Form;
use \Helpers;

class Build extends Config {

    public function submit($value, array $options = array())
    {
        $options = $this->addSubmitClass($options);

        if ($options['describedby'])
        {
            $key = $this->generateDescribedbyKey($options);
            $options = $this->addDescribedbyToSubmit($options, $key);
            $describedbyDiv = $this->outputDescribedbyTag($options, $key);
        }

        $value = $this->setDefaultSubmitValue($value);

        return Form::submit($value, $options) . $describedbyDiv;
    }

    public function openForm(array $form = array())
    {
        $this->isUsingPlaceholder($form);

        $form = $this->addFormTags($form);

        $form = $this->setFormMethod($form);

        $errorContainer = $this->getFormErrors($form);

        return $errorContainer . Form::open($form);
    }

    public function input($required = false, $type, $name = null, $value = null, $inputValue = null, array $options = array(), $after = null)
    {

        $required = $this->isRequiredField($required);

        $value = $this->defineValueOfField($value, $name);

        $input = '';

        $input = $this->openFieldContainer($options, $input);

        $options = $this->fieldIsValid($name, $options);

        if ( !$this->placeholder)
        {
            if ($required)
            {
                $options = $this->addFieldRequiredOptions($options);
            }

            $options = $this->addPlaceholderOption($options, $value);

            $input = $this->outputInputAndLabel($input, $type, $name, $value, $inputValue, $options, $required);

        } else
        {
            $options = $this->addPlaceholderOption($options, $value);

            if ($required)
            {
                $options = $this->addFieldRequiredOptions($options);
            }

            $options = $this->addLabelAriaOptions($options, $name);

            $input = $this->addHiddenLabel($input, $name, $value);

            $input = $this->outputInput($input, $type, $name, $inputValue, $options);

        }

        if ( !is_null($after))
        {
            $input = $this->outputAfterValue($input, $after);
        }
        if ( !isset($options['data-nogroup']))
        {
            $input = $this->closeFieldContainer($input);
        }

        return $input;

    }

    /**
     * Test if the field si required
     *
     * @param $required
     * @return string
     */
    private function isRequiredField($required)
    {
        if ($required)
        {
            if ( !$this->placeholder)
            {
                $required = $this->outputRequiredTags();
            }
        }

        return $required;
    }

    /**
     * Set the container of each field
     *
     * @param $options
     * @param $input
     * @return string
     */
    private function openFieldContainer($options, $input)
    {
        if ( !isset($options['data-nogroup']))
        {
            $input .= '<div class="' . $this->groupClass . '">';
        }

        return $input;
    }

    /**
     * Manage field errors
     *
     * @param $name
     * @param $options
     * @return mixed
     */
    private function fieldIsValid($name, $options)
    {

        if (! is_null($this->errors) && $this->errors->any())
        {

            $error = $this->errors->first($name);

            if ( !empty($error))
            {

                $options['aria-valid'] = 'false';
                $options['class'] = isset($options['class']) ? $options['class'] . ' ' . $this->inputErrorClass : $this->inputErrorClass;

            } else
            {

                $options['aria-valid'] = 'true';
                $options['class'] = isset($options['class']) ? $options['class'] . ' ' . $this->inputValidClass : $this->inputValidClass;
            }
        }

        return $options;
    }

    /**
     * Add required options to the field
     *
     * @param $options
     * @return mixed
     */
    private function addFieldRequiredOptions($options)
    {
        $options['required'] = 'required';
        $options['aria-required'] = 'true';

        return $options;
    }

    /**
     * Test if we are using placeholder in form open
     *
     * @param array $form
     */

    private function isUsingPlaceholder($form)
    {
        if (isset($form['placeholder']) && $form['placeholder'] == true)
        {
            $this->placeholder = true;
        }

        $this->placeholder = false;
    }

    /**
     * Add attributes and tags to form HTML element
     *
     * @param array $form
     * @return mixed
     */

    private function addFormTags($form)
    {
        $form['role'] = 'form';
        $form['class'] = $this->formClass;

        return $form;
    }

    /**
     * Set the form method (post, get, put, delete, patch)
     *
     * @param array $form
     * @return mixed
     */
    private function setFormMethod($form)
    {
        if (isset($form['route']) && count($form['route']) > 1 || isset($form['url']) && count($form['url']) > 1 || isset($form['action']) && count($form['action']) > 1)
        {

            $form['method'] = 'PUT';

        } else
        {

            $form['method'] = 'POST';

        }

        return $form;
    }

    /**
     * Set the default class for a submit button
     *
     * @param array $options
     * @return mixed
     */
    private function addSubmitClass($options)
    {
        $options['class'] = isset($options['class']) ? $options['class'] . ' ' : '' . $this->submitClass;

        return $options;
    }

    /**
     * If no value form input submit, set the default from translation file
     *
     * @param $value
     * @return string
     */
    private function setDefaultSubmitValue($value)
    {
        if ( !$value)
        {
            $value = trans('form.submit');
        }

        return $value;
    }

    /**
     * Output label's HTML
     *
     * @param $name
     * @param $value
     * @param $required
     * @return string
     */
    private function outputLabel($name, $value, $required)
    {
        $label = '<label for="' . $name . '">';
        $label .= $value ? $value : $name;
        $label .= $required ? $required : '';
        $label .= '</label>';

        return $label;
    }


    /**
     * Output required informations for field
     *
     * @return string
     */
    private function outputRequiredTags()
    {
        return ' <span class="' . $this->hiddenClass . '">' . trans('form.required') . '</span><span class="required" aria-hidden="true">*</span>';
    }

    /**
     * Define the value of field if not set
     *
     * @param $value
     * @param $name
     * @return string
     */
    private function defineValueOfField($value, $name)
    {
        if (is_null($value))
        {
            if (trans('form.' . $name))
            {
                $value = trans('form.' . $name);
            } else
            {
                $value = ucfirst($name);
            }
        }

        return $value;
    }

    /**
     * Add required option to the field
     *
     * @param $options
     * @param $value
     * @return mixed
     */
    private function addPlaceholderOption($options, $value)
    {
        $options['placeholder'] = $value;

        return $options;
    }

    /**
     * Output input using laravel label and input function
     *
     * @param $type
     * @param $name
     * @param $value
     * @param $inputValue
     * @param $options
     * @return string
     */
    private function outputInputAndLabel($input, $type, $name, $value, $inputValue, $options, $required)
    {

        $input .= $this->label($name, $value, $required) . Form::input($type, $name, $inputValue, $options);

        return $input;
    }

    /**
     * Add aria-labelledby to the "label's" options
     *
     * @param $options
     * @param $name
     * @return mixed
     */
    private function addLabelAriaOptions($options, $name)
    {
        $options['aria-labelledby'] = $name . '-labelled-aria';

        return $options;
    }

    /**
     * Add hidden tag to simulate label using aria
     *
     * @param $input
     * @return string
     */
    private function addHiddenLabel($input, $name, $value)
    {
        $input .= '<span class="' . $this->hiddenClass . '" id="' . $name . '-labelled-aria">' . $value . ' ' . trans('form.required') . '</span>';

        return $input;
    }

    /**
     * Ouput the input using laravel input function
     *
     * @param $input
     * @param $type
     * @param $inputValue
     * @param $options
     * @return string
     */
    private function outputInput($input, $type, $name, $inputValue, $options)
    {
        $input .= $this->form->input($type, $name, $inputValue, $options);

        return $input;
    }

    /**
     * Ouput after value
     *
     * @param $input
     * @param $after
     * @return string
     */
    private function outputAfterValue($input, $after)
    {
        $input .= '<span class="' . $this->afterClass . '"> ' . $after . '</span>';

        return $input;
    }

    /**
     * Close the field container
     *
     * @param $input
     * @return string
     */
    private function closeFieldContainer($input)
    {
        $input .= '</div>';

        return $input;
    }

    /**
     * Add aria describedby to submit
     *
     * @param $options
     * @param $key
     * @return string
     */
    private function addDescribedbyToSubmit($options, $key)
    {

        unset($options['describedby']);
        $options['aria-describedby'] = $key;

        return $options;

    }

    private function outputDescribedbyTag($options, $key)
    {
        $descriptionValue = trans('form.' . $key) ? trans('form.' . $key) : ucfirst($options['describedby']);
        $divDescription = '<div id="' . $key . '" class="' . $this->hiddenClass . '">' . $descriptionValue . '</div>';

        return $divDescription;
    }

    /**
     * Generate describedby key ( descriptionKey + ucfirst(options) )
     *
     * @param $options
     * @return string
     */
    private function generateDescribedbyKey($options)
    {
        $key = $this->descriptionKey . ucfirst($options['describedby']);

        return $key;
    }


    /**
     * Get form errors
     *
     * @param $form
     * @return mixed
     */
    private function getFormErrors($form)
    {

        $errors = isset($form['errors']) ? unserialize($form['errors']) : array();
        unset($form['errors']);

        $this->errors = $errors->count() > 0 ? $errors : null;

        if ( !is_null($this->errors))
        {
            return $this->outputErrorsMessage();
        } else
        {
            return '';
        }

    }

    /**
     * Output errors message on the top of form
     *
     * @return string
     */
    private function outputErrorsMessage()
    {
        $container = '';

        if ($this->errors->any())
        {
            $container = '<ul class="' . $this->errorsMessageClassContainer . '">';
            $container .= implode('', $this->errors->all('<li class="' . $this->errorMessageClass . '">:message</li>'));
            $container .= '</ul>';
        }

        return $container;
    }

    /**
     * Generate label field
     *
     * @param $name
     * @param null $value
     * @param bool $required
     * @return string
     */
    public function label($name, $value = null, $required = false)
    {

        return $this->outputLabel($name, $value, $required);

    }
} 
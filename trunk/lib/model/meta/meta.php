<?php

namespace vg\wordpress_plugin\model\meta;

class Meta
{
    public $name;
    public $default_value;
    public $validators;
    public $prefix = '';

    protected $model;

    public function __construct($name, $default_value, $validators, $model)
    {
        $this->name = $name;
        $this->default_value = $default_value;
        $this->validators = $validators;
        $this->model = $model;
    }

    public function get()
    {
        // get the arguments passed to the function
        $args = func_get_args();

        // TODO: remove the function call with variable amount of arguments, the child implementation should handle that itself
        // call the overridden method with all the passed arguments
        $value = call_user_func_array(array($this, 'get_value'), $args);

        // If the value validates, return the value
        if ($this->validates($value) === true)
        {
            return $value;
        }
        // if it doesn't validate, store the default value as the new value
        else
        {
            // get the default value
            $default = $this->default_value();

            // add the default value to the beginning of the to be called arguments on the setter
            array_unshift($args, $default);

            // try to set the default value
            $value = call_user_func_array(array($this, 'set'), $args);

            // if the setting of the default values fails -> raise error
            if ($value === false)
            {
                throw new \Exception("Meta: unable to set the default value '$default' of field '$this->name'");
            }

            return $default;
        }
    }

    public function set($value)
    {
        // if the value doesn't validate, return false
        if ($this->validates($value) === true)
        {
            // call the child subclass method
            $value = call_user_func_array(array($this, 'set_value'), func_get_args());

            // return the success of the child class
            return $value;
        }
        else
        {
            return false;
        }
    }

    public function name($with_prefix = true)
    {
        if ($with_prefix) {
            return $this->prefix . $this->name;
        } else {
            return $this->name;
        }
    }

    // TODO: signature doesn't match up for different child classes, way to fix this?
//    protected function get_value()
//    {
//        throw new \Exception("Meta: get method should be overridden");
//    }
//
//    protected function set_value($value)
//    {
//        throw new \Exception("Meta: set method should be overridden");
//    }

    protected function default_value()
    {
        return $this->default_value;
    }

    protected function validates($value){

        return $this->model->validate($value, $this->validators);

    }
}
<?php

namespace vg\wordpress_plugin\model\meta;

class Option extends Meta
{
    public $name;
    public $group;

    public function __construct($name, $group, $default_value, $validators, $model)
    {
        // call the parent constructor
        parent::__construct($name, $default_value, $validators, $model);

        // store the group
        $this->group = $group;
    }

    public function register()
    {
        // add a callback function for wordpress to register to appropriate settings
        add_action('admin_init', array($this, 'register_option_handler'));
    }

    public function register_option_handler()
    {
        // register the setting otherwise wordpress won't save it when posted
        register_setting($this->group, $this->name(), array($this, 'sanitize'));
    }

    public function sanitize($value)
    {
        // TODO: sanitize and validate the data

        // if doesn't pass validation, use the previous value as the return value?

        if (!is_array($this->validators))
        {
            $message = "The validators for '$this->name'' isn't an array.";
            $html_id = 'html_id_1';
            $type = 'error'; // or updated

            add_settings_error($this->name(true), $html_id, $message, $type);
        }

        if(!count($this->validators))
        {
            $message = "You didn't define any validators for '$this->name''";
            $html_id = 'html_id_1';
            $type = 'error'; // or updated

            add_settings_error($this->name(true), $html_id, $message, $type);
        }

        // validate the value with the validators, returns true OR array with error messages
        $messages = $this->model->validate($value, $this->validators);

        // if there are any errors
        if (is_array($messages))
        {
            $html_id = 'validation_error_';
            $type = 'error';

            for($i = 0; $i < count($messages); $i++)
            {
                add_settings_error($this->name(true), $html_id . $i, $messages[$i], $type);
            }

        }

        // if there are any errors
        if (count(get_settings_errors()))
        {
            // return the previous value
            return $this->get();
        }
        else
        {
            return $value;
        }


    }

    protected function get_value()
    {
        return get_option($this->name());
    }

    protected function set_value($value)
    {
        return update_option($this->name(true), $value);
    }

}
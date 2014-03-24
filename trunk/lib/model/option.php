<?php

namespace vg\wordpress_plugin\model;

class Option
{
    private $name;
    private $default_value;
    private $validators;
    private $prefix;

    public function __construct($name, $default_value, $validators, $prefix)
    {
        // store the settings
        $this->name = $name;
        $this->default_value = $default_value;
        $this->validators = $validators;
        $this->prefix = $prefix;
    }

    public function name($with_prefix = false)
    {
        if ($with_prefix)
        {
            return $this->prefix . $this->name;
        }
        else
        {
            return $this->name;
        }
    }

    public function get()
    {
        // check if the value exists
        $value = get_option($this->name(true));

        // returns falue
        if ($value === false)
        {
            // get the default value
            $default = $this->default_value();

            // set the value
            $this->set($default);

            // store for the return value
            $value = $default;
        }

        // return the value
        return $value;
    }

    public function set($value)
    {
        // create the option in the database
        update_option($this->name(true), $value);
    }

    public function is_valid()
    {

    }

    // function called by wordpress action, returns the sanitized value
    public function sanitize($value)
    {
        // TODO: should check each of the validators here

        $message = "You didn't define any validators";
        $html_id = 'html_id_1';
        $type = 'error'; // or updated

        add_settings_error( $this->name(true), $html_id, $message, $type);

        return $value;
    }

    private function default_value()
    {
        return $this->default_value();
    }
}
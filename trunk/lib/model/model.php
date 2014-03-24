<?php
/**
 * Created by PhpStorm.
 * User: maarten
 * Date: 24/03/14
 * Time: 09:47
 */

namespace vg\wordpress_plugin\model;

class Model
{
    protected $option_group = '';
    protected $prefix = '';
    protected $options;

    private $register_settings = false;

    function __construct()
    {
        // instantiate the options array
        $this->options = [];
    }

    protected function create_option($option_name, $default_value, $validators)
    {
        if ($this->register_settings === false) {

            // set the boolean value
            $this->register_settings = true;

            // add a callback function for wordpress to register to appropriate settings
            add_action('admin_init', array($this, 'register_settings'));
        }

        // instantiate a new option
        $option = new Option($option_name, $default_value, $validators, $this->prefix);

        // store the option
        $this->options[$option_name] = $option;

        // return the option
        return $option;
    }

    public function register_settings()
    {
        // iterate each of the options
        foreach ($this->options as $option_name => $option)
        {
            // register the option with wordpress
            register_setting($this->option_group, $option->name(true), array($option, 'sanitize'));
        }
    }

}
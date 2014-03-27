<?php

namespace vg\wordpress_plugin\model;

class Model
{
    // set when instantiated
    public $plugin;
    public $meta_prefix;
    // set when instantiated


    public function __construct()
    {
        // instantiate the options array
        $this->options = [];
    }

    public function activate()
    {
        // can be overridden by the child class
    }

    public function deactivate()
    {
        // can be overridden by the child class
    }

    public function initialize()
    {

        throw new \Exception("Model: initialize method should be overridden.");

    }


    protected function create_post_meta($meta_type, $meta_field_name, $default_value, $validators)
    {
        $meta = new meta\Post($meta_field_name, $meta_type, $default_value, $validators, $this);

        return $meta;
    }

    protected function create_option_meta($option_name, $option_group, $default_value, $validators)
    {
        // TODO: throws error if field already exists

        // instantiate a new option
        $option = new meta\Option($option_name, $option_group, $default_value, $validators, $this);

        // return the option
        return $option;
    }



    public function validate($value, $validators)
    {
        $messages = [];

        // iterate each of the validators
        for ($i = 0; $i < count($validators); $i++) {

            // get the validator
            $validator = $this->get_validator($validators[$i]);

            // store the error message somewhere?
            if ($validator->validate($value) === false) {

                // the validation fails
                $messages[] = $validator->error_message($value);
            }

        }

        if (count($messages))
        {
            return $messages;
        }
        else
        {
            return true;
        }
    }

    // TODO: the storing of singletons should be done in the plugin class
    private static $loaded_validators = [];

    private function get_validator($validator_name)
    {
        if (array_key_exists($validator_name, Model::$loaded_validators)) {
            return Model::$loaded_validators[$validator_name];
        } else {
            // get the validator
            $validator = $this->load_validator($validator_name);

            // store with the instantiated validators
            Model::$loaded_validators[$validator_name] = $validator;

            // return the validator
            return $validator;
        }
    }

    private function load_validator($validator_name)
    {
        // include the file and instantiate
        return $this->plugin->instantiate_validator($validator_name);
    }

}
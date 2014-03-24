<?php

namespace vg\wordpress_plugin\validator;

class IntValidator extends Validator
{
    public function error_message($value)
    {
        return "The value '$value' should be an int";
    }

    public function is_valid($value)
    {
        return false;
    }
}
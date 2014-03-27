<?php

namespace vg\wordpress_plugin\model\meta;

class Post extends Meta
{
    public $type;

    public function __construct($name, $type, $default_value, $validators, $model)
    {
        parent::__construct($name, $default_value, $validators, $model);

        $this->type = $type;

        add_action('save_post', array($this, 'save_data'));
    }

    public function save_data($post_id)
    {
        // Verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if (!isset( $_POST[$this->name . '_nonce'] ) || !wp_verify_nonce( $_POST[$this->name . '_nonce'], $this->name . '_nonce_action' ))
        {
            return $post_id;
        }

        // Verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
        // to do anything
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return $post_id;

        // when nothing posted return
        if (!isset($_POST[$this->name]) || !isset($_POST['post_type']))
            return $post_id;

        // get the post type
        $post_type = $_POST['post_type'];

        // if not is the same type
        if ($post_type != $this->type)
            return $post_id;

        // get the post data
        $post_data = $_POST[$this->name];

        // try to update the data
        $this->set($post_data, $post_id);

        // TODO: save post error?

        // return the post id?
        return $post_id;
    }

    protected function get_value($post_id)
    {
        $return = get_post_meta($post_id, $this->name, true);

        return $return;
    }

    protected function set_value($value, $post_id)
    {
        // returns new meta id, true on success or false on failure
        $return = update_post_meta($post_id, $this->name, $value);

        if ($return === false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}


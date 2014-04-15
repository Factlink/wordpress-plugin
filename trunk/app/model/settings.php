<?php

namespace factlink\model;

class Settings extends \vg\wordpress_plugin\model\Model
{
    public $is_enabled_options;
    public $meta;
    public $is_configured;
    public $disable_global_comments;

    public $menu_parent_slug = 'options-general.php';
    public $menu_page_title = 'Factlink settings';
    public $menu_title = 'Factlink';
    public $menu_capability = 'administrator';
    public $menu_slug = 'factlink_settings_page';
    public $menu_url;


    function initialize()
    {
        // set the admin page url using wordpress method
        $this->menu_url = get_admin_url(null, $this->menu_parent_slug . "?page=" . $this->menu_slug);

        // setting to display configuration message as long factlink isn't configured
        $this->is_configured = $this->create_option_meta('is_configured', 'global_settings', 0, array('int'));

        // settings for totally disabling global comments
        $this->disable_global_comments = $this->create_option_meta('disable_global_comments', 'global_settings', 0, array('int'));

        $this->is_enabled_options = array();
        $this->meta = array();

        $post_types = get_post_types(array("public" => true), 'object');

        // create database handlers for all the different post types
        foreach ($post_types as $post_type => $post_type_data)
        {
            $this->is_enabled_options[$post_type] = $this->create_option_meta("enabled_for_$post_type", 'global_settings', 2, array('int'));
            $this->meta[$post_type] = $this->create_post_meta($post_type, 'is_enabled', 0, array('int'));
        }
    }

    public function activate()
    {
        // when the plugin is activated
        // set the state of the is_configured to 0 -> not configured
        $this->is_configured->set(0);
    }

    public function is_enabled_for_post($post_id)
    {
        $post = get_post($post_id);

        if ($post === null)
            return false;

        if (!isset($this->is_enabled_options[$post->post_type]))
            return false;

        $is_enabled_value = $this->is_enabled_options[$post->post_type]->get();
        $post_meta_value = $this->meta[$post->post_type]->get($post_id);

        if ($is_enabled_value == 0)
            return false;

        if ($is_enabled_value == 1 && $post_meta_value == 1)
            return true;

        if ($is_enabled_value == 2)
            return true;

        return false;
    }
}

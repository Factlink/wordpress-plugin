<?php

namespace factlink\model;

class Settings extends \vg\wordpress_plugin\model\Model
{
    public $enabled_for_posts;
    public $enabled_for_pages;
    public $is_configured;
    public $disable_global_comments;

    public $post_meta;
    public $page_meta;

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

        // setting if factlink is enabled for all the pages
        $this->enabled_for_pages = $this->create_option_meta('enabled_for_pages', 'global_settings', 1, ['int']);

        // setting if factlink is enabled for all the posts
        $this->enabled_for_posts = $this->create_option_meta('enabled_for_posts', 'global_settings', 1, ['int']);

        // setting to display configuration message as long factlink isn't configured
        $this->is_configured = $this->create_option_meta('is_configured', 'global_settings', 0, ['int']);

        // settings for totally disabling global comments
        $this->disable_global_comments = $this->create_option_meta('disable_global_comments', 'global_settings', 1, ['int']);

        // get a post meta data object
        $this->post_meta = $this->create_post_meta('post', 'is_enabled', 1, ['int']);

        // create page meta object
        $this->page_meta = $this->create_post_meta('page', 'is_enabled', 1, ['int']);
    }

    public function activate()
    {
        // when the plugin is activated
        // set the state of the is_configured to 0 -> not configured
        $this->is_configured->set(0);
    }

    public function deactivate()
    {
        // when the plugin is deactivated
        // set the state of the is_configured to 0 -> not configured
        $this->is_configured->set(0);
    }
}

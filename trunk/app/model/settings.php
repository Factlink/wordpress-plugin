<?php
/**
 * Created by PhpStorm.
 * User: maarten
 * Date: 24/03/14
 * Time: 09:49
 */

namespace factlink\model;

class Settings extends \vg\wordpress_plugin\model\Model
{
    public $enabled_for_posts;
    public $enabled_for_pages;
    public $is_configured;
    public $disable_global_comments;

    public $post_meta;
    public $page_meta;


    function initialize()
    {
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
        // set the state of the is_configured to 0 -> not configured
        $this->is_configured->set(0);
    }

    public function deactivate()
    {
        // set the state of the is_configured to 0 -> not configured
        $this->is_configured->set(0);
    }
}
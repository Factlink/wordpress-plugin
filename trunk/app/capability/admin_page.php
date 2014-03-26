<?php

namespace factlink\capability;

class AdminPage extends \vg\wordpress_plugin\capability\Capability
{
    /***
     * @var \factlink\model\Settings
     */
    public $settings;

    public function initialize()
    {
        // settings for the admin page
        $parent_slug = 'options-general.php';
        $page_title = 'Factlink settings';
        $menu_title = 'Factlink';
        $capability = 'administrator';
        $menu_slug = 'factlink_settings_page';

        // use the builtin render
        $render_callback = array($this, 'admin_page_requested');

        // create a sub-level menu
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $render_callback);

        // register the options that can be updated through the view
        $this->settings->enabled_for_pages->register();
        $this->settings->enabled_for_posts->register();
    }

    public function admin_page_requested()
    {
        // set the used option group
        $this->option_group = $this->settings->enabled_for_posts->group;

        // the configuration notice will be disabled
        // TODO: should be placed somewhere else, because now still displays one time when configuration is loaded
        $this->settings->is_configured->set(1);

        // render the admin page
        $this->render();
    }
}
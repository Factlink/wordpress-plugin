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
        $parent_slug = $this->settings->menu_parent_slug;
        $page_title = $this->settings->menu_page_title;
        $menu_title = $this->settings->menu_title;
        $capability = $this->settings->menu_capability;
        $menu_slug = $this->settings->menu_slug;

        // use the builtin render
        $render_callback = array($this, 'admin_page_requested');

        // create a sub-level menu
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $render_callback);

        // register the options that can be updated through the view
        $this->settings->enabled_for_pages->register();
        $this->settings->enabled_for_posts->register();
        $this->settings->disable_global_comments->register();
    }

    public function admin_page_requested()
    {
        // set the used option group
        $this->option_group = $this->settings->enabled_for_posts->group;

        // render the admin page
        $this->render();
    }
}

<?php

namespace factlink\capability;

class AdminPage extends \vg\wordpress_plugin\capability\Capability
{
    /***
     * @var \factlink\model\Settings
     */
    public $settings;

    private $settings_group = 'factlink_settings_group';

    public function initialize()
    {
        // settings for the admin page
        $parent_slug = 'options-general.php';
        $page_title = 'Factlink settings';
        $menu_title = 'Factlink';
        $capability = 'administrator';
        $menu_slug = 'factlink_settings_page';

        // use the builtin render
        $render_callback = array($this, 'render');

        // create a sub-level menu
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $render_callback);

    }
}
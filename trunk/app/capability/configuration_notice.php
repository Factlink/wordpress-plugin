<?php

namespace factlink\capability;

class ConfigurationNotice extends \vg\wordpress_plugin\capability\Capability
{
    // public members are available in the view
    public $url;

    /***
     * inject:
     * @var \factlink\model\Settings
     */
    public $settings;

    public function initialize()
    {
        // TODO: maybe use $_GET['page'] instead of current screen?

        $menu_slug = 'factlink_settings_page';

        $screen = get_current_screen();



        // if not yet configured AND isn't on the settings page, display the notification
        if ($this->settings->is_configured->get() == 0 && $screen->id != "settings_page_$menu_slug")
        {
            $parent_slug = 'options-general.php';

            $this->url = get_admin_url(null, $parent_slug . "?page=" . $menu_slug);
            $this->render();
        }
    }
}
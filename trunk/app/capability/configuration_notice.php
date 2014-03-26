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
        if ($this->settings->is_configured->get() == 0)
        {
            $parent_slug = 'options-general.php';
            $menu_slug = 'factlink_settings_page';
            $this->url = get_admin_url(null, $parent_slug . "?page=" . $menu_slug);
            $this->render();
        }
    }
}
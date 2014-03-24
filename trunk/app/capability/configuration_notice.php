<?php

namespace factlink\capability;

class ConfigurationNotice extends \vg\wordpress_plugin\capability\Capability
{
    // public members are available in the view
    public $url;

    public function initialize()
    {
        $parent_slug = 'options-general.php';
        $menu_slug = 'factlink_settings_page';
        $this->url = get_admin_url(null, $parent_slug . "?page=" . $menu_slug);

        $this->render();
    }
}
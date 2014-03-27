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
        // if the current page is the admin page, remove the configuration message
        if (isset($_GET['page']) && $_GET['page'] == $this->settings->menu_slug) {
            $this->settings->is_configured->set(1);
        }

        // if not yet configured
        if ($this->settings->is_configured->get() == 0) {
            // get the menu url
            $this->url = $this->settings->menu_url;

            // render the configuration notice
            $this->render();
        }
    }
}

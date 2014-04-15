<?php

namespace factlink\capability;

class IncludeFactlink extends \vg\wordpress_plugin\capability\Capability
{
    /***
     * inject the model:
     * @var \factlink\model\Settings
     */
    public $settings;

    public function initialize()
    {
        global $post;

        if ($this->settings->is_enabled_for_post($post))
        {
            $this->render();
        }
    }
}

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
        $id = get_queried_object_id();

        if ($this->settings->enabled_for_pages->get() == 1 &&

            is_page() &&

            ($this->settings->enabled_for_all_pages->get() == 0 && $this->settings->page_meta->get($id) == 1) ||

            $this->settings->enabled_for_all_pages->get() == 1

        ) {
            $this->render();
        }

        if ($this->settings->enabled_for_posts->get() == 1 &&

            is_single() &&

            ($this->settings->enabled_for_all_posts->get() == 0 && $this->settings->post_meta->get($id) == 1) ||

            $this->settings->enabled_for_all_posts->get() == 1
        ) {
            // render factlink
            $this->render();
        }
    }
}

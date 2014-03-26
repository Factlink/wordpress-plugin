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

        // if factlink is enabled for all pages
        if ($this->settings->enabled_for_pages->get() == 1 &&

            // and the current page is a single page
            is_page() &&

            // and factlink is explicitly enabled for the current page
            $this->settings->page_meta->get($id) == 1
        )
        {
            $this->render();
        }

        // if factlink is enabled for all posts
        if ($this->settings->enabled_for_posts->get() == 1 &&

            // and the current page is a single post
            is_single() &&

            // and if factlink is enabled for the current page
            $this->settings->post_meta->get($id) == 1
        )
        {
            // render factlink
            $this->render();
        }
    }
}
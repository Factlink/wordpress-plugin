<?php

namespace factlink\capability;

class IncludeFactlink extends \vg\wordpress_plugin\capability\Capability
{
    public function initialize()
    {
        // check if the current page is a single post
        $a = is_single();

        // check if the current page is a single page
        $b = is_page();

        // only when the detail page or blog is displayed
        if (is_singular())
        {
            echo '';
        }

        $this->render();
    }
}
<?php

namespace factlink\capability;

class MetaBox extends \vg\wordpress_plugin\capability\Capability
{
    public function initialize()
    {
        $id = 'factlink-settings-meta';
        $title = 'FactLink settings';
        $callback = array($this, 'render');
        $post_type = 'post';
        $context = 'advanced';

        add_meta_box($id, $title, $callback, $post_type, $context);
    }

    public function render()
    {
        echo "Checkbox for enabling or disabling factlink for this post";
    }
}
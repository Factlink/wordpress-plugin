<?php

namespace factlink\capability;

class MetaBox extends \vg\wordpress_plugin\capability\Capability
{
    /***
     * inject
     * @var \factlink\model\Settings
     */
    public $settings;

    public $meta_name;
    public $meta_value;

    public $is_published;

    public function initialize($post_type, $post)
    {
        if (isset($this->settings->is_enabled_options[$post_type]))
        {
            $is_enabled_option = $this->settings->is_enabled_options[$post_type];
            $post_meta = $this->settings->meta[$post_type];

            $this->is_published = $post->post_status == 'publish';

            if ($is_enabled_option->get() == 1)
            {
                $id = 'factlink-settings-meta';
                $title = 'FactLink settings';
                $context = 'advanced';

                $this->meta_name = $post_meta->name();
                $this->meta_value = $post_meta->get($post->ID);

                // can't directly call the render callback, because the render callback passes arguments
                add_meta_box($id, $title, array($this, 'render_meta_box'), $post_type, $context);
            }
        }
    }

    public function render_meta_box()
    {
        $this->render();
    }
}

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

    public function initialize($post_type, $post)
    {
        $this->meta_name = $this->settings->post_meta->name;
        $this->meta_value = $this->settings->post_meta->get($post->ID);

        $id = 'factlink-settings-meta';
        $title = 'FactLink settings';
        $context = 'advanced';

        if ($this->settings->enabled_for_pages->get() == 1 && $post_type == 'page')
        {
            add_meta_box($id, $title, array($this, 'render_page_meta_box'), 'page', $context);
        }

        if ($this->settings->enabled_for_posts->get() == 1 && $post_type == 'post')
        {
            add_meta_box($id, $title, array($this, 'render_post_meta_box'), 'post', $context);
        }
    }

    public function render_page_meta_box($post_data)
    {
        $this->meta_name = $this->settings->page_meta->name;
        $this->render();
    }

    public function render_post_meta_box($post_data)
    {
        $this->meta_name = $this->settings->post_meta->name;
        $this->render();
    }


}
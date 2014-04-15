<?php

namespace factlink\capability;

class AdminPage extends \vg\wordpress_plugin\capability\Capability
{
    /***
     * @var \factlink\model\Settings
     */
    public $settings;
    public $option_group;
    public $is_enabled_options;

    public function initialize()
    {
        $parent_slug = $this->settings->menu_parent_slug;
        $page_title = $this->settings->menu_page_title;
        $menu_title = $this->settings->menu_title;
        $capability = $this->settings->menu_capability;
        $menu_slug = $this->settings->menu_slug;

        $render_callback = array($this, 'admin_page_requested');

        // create a sub-level menu in the wordpress admin menu (wp-admin)
        // sub-level means below an existing menu item
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $render_callback);

        // register the options that can be updated through the view
        // needs to be called, otherwise the settings won't register and a strange page will be displayed

        $this->is_enabled_options = $this->settings->is_enabled_options;

        foreach($this->is_enabled_options as $post_type => $is_enabled_option)
        {
            $is_enabled_option->register();
            $this->option_group = $is_enabled_option->group;
        }

        $this->settings->disable_global_comments->register();
    }

    public function get_post_type_label($post_type)
    {
        $obj = get_post_type_object($post_type);

        if ($post_type == 'attachment')
        {
            $label = $obj->labels->name . ' caption';
        }
        else
        {
            $label = $obj->labels->name;
        }



        if ($label != "")
            return $label;
        else
            return $post_type;
    }


    public function admin_page_requested()
    {
        $this->render();
    }
}

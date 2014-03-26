<?php
/**
 * Created by PhpStorm.
 * User: maarten
 * Date: 26/03/14
 * Time: 16:53
 */

namespace factlink\capability;

class DisableComments extends \vg\wordpress_plugin\capability\Capability
{
    /***
     * inject:
     * @var \factlink\model\Settings
     */
    public $settings;

    public function initialize()
    {
        if ($this->settings->disable_global_comments->get() == 1)
        {
            // add a filter to when wordpress asks if comments are open for the current post, can return false
            add_filter( 'comments_open', array($this, 'disable_comments_filter'), 10, 2 );

            // TODO: remove / replace the comments link from the top admin bar
            // TODO: remove / replace the comments link from the left admin bar
        }
    }

    // the return value determines if the comment is enabled / disabled for the current page
    public function disable_comments_filter( $open, $post_id ) {

        return false;

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: maarten
 * Date: 24/03/14
 * Time: 09:49
 */

namespace factlink\model;

class Settings extends \vg\wordpress_plugin\model\Model
{
    // TODO: should be done somewhere else? Or pulled from central location?
    protected $prefix = 'factlink_';

    // TODO: use option group?
    protected $option_group = 'factlink_option_group';


    public $option_1;


    // TODO: replaced by overridden method
    function __construct()
    {
        // call the parent constructor
        parent::__construct();

        // create option 1
        $this->option_1 = $this->create_option('option_1', 0, ['int']);
    }
}
<?php
/**
 * @package Factlink
 * @version 0.2
 */
/*
Plugin Name: Factlink
Plugin URI: https://factlink.com/
Description: Factlink enables your readers to share inline comments and annotations.
Author: Factlink
Version: 0.2
Author URI: https://factlink.com/
*/

defined( 'ABSPATH' ) or die ( 'Cannot access pages directly.' );

function add_factlink() {
  echo '<script async="async" defer="defer" src="https://static.factlink.com/lib/dist/factlink_loader.min.js?o=wordpress"></script>';
}

add_action( 'wp_head', 'add_factlink' );

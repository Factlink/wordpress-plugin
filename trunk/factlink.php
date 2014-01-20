<?php
/**
 * @package Factlink
 * @version 0.1
 */
/*
Plugin Name: Factlink
Plugin URI: https://factlink.com/
Description: Factlink works on helping people understand how credible the information is that they’re reading online.
Author: Factlink
Version: 0.1
Author URI: https://factlink.com/
*/

defined( 'ABSPATH' ) or die ( 'Cannot access pages directly.' );

function add_factlink() {
  echo '<script async="async" defer="defer" src="https://static.factlink.com/lib/dist/factlink_loader_publishers.min.js"></script>';
}

add_action( 'wp_head', 'add_factlink' );

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
  wp_enqueue_script( 'factlink', 'https://static.factlink.com/lib/dist/factlink_loader_publishers.min.js', '', false, true );
}

add_action( 'init', 'add_factlink' );

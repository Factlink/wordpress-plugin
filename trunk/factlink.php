<?php
/**
 * @package Factlink
 * @version 1.1
 */
/*
Plugin Name: Factlink for Wordpress
Plugin URI: https://factlink.com/
Description: Integrates the Factlink commenting & annotation tool in your Wordpress website
Author: Factlink
Version: 1.1
Author URI: https://factlink.com/
*/

defined( 'ABSPATH' ) or die ( 'Cannot access pages directly.' );

function add_factlink() {
  echo '<script async="async" defer="defer" src="https://static.factlink.com/lib/dist/factlink_loader.min.js?o=wordpress"></script>';
}

add_action( 'wp_head', 'add_factlink' );

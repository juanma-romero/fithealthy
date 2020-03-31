<?php
/**
 * Theme functions and definitions
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
/**
 * Theme functions
 */
if( !function_exists('is_plugin_active') ) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}
include get_template_directory() . '/inc/theme-functions/theme-functions.php';
/**
 * Theme customize and metaboxes
 */
include get_template_directory() . '/inc/metaboxes/meta-boxes.php';
include get_template_directory() . '/inc/customize/customize.php';
include get_template_directory() . '/inc/customize/customize-style.php';
/**
 * Woocommerce functions
 */
if (class_exists('WooCommerce')) {
    include get_template_directory() . '/inc/woocommerce/woocommerce.php';
}
if (is_plugin_active('clever-vc-addon/clever-vc-addon.php')&& class_exists('Vc_Manager')) {
    function zoo_custom_shortcode()
    {
        include get_template_directory() . '/inc/theme-functions/shortcode-custom.php';
    }
    add_action('after_setup_theme', 'zoo_custom_shortcode');
}
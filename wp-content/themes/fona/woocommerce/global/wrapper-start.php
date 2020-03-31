<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$template = wc_get_theme_slug_for_templates();
$zoo_sidebar = zoo_woo_sidebar();
$zoo_wrap_class = '';
switch ($zoo_sidebar) {
    case 'no-sidebar':
        $zoo_wrap_class = 'col-xs-12';
        break;
    case 'top-sidebar':
        $zoo_wrap_class = 'col-xs-12';
        break;
    default:
        $zoo_wrap_class = 'col-xs-12 col-sm-9';
        break;
}

switch ($template) {
    case 'twentyten' :
        echo '<div id="container"><div id="content" role="main">';
        break;
    case 'twentyeleven' :
        echo '<div id="primary"><div id="content" class="twentyeleven">';
        break;
    case 'twentytwelve' :
        echo '<div id="primary" class="site-content"><div id="content" class="twentytwelve">';
        break;
    case 'twentythirteen' :
        echo '<div id="primary" class="site-content"><div id="content" class="entry-content twentythirteen">';
        break;
    case 'twentyfourteen' :
        echo '<div id="primary" class="content-area"><div id="content" class="site-content twentyfourteen"><div class="tfwc">';
        break;
    case 'twentyfifteen' :
        echo '<div id="primary" class="content-area twentyfifteen"><div id="main" class="site-main t15wc">';
        break;
    case 'twentysixteen' :
        echo '<div id="primary" class="content-area twentysixteen"><main id="main" class="site-main">';
        break;
    default :
        echo '<div id="content-product" class="wrap-product-page ' . esc_attr($zoo_wrap_class) . '">';
        break;
}

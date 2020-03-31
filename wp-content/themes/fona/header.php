<?php
/**
 * The template for displaying the header
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php
    wp_head();
    ?>
</head>
<body <?php body_class(); ?>>
<?php
$zoo_class_header = '';
$zoo_header_top = zoo_enable_header_top();
$zoo_header_layout = zoo_header_layout();
$zoo_class_header .= zoo_header_fullwidth() . ' ' . $zoo_header_layout . ' ' . zoo_header_transparent();
if (zoo_header_layout() != 'stack-center' && zoo_header_layout() != 'menu-bottom'  && zoo_header_layout() != 'stack-center-2') {
    $zoo_class_header .= ' search-popup';
}
if (get_post_meta(get_the_ID(), 'zoo_enable_header_inner_bg', true) == 1 && is_page()) {
    $zoo_class_header .= ' inner-header-bg';
}
if (get_theme_mod('zoo_site_page_loader', '0') == 1) {
    ?>
    <div id="page-load">
        <span class="loading"></span>
    </div>
    <?php
}
if (zoo_header_stick() != '') {
    wp_enqueue_script('sticky');
}
if (is_active_sidebar('canvas-sidebar')) {
    ?>
    <div id="canvas-sidebar" class="sidebar canvas">
        <span class="close-canvas"><i class="cs-font clever-icon-close-1"></i> </span>
        <?php
        if (get_option('woocommerce_enable_myaccount_registration') === 'yes') {

                ?>
                <div class="widget-acc-info">
                    <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
                       title="<?php echo esc_attr__('My Account', 'fona'); ?>">
                        <i class="cs-font  clever-icon-user-6"></i>
                        <span>
                <?php
            if (is_user_logged_in()) {
                echo esc_html__('Hello', 'fona');
                $zoo_current_user = wp_get_current_user();
                printf(' %s!', esc_html($zoo_current_user->display_name));
            }else{
                esc_html_e('Login','fona');
            }
                ?>
            </span>
                    </a>
                </div>
                <?php
        }
        dynamic_sidebar('canvas-sidebar'); ?></div>
    <div class="mask-canvas-sidebar"></div>
    <?php
}
?>
<?php if (zoo_boxes()) : ?>
<div class="layout-boxes container <?php if (get_theme_mod('zoo_site_layout_box_shadow', '1') == 1) {
    echo esc_attr('box-shadow');
} ?>">
    <?php endif; ?>
    <div class="mask-nav"></div>
    <div class="wrap-mobile-nav">
        <span class="close-nav"><i class="cs-font clever-icon-close"></i> </span>
        <nav id="mobile-nav" class="primary-font">
            <?php wp_nav_menu(array('container_class' => 'mobile-menu', 'theme_location' => 'mobile')); ?>
        </nav>
    </div>
    <header id="zoo-header" class="wrap-header <?php echo esc_attr($zoo_class_header); ?>">
        <?php
        if ($zoo_header_top && ($zoo_header_layout != 'two-lines-3' && $zoo_header_layout != 'two-lines-4')) {
            get_template_part('/inc/templates/header/top', 'header');
        }
        get_template_part('/inc/templates/header/' . $zoo_header_layout, 'layout');
        if (zoo_header_layout() != 'stack-center' && zoo_header_layout() != 'menu-bottom' && zoo_header_layout() != 'stack-center-2') {
            get_template_part('/inc/templates/search', 'form');
        }
        ?>
    </header>
<?php
get_template_part('inc/templates/breadcrumbs');

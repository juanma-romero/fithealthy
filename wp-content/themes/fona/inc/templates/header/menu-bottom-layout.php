<?php
/**
 * Menu stack center layout.
 * Template of Zoo Theme
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
$zoo_sticky = zoo_header_stick();
?>
<div id="main-header" class="wrap-header-block menu-bottom-layout">
    <div class="wrap-main-header">
        <div class="container">
            <div id="site-branding">
                <a id="menu-mobile-trigger" href="#"
                   class="mobile-menu-icon">
                    <i class="clever-icon-menu-5 cs-font"></i>
                    <i class="cs-font clever-icon-close"></i>
                </a>
                <a id="search-mobile-trigger" href="#">
                    <i class="cs-font clever-icon-search-5"></i>
                </a>
                <div class="wrap-logo">
                    <?php get_template_part('inc/templates/logo'); ?>
                </div>
            </div>
            <?php
            get_template_part('/inc/templates/search', 'form');
            get_template_part('inc/templates/header/icon', 'header'); ?>
        </div>
    </div>

</div>
<div id="bottom-header" class="wrap-header-block <?php echo esc_attr($zoo_sticky) ?>">
    <div class="container">
        <div id="sec-nav" class="second-nav">
            <?php
            if (has_nav_menu('second')) {
                $nav_locations=get_nav_menu_locations();
                $menu_obj = wp_get_nav_menu_object( $nav_locations['second'])?>
                <h3 class="menu-title"><i class="cs-font clever-icon-menu-5"></i> <?php esc_html_e($menu_obj->name)?><i class="cs-font clever-icon-down"></i> </h3>
            <?php
                wp_nav_menu(array('container_class' => 'sec-menu', 'theme_location' => 'second', 'container' => 'nav'));
            } else {
                ?>
                <h3 class="menu-title"><?php echo esc_html__("Second Menu",'fona')?></h3>
                <?php
                wp_nav_menu(array('container_class' => 'sec-menu', 'container' => 'nav'));
            }
            ?>
        </div>
        <div id="main-navigation" class="primary-nav menu-mini-cart ">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu(array('container_class' => 'main-menu', 'theme_location' => 'primary', 'container' => 'nav'));
            } else {
                wp_nav_menu(array('container_class' => 'main-menu', 'container' => 'nav'));
            }
            get_template_part('woocommerce/theme-custom/mini-top', 'cart');
            ?>
        </div>
    </div>
</div>
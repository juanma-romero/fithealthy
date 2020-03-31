<?php
/**
 * Menu Right layout.
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
<div id="main-header"  class="wrap-header-block menu-right-layout <?php echo esc_attr($zoo_sticky) ?>">
    <div class="container">
        <div class="content-header-block">
            <a id="menu-mobile-trigger" href="#"
               class="mobile-menu-icon">
                <i class="clever-icon-menu-5 cs-font"></i>
            </a>
            <a id="search-mobile-trigger" href="#">
                <i class="cs-font clever-icon-search-5"></i>
            </a>
            <div id="site-branding">
                <?php get_template_part('inc/templates/logo'); ?>
            </div>
            <div id="main-navigation" class="primary-nav">
                <?php
                if(has_nav_menu('primary')){
                    wp_nav_menu(array('container_class' => 'main-menu', 'theme_location' => 'primary', 'container'=>'nav'));
                }else{
                    wp_nav_menu(array('container_class' => 'main-menu', 'container'=>'nav'));
                }
                ?>
            </div>
            <?php get_template_part('inc/templates/header/icon', 'header'); ?>
        </div>
    </div>
</div>
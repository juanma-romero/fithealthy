<?php
/**
 * Menu stack center 2 layout.
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
<div id="main-header" class="wrap-header-block stack-center-layout style-3">
    <div id="site-branding">
        <div class="container">
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
    </div>
    <div id="main-navigation" class="primary-nav menu-mini-cart <?php echo esc_attr($zoo_sticky) ?>">
        <div class="container">
            <?php
            $zoo_page_sticky_logo = get_theme_mod('zoo_site_logo_sticky', '');
            if (is_single() || is_page()) {
                $zoo_page_sticky_logo = get_post_meta(get_the_ID(), 'zoo_sticky_logo_page', true);
            }
            if ($zoo_page_sticky_logo != '') {
                ?>
                <div class="wrap-sticky-logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"
                       title="<?php bloginfo('name'); ?>"><?php
                        echo wp_get_attachment_image($zoo_page_sticky_logo, 'full', '', array("class" => "sticky-logo"));
                        ?>
                    </a>
                </div>
                <?php
            }
            if (has_nav_menu('primary')) {
                wp_nav_menu(array('container_class' => 'main-menu', 'theme_location' => 'primary', 'container' => 'nav'));
            } else {
                wp_nav_menu(array('container_class' => 'main-menu', 'container' => 'nav'));
            }
            get_template_part('inc/templates/header/icon', 'header'); ?>
        </div>
    </div>
</div>
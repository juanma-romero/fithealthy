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
?>
<ul id="icon-header" class="list-icon">
    <li class="search"><a href="#" class="search-trigger"
                          title="<?php echo esc_attr__('Toggle Search block', 'fona') ?>"><i
                    class="cs-font clever-icon-search-5"></i><i class="cs-font clever-icon-close"></i></a></li>
    <?php if (class_exists('WooCommerce')) {
        if (get_theme_mod('zoo_login_icon', '1')) {
            if (!is_user_logged_in()) { ?>
                <li class="icon-user login">
                    <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" title="<?php echo esc_attr__('My Account', 'fona'); ?>" >
                        <i class="cs-font clever-icon-user-6"></i>
                    </a>
                    <div class="login-form-popup">
                        <div class="wrap-login-form">
                            <span class="close-login"><i class="cs-font clever-icon-close"></i></span>
                            <p><span class="lb-login"><?php echo esc_html__('Sign In', 'fona'); ?></span>
                                <a  href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="register"><?php echo esc_html__('Create an Account', 'fona'); ?></a>
                            </p>
                            <?php echo do_shortcode('[woocommerce_my_account]'); ?>
                        </div>
                        <div class="overlay"></div>
                    </div>
                </li>
            <?php } else {
                    ?>
                <li class="icon-user logout">
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" title="<?php echo esc_html__('Hello', 'fona');
                    $zoo_current_user = wp_get_current_user();
                    printf(' %s!', esc_html($zoo_current_user->display_name));?>">
                        <i class="cs-font clever-icon-user-6"></i>
                    </a>
                    <div class="wrap-dashboard-form">
                        <?php echo do_shortcode('[woocommerce_my_account]'); ?>
                    </div>
                </li>
                <?php
            }
        }
        if (is_plugin_active('yith-woocommerce-wishlist/init.php')) {
            $wishlist_url = YITH_WCWL()->get_wishlist_url();
            ?>
            <li class="top-wl-url">
                <a href="<?php echo esc_url($wishlist_url) ?>" rel="nofollow"
                   title="<?php echo apply_filters('yith-wcwl-browse-wishlist-label', '') ?>">
                    <i class="cs-font clever-icon-heart-o"></i>
                </a>
            </li>
            <?php
        }
        if (!zoo_woo_catalog_mod()) { ?>
            <li class="top-ajax-cart">
                <?php
                get_template_part('woocommerce/theme-custom/topheadcart'); ?>
            </li>
            <?php
        }
    }
    if (is_active_sidebar('canvas-sidebar')) {
        ?>
        <li class="canvas-sidebar-control">
            <a href="#" rel="nofollow" class="canvas-sidebar-trigger"
               title="<?php echo esc_attr__('Show/Hide off canvas sidebar', 'fona') ?>">
                <i class="cs-font clever-icon-three-dots"></i>
            </a>
        </li>
        <?php
    } ?>
</ul>

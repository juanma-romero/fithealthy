<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header('shop');
get_template_part('/woocommerce/theme-custom/woo', 'cover');
wp_enqueue_script('lazyload-master');
wp_enqueue_script('imagesloaded');
wp_enqueue_script('isotope');
wp_enqueue_script('tippy');
if (zoo_woo_enable_quickview()) {
    wp_enqueue_style('slick');
    wp_enqueue_script('wc-add-to-cart-variation');
    if (zoo_woo_enable_zoom()) {
        wp_enqueue_style('zoomove');
        wp_enqueue_script('zoomove');
    }
}

$zoo_col = get_theme_mod('zoo_shop_columns', 4);

if (isset($_COOKIE['col-control'])) {
    $zoo_col = $_COOKIE['col-control'];
}

?>
<main id="main-page" class="wrap-site-main">
    <div id="primary"
         class="zoo-woo-page container <?php echo esc_attr(zoo_woo_sidebar() . ' ' . zoo_woo_sidebar_status()) ?>">
        <div class="mask-sidebar"></div>
        <?php


        if (zoo_woo_sidebar() == 'no-sidebar') {
            /**
             * woocommerce_sidebar hook.
             *
             * @hooked woocommerce_get_sidebar - 10
             */
            get_template_part('woocommerce/woo-sidebar', 'left');
        }
        do_action('zoo_woo_print_notices');

        check_vendor() ? get_template_part('/woocommerce/theme-custom/vendor', 'info') : '';

        if (is_active_sidebar(get_theme_mod('zoo_shop_sidebar', 'shop-sidebar')) && zoo_woo_sidebar() == 'top-sidebar') {
            ?>
            <div id="top-shop-widget" style="display:none">
                <?php dynamic_sidebar(get_theme_mod('zoo_shop_sidebar', 'shop-sidebar')); ?>
            </div>
            <?php
        }
        ?>
        <div id="top-product-page">
            <div class="left-top-product-page">
                <?php if (is_active_sidebar(get_theme_mod('zoo_shop_sidebar', 'shop-sidebar'))) { ?>
                    <a href="#" class="sidebar-control"
                       title="<?php echo esc_attr__('Show/Hide Sidebar', 'fona'); ?>">
                        <i class="cs-font clever-icon-funnel-o"></i>
                        <span><?php echo esc_html__('Filter', 'fona'); ?></span>
                    </a>
                    <?php
                }
                do_action('zoo_woocommerce_breadcrumb');
                ?>
            </div>
            <div class="center-top-product-page">
                <ul class="layout-control-column">
                    <li class="item <?php echo esc_attr($zoo_col == '1' ? 'active' : ''); ?>" data-column="1"><i
                                class="box"></i></li>
                    <li class="item  <?php echo esc_attr($zoo_col == '2' ? 'active' : ''); ?>" data-column="2"><i
                                class="box"></i><i class="box"></i></li>
                    <li class="item  <?php echo esc_attr($zoo_col == '3' ? 'active' : ''); ?>" data-column="3"><i
                                class="box"></i><i class="box"></i><i class="box"></i></li>
                    <li class="item  <?php echo esc_attr($zoo_col == '4' ? 'active' : ''); ?>" data-column="4"><i
                                class="box"></i><i class="box"></i><i class="box"></i><i class="box"></i></li>
                    <li class="item  <?php echo esc_attr($zoo_col == '5' ? 'active' : ''); ?>" data-column="5"><i
                                class="box"></i><i class="box"></i><i class="box"></i><i class="box"></i><i
                                class="box"></i></li>
                </ul>
            </div>
            <div class="right-top-product-page">
                <?php
                /**
                 *
                 * woocommerce_before_shop_loop hook.
                 *
                 * @hooked woocommerce_result_count - 20
                 * @hooked woocommerce_catalog_ordering - 30
                 */
                do_action('woocommerce_before_shop_loop');
                ?>
            </div>
        </div>
        <div class="row">
            <?php
            if (zoo_woo_sidebar() == 'left-sidebar') {
                /**
                 * woocommerce_sidebar hook.
                 *
                 * @hooked woocommerce_get_sidebar - 10
                 */
                get_template_part('woocommerce/woo-sidebar', 'left');
            }
            /**
             * woocommerce_before_main_content hook.
             *
             * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
             * @hooked woocommerce_breadcrumb - 20
             */
            do_action('woocommerce_before_main_content');

            if ( woocommerce_product_loop() ) {
                woocommerce_product_loop_start();

                if ( wc_get_loop_prop( 'total' ) ) {
                    while ( have_posts() ) {
                        the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         *
                         * @hooked WC_Structured_Data::generate_product_data() - 10
                         */
                        do_action( 'woocommerce_shop_loop' );

                        wc_get_template_part( 'content', 'product' );
                    }
                }

                woocommerce_product_loop_end();

                /**
                 * Hook: woocommerce_after_shop_loop.
                 *
                 * @hooked woocommerce_pagination - 10
                 */
                do_action( 'woocommerce_after_shop_loop' );
            } else {
                /**
                 * Hook: woocommerce_no_products_found.
                 *
                 * @hooked wc_no_products_found - 10
                 */
                do_action( 'woocommerce_no_products_found' );
            }

            /**
             * Hook: woocommerce_after_main_content.
             *
             * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
             */
            do_action('woocommerce_after_main_content');
            if (zoo_woo_sidebar() == 'right-sidebar') {
                /**
                 * woocommerce_sidebar hook.
                 *
                 * @hooked woocommerce_get_sidebar - 10
                 */
                get_template_part('woocommerce/woo-sidebar', 'right');
            }
            ?>
        </div>
    </div>
</main>
<?php
get_footer('shop'); ?>

<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop');
$zoo_single_class='content-area zoo-woo-page zoo-content-single';
wp_enqueue_script('wc-add-to-cart-variation');
?>
<main id="main-page" class="wrap-site-main">
    <div id="primary" class="<?php echo esc_attr($zoo_single_class);?>">
        <?php while (have_posts()) : the_post();
            get_template_part('woocommerce/theme-custom/single-product', 'navigation');
            wc_get_template_part('content', 'single-product');
            endwhile;?>
    </div>
</main>
<?php get_footer('shop'); ?>

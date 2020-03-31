<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}
global $product;
$zoo_single_layout = zoo_woo_gallery_layout_single();
$post_thumbnail_id = $product->get_image_id();
$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
?>
<div class="images">
<div class="wrap-single-image">
    <ul class="wrap-single-carousel woocommerce-product-gallery__wrapper">
        <?php
        $attributes = array(
            'title' => get_post_field( 'post_title', $post_thumbnail_id ),
            'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
            'data-src' => $full_size_image[0],
            'data-large_image' => $full_size_image[0],
            'data-large_image_width' => $full_size_image[1],
            'data-large_image_height' => $full_size_image[2],
        );

        if (has_post_thumbnail()) {
            $html = '<li class="woocommerce-product-gallery__image  woocommerce-main-image zoom"  data-zoo-image="' . esc_url($full_size_image[0]) . '"><a href="' . esc_url($full_size_image[0]) . '" class="zoo-woo-lightbox"><i class="cs-font  clever-icon-expand"></i></a>';
            $html .= get_the_post_thumbnail(get_the_ID(), 'shop_single', $attributes);
            $html .= '</li>';
        } else {
            $html = '<li class="woocommerce-product-gallery__image woocommerce-main-image"><a class="">';
            $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
            $html .= '</a></li>';
        }

        echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);

        $attachment_ids = $product->get_gallery_image_ids();

        if ($attachment_ids) {

            foreach ($attachment_ids as $attachment_id) {
                $full_size_image = wp_get_attachment_image_src($attachment_id, 'full');
                if ($full_size_image) {
                    $thumbnail_post = get_post($attachment_id);
                    $image_title = $thumbnail_post->post_content;
                    $attributes = array(
                        'title' => $image_title,
                        'data-src' => $full_size_image[0],
                        'data-large_image' => $full_size_image[0],
                        'data-large_image_width' => $full_size_image[1],
                        'data-large_image_height' => $full_size_image[2],
                    );
                    $html = '<li class="woocommerce-product-gallery__image  zoom woocommerce-main-image" data-zoo-image="' . esc_url($full_size_image[0]) . '"><a href="' . esc_url($full_size_image[0]) . '"  class="zoo-woo-lightbox"  title="' . $image_title . '"><i class="cs-font  clever-icon-expand"></i></a>';
                    $html .= wp_get_attachment_image($attachment_id, 'shop_single', false, $attributes);
                    $html .= '</li>';
                    echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $attachment_id);
                }
            }
        }
        ?>
    </ul>
</div>
    <?php
    if($zoo_single_layout == 'horizontal-gallery' || $zoo_single_layout == 'vertical-gallery'|| $zoo_single_layout == 'vertical-gallery-center-thumb'|| $zoo_single_layout == 'center') {
        do_action('woocommerce_product_thumbnails');
    }?>
</div>
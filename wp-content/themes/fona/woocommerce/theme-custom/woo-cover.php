<?php
/**
 * Template display cover image of Woocommerce Page
 * @since: zoo-theme 1.0.0
 * @Ver: 1.0.0
 */
if(!check_vendor()) {
    if (is_shop() && get_theme_mod('zoo_slider_cover', '') != '') {
        ?>
        <div id="woo-cover-page">
            <?php echo do_shortcode(get_theme_mod('zoo_slider_cover'));
            ?>
        </div>
        <?php
    } else {
        $zoo_title = $zoo_bg_id = '';
        $zoo_style = 'padding-top:' . get_theme_mod('zoo_shop_cover_padding_top', '0') . 'px;' . 'padding-bottom:' . get_theme_mod('zoo_shop_cover_padding_bottom', '0') . 'px;';
        $zoo_style .= 'background-color:' . get_theme_mod('zoo_shop_cover_color_bg', 'transparent') . ';';
        $zoo_bg = get_theme_mod('zoo_shop_cover_img_bg', '');
        $zoo_title = get_theme_mod('zoo_shop_cover_text', '');

        if (is_product_category()) {
            global $wp_query;
            $cat = $wp_query->get_queried_object();
            if ($cat->description != '') {
                $zoo_title = $cat->description;
            }
            $thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
            $thumb = wp_get_attachment_url($thumbnail_id);
            $zoo_bg = $thumb ? $thumb : $zoo_bg;
        }

        if ($zoo_bg != '') {
            $zoo_style .= 'background-image:url(' . $zoo_bg . ');';
        }
        ?>
        <div id="woo-cover-page" class="cover-without-slider" style="<?php echo esc_attr($zoo_style); ?>">
            <?php
            if ($zoo_title != '') {
                ?>
                <div class="container"><h2 class="shop-cover-title"><?php echo esc_html($zoo_title); ?></h2></div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}
?>


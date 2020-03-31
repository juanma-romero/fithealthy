<?php

/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage zoo-theme
 * @since zoo-theme 1.0
 */
$zoo_sidebar = get_theme_mod('zoo_shop_sidebar', 'shop-sidebar');
if(is_single()){
    $zoo_sidebar = get_theme_mod('zoo_single_product_sidebar', 'shop-sidebar');
}?>
<aside id="zoo-woo-sidebar-right" class="zoo-woo-sidebar widget-area col-xs-12 col-sm-3" role="complementary">
    <div class="header-sidebar">
        <span><?php esc_html_e('Filter','fona') ?></span>
    <a href="#" class="close-btn close-sidebar" title="<?php esc_attr__('Close','fona')?>"><i class="cs-font clever-icon-close"></i> </a>
    </div>
    <div class="content-zoo-woo-sidebar">
        <?php dynamic_sidebar($zoo_sidebar); ?>
    </div>
</aside>

<?php
/**
 * Breadcrumbs template
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
$zoo_active_bc = get_theme_mod('zoo_disable_breadcrumbs', '1') == '1' ? false : true;
if ((is_single() || is_page()) && get_post_meta(get_the_ID(), 'zoo_disable_breadcrumbs', true) == 1) {
    $zoo_active_bc = false;
}
if (class_exists('WooCommerce')) {
    if (is_woocommerce()) {
        $zoo_active_bc = false;
    }
}
if ($zoo_active_bc):
    ?>
    <div class="wrap-breadcrumb">
        <div class="container">
            <?php zoo_breadcrumbs('', 'cs-font clever-icon-arrow-right' )  ?>
        </div>
    </div>
<?php endif; ?>
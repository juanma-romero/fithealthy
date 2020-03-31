<?php
/**
 * Search form
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
?>
<div class="header-search-block">
        <span class="close-search"><i class="cs-font clever-icon-close"></i></span>
    <?php
    if(is_plugin_active('ajax-search-lite/ajax-search-lite.php')){
        echo do_shortcode('[wpdreams_ajaxsearchlite]');
    }else{
    ?>
    <form method="get" class="clearfix" action="<?php echo esc_url(home_url('/')); ?>">
        <?php
        if (class_exists('WooCommerce')) {
            ?>
            <input type="hidden" name="post_type" value="product"/>
            <?php
        } ?>
        <input type="text" class="ipt text-field body-font" name="s"
               placeholder="<?php echo esc_attr__('Search entire store here...', 'fona'); ?>" autocomplete="off"/>
        <button type="submit" class="btn">
            <i class="cs-font clever-icon-search-5"></i>
        </button>
    </form>
    <?php } ?>
</div>
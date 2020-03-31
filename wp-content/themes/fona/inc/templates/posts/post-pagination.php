<?php
/**
 * Post pagination template
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */

$zoo_pag_type = get_theme_mod('zoo_blog_pagination', 'numeric');
$zoo_block_layout = 'inc/templates/posts/archive/'.get_theme_mod('zoo_blog_layout', 'grid').'-layout.php';
if ($zoo_pag_type == 'infinity') {
    zoo_ajax_pagination($GLOBALS['wp_query'], array('type' => 'infinity'));
} else if ($zoo_pag_type == 'ajaxload') {
    zoo_ajax_pagination($GLOBALS['wp_query'], array('type' => 'ajaxload'));
}else if ($zoo_pag_type == 'numeric') {
    the_posts_pagination( array(
        'prev_text'          =>'<i class="cs-font clever-icon-prev"></i>',
        'next_text'          => '<i class="cs-font clever-icon-next"></i>',
        'before_page_number' => '',
    ) );
} else if ($zoo_pag_type == 'simple') {
    /* Previous/next link. */ ?>
    <div class="zoo-wrap-pagination primary-font simple">
        <div class="prev-page">
            <?php
            previous_posts_link(esc_html__('Previous page', 'fona'));
            ?>
        </div>
        <div class="next-page">
            <?php
            next_posts_link(esc_html__('Next page', 'fona'));
            ?>
        </div>
    </div>
    <?php
}

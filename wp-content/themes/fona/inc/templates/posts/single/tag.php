<?php
/**
 * Block information for post
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
if (get_theme_mod('zoo_blog_single_tags', '1') == 1 && has_tag()) {
    ?>
    <div class="tags-link-wrap clearfix">
        <?php the_tags('', ' ', ''); ?>
    </div>
<?php } ?>
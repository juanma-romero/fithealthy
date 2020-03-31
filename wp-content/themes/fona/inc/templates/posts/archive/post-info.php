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
?>
<ul class="post-info">
    <li class="date-post">
        <?php esc_html_e('By ', 'fona');
        the_author_posts_link(); ?>
    </li>
    <li class="line-space">
        -
    </li>
    <li class="date-post">
        <?php echo esc_html(get_the_date()); ?>
    </li>
    <li class="line-space">
        -
    </li>
    <li class="cat-post-label">
        <?php
        esc_html_e('in ', 'fona');
        echo get_the_category_list(', ', false, get_the_ID());
        ?>
    </li>
</ul>


<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
        <div class="header-post container">
            <div class="wrap-header-post-info col-sm-9 col-xs-12">
                <?php
                if (is_sticky()) {
                    ?>
                    <span class="sticky-post-label"><?php echo esc_html__('Featured', 'fona') ?></span>
                    <?php
                }
                the_title('<h1 class="title-detail">', '</h1>');
                ?>
                <ul class="post-info">
                    <li class="post-author-label">
                        <?php esc_html_e('by ', 'fona');
                        the_author_posts_link(); ?>
                    </li>
                    <li class="date-post">
                        <?php echo esc_html(get_the_date()); ?>
                    </li>
                    <li class="post-cat">
                        <?php
                        esc_html_e('in ', 'fona');
                        echo get_the_category_list(', ', false, get_the_ID());
                        ?>
                    </li>
                </ul>
            </div>
            <?php get_template_part('inc/templates/posts/single/media'); ?>
        </div>
        <div class="container">
            <div class="wrap-post-content col-sm-9 col-xs-12">
                <div class="post-content">
                    <?php
                    the_content();
                    ?>
                </div>
                <?php
                //do not remove
                get_template_part('inc/templates/inpost', 'pagination');
                edit_post_link(esc_html__('Edit', 'fona'), '<span class="edit-link">', '</span>');
                //Allow custom below
                ?>
                <div class="bottom-post">
                    <?php
                    get_template_part('inc/templates/posts/single/tag');
                    get_template_part('inc/templates/posts/single/share', 'post');
                    ?>
                </div>
            </div>
        </div>
        <div class="footer-post container">
            <?php
            get_template_part('inc/templates/posts/single/post', 'navigation');
            get_template_part('inc/templates/posts/single/about', 'author');
            get_template_part('inc/templates/posts/single/related', 'posts');
            ?>
        </div>
    </article>
<?php
if (comments_open() || get_comments_number()) :
    comments_template('', true);
endif;

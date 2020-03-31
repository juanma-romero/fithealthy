<?php
/**
 * Post Label block
 *
 * @package     Zoo fona
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
?>
<ul class="post-label">
    <?php
    if (is_sticky()) {
        ?>
        <li class="sticky-post-label"><?php echo esc_html__('Featured', 'fona') ?></li>
        <?php
    }
    $zoo_categories = get_the_category(get_the_ID());
    if (!empty($zoo_categories)) {
        foreach ($zoo_categories as $zoo_category) {
            ?>
            <li class="cat-post-label">
                <a href="<?php echo get_category_link( $zoo_category->term_id );?>" title="<?php echo esc_attr( $zoo_category->name);?>">
                    <?php echo esc_html( $zoo_category->name);?>
                </a>
            </li>
    <?php
        }
    }
    ?>
</ul>
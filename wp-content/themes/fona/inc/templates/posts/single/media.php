<?php
/**
 * Media block for post
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
if (has_post_format('video')) : ?>
    <div class="media-block single-video">
        <?php $zoo_video = get_post_meta(get_the_ID(), '_format_video_embed', true); ?>
        <?php if (wp_oembed_get($zoo_video)) : ?>
            <?php echo wp_oembed_get($zoo_video); ?>
        <?php else : ?>
            <?php echo ent2ncr($zoo_video); ?>
        <?php endif; ?>
    </div>
<?php elseif (has_post_format('audio')) : ?>
    <div class="media-block audio single-audio">
        <?php $zoo_audio = get_post_meta(get_the_ID(), '_format_audio_embed', true); ?>
        <?php if (wp_oembed_get($zoo_audio)) : ?>
            <?php echo wp_oembed_get($zoo_audio); ?>
        <?php else : ?>
            <?php echo ent2ncr($zoo_audio); ?>
        <?php endif; ?>
    </div>
<?php elseif (has_post_format('quote')) :
    $zoo_quote_content = get_post_meta(get_the_ID(), '_format_quote_source_content', true);
    if ($zoo_quote_content != '') {
        ?>
        <div class="quote-block single-quote">
            <h3 class="quote-content"><?php echo esc_html($zoo_quote_content); ?></h3>
            <h5 class="quote-author"><?php echo esc_html(get_post_meta(get_the_ID(), '_format_quote_source_name', true)); ?></h5>
        </div>
    <?php } ?>
    <?php
elseif (has_post_format('gallery')) : ?>
    <?php $zoo_images = get_post_meta(get_the_ID(), '_format_gallery_images', true);
    if ($zoo_images) :
        wp_enqueue_style('slick');
        wp_enqueue_style('slick-theme');
        wp_enqueue_script('slick');
        ?>
        <div class="media-block single-gallery">
            <ul class="post-slider">
                <?php
                if (has_post_thumbnail()) :
                    ?>
                    <li>
                        <?php
                        the_post_thumbnail('full-thumb'); ?>
                    </li>
                <?php endif;
                if (!empty($zoo_images)):
                    foreach ($zoo_images as $zoo_image) : ?>
                        <?php $zoo_the_image = wp_get_attachment_image_src($zoo_image, 'full-thumb'); ?>
                        <?php $zoo_the_caption = get_post_field('post_excerpt', $zoo_image); ?>
                        <li><img src="<?php echo esc_url($zoo_the_image[0]); ?>"
                                 <?php if ($zoo_the_caption) : ?>title="<?php echo esc_attr($zoo_the_caption); ?>"<?php endif; ?> />
                        </li>
                    <?php endforeach;
                endif;
                ?>
            </ul>
        </div>
    <?php endif;
else:
    if (has_post_thumbnail()) :
        ?>
        <div class=" media-block post-image single-image">
            <?php
            the_post_thumbnail('full-thumb'); ?>
        </div>
    <?php endif;
endif;
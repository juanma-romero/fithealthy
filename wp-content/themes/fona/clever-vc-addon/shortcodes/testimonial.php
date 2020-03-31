<?php
/**
 * Testimonial Shortcode
 */

$css_class = '';

$custom_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), 'CleverTestimonial', $atts );

if ( !empty( $atts['el_class'] ) ) {
    $css_class .= ' ' . $atts['el_class'];
}

if ( !empty( $custom_class ) ) {
    $css_class .= ' ' . $custom_class;
}
$css_class.=' '.$atts['preset_style'];
$args = array(
    'post_type' => 'testimonial',
    'order_by' => $atts['order_by'],
    'posts_per_page' => ($atts['item_count'] > 0) ? $atts['item_count'] : get_option('posts_per_page'),
);
if ($atts['category']) {
    $catid = array();
    foreach (explode(',', $atts['category']) as $catslug) {
        $catid[] .= get_term_by('slug', $catslug, 'testimonial_category')->term_id;
    }
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'testimonial_category',
            'field' => 'id',
            'terms' => $catid,
        )
    );
}
$class = '';
switch ($atts['columns']) {
    case '2':
        $class .= "col-xs-12 col-sm-6";
        break;
    case '3':
        $class .= "col-xs-12 col-sm-4";
        break;
    case '4':
        $class .= "col-xs-12 col-sm-3";
        break;
    case '5':
        $class .= "col-xs-12 col-sm-1-5";
        break;
    case '6':
        $class .= "col-xs-12 col-sm-2";
        break;
    default:
        $class .= "col-xs-12";
        break;
}
$wrapID = 'testimonial_block_' . uniqid();
if ($atts['style'] == 'carousel') {
    wp_enqueue_style('slick');
    wp_enqueue_script('slick');
    wp_enqueue_script('cvca-script');
}
?>
<div id="<?php echo esc_attr($wrapID) ?>"
     class="cvca-testimonial-shortcode cvca-testimonial relative<?php echo esc_attr( $css_class ); ?> <?php echo esc_attr($atts['style']) . '-testimonial' ?>">
     <?php if ( !empty( $atts['overlay_color'] ) ) : ?>
     <span class="zoo-addon-overlay"<?php echo ( !empty( $atts['overlay_color'] ) ) ? ' style="background-color:' . $atts['overlay_color'] . '"' : ''; ?>></span>
    <div class="zoo-overlay-content">
    <?php endif; ?>
<?php
$the_query = new WP_Query($args);
if ($the_query->have_posts()):
    if ($atts['title'] != '') { ?>
        <h2 class="title-block"><?php echo esc_attr($atts['title']); ?></h2>
    <?php }
    if ($atts['style'] == 'carousel') {
        $item = $atts['columns'];
        $pagination = $atts['carousel_pag'] == 'yes' ? "true" : "false";
        $navigation = $atts['carousel_nav'] == 'yes' ? "true" : "false";
        $jsconfig = '{"item":"' . $item . '","pagination":"' . $pagination . '","navigation":"' . $navigation . '"}';
    } ?>
    <div class="cvca-wrapper-testimonial-block <?php if ($atts['style'] == 'carousel') {
        echo esc_attr('cvca-carousel');
    } ?>"
        <?php if ($atts['style'] == 'carousel') { ?> data-config=' <?php echo esc_attr($jsconfig); ?> ' <?php } ?>>
        <?php
        while ($the_query->have_posts()):$the_query->the_post();
            ?>
            <article id="testimonial-<?php the_ID(); ?>" <?php echo post_class('cvca-testimonial-item ' . $class) ?>>
                <?php
                if (get_post_meta(get_the_ID(), 'zoo_author_img', true) != '' && !$atts['hide_avatar']) {
                    ?>
                    <div class="cvca-wrap-avatar">
                        <img
                                src="<?php echo wp_get_attachment_image_url(get_post_meta(get_the_ID(), 'zoo_author_img', true), 'full') ?>"
                                alt="<?php the_title(); ?>" class="avatar-circus"/>
                    </div>
                <?php } ?>
                <div class="cvca-testimonial-content">
                    <?php if ($atts['output_type'] == 'excerpt') {
                        echo cvca_get_excerpt($atts['excerpt_length']);
                    } else {
                        the_content();
                    } ?>
                </div>
                <div class="cvca-wrap-author-info">
                    <?php
                    if (get_post_meta(get_the_ID(), 'zoo_author', true) != '') { ?>
                        <h4 class="cvca-testimonial-author"><?php
                            echo esc_html(get_post_meta(get_the_ID(), 'zoo_author', true)); ?>
                        </h4>
                    <?php } ?>
                    <?php
                    if (get_post_meta(get_the_ID(), 'zoo_author_des', true) != '') { ?>
                        <div class="cvca-testimonial-des"><?php
                            echo esc_html(get_post_meta(get_the_ID(), 'zoo_author_des', true)); ?>
                        </div>
                        <?php
                    } ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>
    <?php if ( !empty( $atts['overlay_color'] ) ) : ?>
        </div>
    <?php endif; ?>
    </div>
    <?php
endif;
wp_reset_postdata();
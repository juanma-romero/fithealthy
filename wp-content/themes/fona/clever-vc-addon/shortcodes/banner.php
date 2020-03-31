<?php
/**
 * Banner Shortcode
 */

wp_enqueue_style('cvca-style');

$css_class = $zoo_start_link = $zoo_link_text = $zoo_end_link = '';

$custom_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($atts['css'], ' '), 'CleverBanner', $atts);

if (!empty($atts['el_class'])) {
    $css_class .= ' ' . $atts['el_class'];
}

if (!empty($atts['content_align'])) {
    $css_class .= ' ' . $atts['content_align'];
}

if (!empty($custom_class)) {
    $css_class .= ' ' . $custom_class;
}
if (!empty($atts['box_shadow'])) {
    $css_class .= ' box-shadow';
}
if (!empty($atts['preset'])) {
    $css_class .= ' ' . $atts['preset'];
}else{
    $css_class .= ' default';
}
$zoo_allow_tag = array(
    'a' => array(
        'class' => array(),
        'href' => array(),
        'target' => array(),
        'rel' => array(),
        'title' => array()
    ),
    'br' => array()
);

if (!empty($atts['link'])) {
    $zoo_link = vc_build_link($atts['link']);

    if ($zoo_link['url'] != '') {
        $zoo_start_link = '<a';
        $zoo_start_link .= ' class="banner-media-link"';
        $zoo_start_link .= ' href="' . $zoo_link['url'] . '"';

        if ($zoo_link['title'] != '') {
            $zoo_start_link .= ' title="' . $zoo_link['title'] . '"';
        }

        if ($zoo_link['target'] != '') {
            $zoo_start_link .= ' target="' . $zoo_link['target'] . '"';
        }

        if ($zoo_link['rel'] != '') {
            $zoo_start_link .= ' rel="' . $zoo_link['rel'] . '"';
        }

        $zoo_start_link .= '>';
    }

    $zoo_link_text = ($zoo_link['title'] != '') ? $zoo_link['title'] : '';

    if ($zoo_link['url'] != '') {
        $zoo_end_link = '</a>';
    }
}
if (!empty($zoo_link_text)) {
    $css_class .= ' has-button';
}
?>
<div class="cvca-shortcode-banner cvca-custom-banner cvca-banner-image<?php echo esc_attr($css_class); ?>">
    <?php
    if ($zoo_link_text == '') echo wp_kses($zoo_start_link, $zoo_allow_tag);
    if ($atts['image'] != '') { ?>
        <div class="banner-media<?php echo (empty($atts['link'])) ? ' banner-media-link' : ''; ?>">
            <?php if ($atts['image'] != '') {
                ?>
                <span class="zoo-addon-overlay"<?php echo (!empty($atts['overlay_color'])) ? ' style="background-color:' . $atts['overlay_color'] . '"' : ''; ?>></span>
                <?php
                echo wp_get_attachment_image($atts['image'], 'full');
            } ?>
        </div>
    <?php }
    if ($atts['title'] != '' || !empty($content)):
        ?>
        <div class="banner-content">
            <?php if ($atts['title'] != '') : ?>
                <h4 class="banner-title">
                    <?php echo ent2ncr($atts['title']); ?>
                </h4>
            <?php endif; ?>

            <?php if (!empty($content)) : ?>
                <div class="banner-description">
                    <?php echo ent2ncr($content); ?>
                </div>
            <?php endif;
            if ($zoo_link_text != '' && ($atts['preset'] == 'style-2'||$atts['preset'] == 'style-4'||$atts['preset'] == 'style-5')) :
                    echo wp_kses($zoo_start_link, $zoo_allow_tag);
                    echo esc_html($zoo_link_text);
                    echo wp_kses($zoo_end_link, $zoo_allow_tag);
            endif;
            ?>
        </div>
        <?php
    endif;
    if ($zoo_link_text == '') echo wp_kses($zoo_end_link, $zoo_allow_tag);
    if ($zoo_link_text != '' && ($atts['preset'] != 'style-2'&&$atts['preset'] != 'style-4'&&$atts['preset'] != 'style-5')) :
        ?>
        <div class="wrap-banner-link">
            <?php
            echo wp_kses($zoo_start_link, $zoo_allow_tag);
            echo esc_html($zoo_link_text);
            echo wp_kses($zoo_end_link, $zoo_allow_tag);
            ?>
        </div>
        <?php
    endif;
    ?>
</div>

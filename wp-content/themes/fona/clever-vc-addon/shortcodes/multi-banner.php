<?php
/**
 * Multi Banner Shortcode
 */

wp_enqueue_style('cvca-style');
wp_enqueue_script('isotope');
wp_enqueue_script('cvca-script');

$css_class = $zoo_start_link = $zoo_link_text = $zoo_end_link = '';

$custom_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($atts['css'], ' '), 'CleverMultiBanner', $atts);

if (!empty($atts['el_class'])) {
    $css_class .= ' ' . $atts['el_class'];
}if (!empty($atts['preset'])) {
    $css_class .= ' ' . $atts['preset'];
    if($atts['preset']=='style-3'){
        wp_enqueue_style(
            'zoo_banner_style_3',
            '//fonts.googleapis.com/css?family=Playfair+Display:400,400i'
        );
    }
}
if (!empty($custom_class)) {
    $css_class .= ' ' . $custom_class;
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
$groupbanner = vc_param_group_parse_atts($atts['group_banner']);
$gutter = $atts["gutter"];
$gutter_margin = '';
$gutter_padding = '';
if ($gutter > 0) {
    $gutter = $gutter / 2;
    $gutter_margin = 'margin: 0 -' . ($gutter) . 'px;';
    $gutter_padding = 'padding: ' . ($gutter) . 'px;';
}

?>
<div class="cvca-shortcode-multi-banner cvca-custom-banner <?php echo esc_attr($css_class); ?>"
     data-layout='<?php echo esc_attr($atts['layout']); ?>'>
    <?php
    if (count($groupbanner) > 0) {
        ?>
        <div class="wrap-content-multi-banner" style="<?php echo esc_attr($gutter_margin) ?>">
            <?php
            foreach ($groupbanner as $banner) {
                $banner_width = '';
                if ($banner['col'] != 'auto'&&$banner['col'] != '0') {
                    $banner_width = 'width:' . (($banner['col'] / 12) * 100) . '%';
                }
                ?>
                <div class="banner-item <?php echo esc_attr($banner['content_align']) ?>"
                     style="<?php echo esc_attr($gutter_padding . ' ' . $banner_width) ?>">
                    <div class="wrap-banner-item">
                        <?php
                        if (!empty($banner['link'])) {
                            $zoo_link = vc_build_link($banner['link']);

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
                        echo wp_kses($zoo_start_link, $zoo_allow_tag);
                        if ($banner['image'] != '') {
                            echo wp_get_attachment_image($banner['image'], 'full');
                        } ?>
                        <div class="wrap-bn-content">
                            <?php if ($banner['title'] != '') : ?>
                                <h4 class="title">
                                    <?php echo esc_html($banner['title']); ?>
                                </h4>
                            <?php endif; ?>
                            <?php if (isset($banner['content'])) : ?>
                                <div class="description">
                                    <?php echo ent2ncr($banner['content']);  ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($zoo_link_text != '') { ?>
                                <span class="banner-media-link">
                        <?php
                        echo esc_html($zoo_link_text);
                        ?></span>
                            <?php } ?>
                        </div>
                        <span class="banner-overlay"<?php echo (!empty($banner['overlay_color'])) ? ' style="background-color:' . $banner['overlay_color'] . '"' : ''; ?>></span>
                        <?php
                        echo wp_kses($zoo_end_link, $zoo_allow_tag);
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>

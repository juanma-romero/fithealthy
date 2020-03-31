<?php
/**
 * Team member Shortcode
 */
wp_enqueue_style('cvca-style');
$id = 'cvca-team-member-' . uniqid();
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($atts['css'], ' '), 'CleverTeamMember', $atts);
$css_class .= ' cvca-team-member ' . $atts['el_class'];
?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($css_class) ?>">
    <div class="wrap-head-team-member">
        <?php if ($atts['avatar'] != '') { ?>
            <?php echo wp_get_attachment_image($atts['avatar'], 'full'); ?>
        <?php } ?>
    </div>
    <div class="cvca-team-member-content">
        <?php if ($atts['member_name'] != '') : ?>
            <h4 class="member-name">
                <?php echo esc_html($atts['member_name']) ?>
            </h4>
        <?php endif; ?>

        <?php if ($atts['member_position'] != '') : ?>
            <p class="member-position">
                <?php echo esc_html($atts['member_position']) ?>
            </p>
        <?php endif; ?>

        <?php if ($atts['member_des'] != '') : ?>
            <div class="member-desciption">
                <?php echo esc_html($atts['member_des']) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($atts['facebook']) || !empty($atts['dribbble']) || !empty($atts['twitter']) || !empty($atts['messenger']) || !empty($atts['google_plus']) || !empty($atts['skype']) || !empty($atts['instagram']) || !empty($atts['github']) || !empty($atts['flickr']) || !empty($atts['youtube']) || !empty($atts['vimeo']) || !empty($atts['tumblr'])) : ?>
            <ul class="member-social social-share">

                <?php if (!empty($atts['facebook'])) : ?>
                    <li class="facebook"><a href="<?php echo esc_url($atts['facebook']); ?>" class="socail-item"
                                            title="Facebook"><i class="fa fa-facebook"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($atts['dribbble'])) : ?>
                    <li class="dribbble"><a href="<?php echo esc_url($atts['dribbble']); ?>" class="socail-item"
                                            title="Dribbble"><i class="fa fa-dribbble"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($atts['twitter'])) : ?>
                    <li class="twitter"><a href="<?php echo esc_url($atts['twitter']); ?>" class="socail-item"
                                           title="Twitter"><i class="fa fa-twitter"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($atts['messenger'])) : ?>
                    <li class="messenger"><a href="<?php echo esc_url($atts['messenger']); ?>" class="socail-item"
                                             title="Messenger"><i class="fa fa-envelope"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($atts['google_plus'])) : ?>
                    <li class="google-plus"><a href="<?php echo esc_url($atts['google_plus']); ?>" class="socail-item"
                                               title="Google plus"><i class="fa fa-google-plus"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($atts['skype'])) : ?>
                    <li class="skype"><a href="<?php echo esc_url($atts['skype']); ?>" class="socail-item" title="Skype"><i
                                    class="fa fa-skype"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($atts['instagram'])) : ?>
                    <li class="instagram"><a href="<?php echo esc_url($atts['instagram']); ?>" class="socail-item"
                                             title="Instagram"><i class="fa fa-instagram"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($atts['github'])) : ?>
                    <li class="github"><a href="<?php echo esc_url($atts['github']); ?>" class="socail-item"
                                          title="Github"><i class="fa fa-github"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($atts['flickr'])) : ?>
                    <li class="flickr"><a href="<?php echo esc_url($atts['flickr']); ?>" class="socail-item"
                                          title="Flickr"><i class="fa fa-flickr"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($atts['youtube'])) : ?>
                    $output .= '
                    <li class="youtube"><a href="<?php echo esc_url($atts['youtube']); ?>" class="socail-item"
                                           title="Youtube"><i class="fa fa-youtube"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($atts['vimeo'])) : ?>
                    <li class="vimeo"><a href="<?php echo esc_url($atts['vimeo']); ?>" class="socail-item" title="Vimeo"><i
                                    class="fa fa-vimeo"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($atts['tumblr'])) : ?>
                    <li class="flickr"><a href="<?php echo esc_url($atts['tumblr']); ?>" class="socail-item"
                                          title="Tumblr"><i class="fa fa-tumblr"></i></a></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

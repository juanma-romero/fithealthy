<?php
/**
 * Template display cover image of Woocommerce Page
 * @since: zoo-theme 1.0.0
 * @Ver: 1.0.0
 */
?>
<?php
global $WCMp;
$vendor_info = zoo_get_vendor_info();
$vendor_id = zoo_get_vendor_id();
$vendor_banner = $vendor_info['banner'] != '' ? $vendor_info['banner'] : '';
$vendor = get_wcmp_vendor($vendor_id);
$vendor_hide_address = apply_filters('wcmp_vendor_store_header_hide_store_address', get_user_meta($vendor_id, '_vendor_hide_address', true), $vendor->id);
$vendor_hide_phone = apply_filters('wcmp_vendor_store_header_hide_store_phone', get_user_meta($vendor_id, '_vendor_hide_phone', true), $vendor->id);
$vendor_hide_email = apply_filters('wcmp_vendor_store_header_hide_store_email', get_user_meta($vendor_id, '_vendor_hide_email', true), $vendor->id);

$location = $vendor_info['location'];
$address_1 = $vendor_info['address_1'];
$address_2 = $vendor_info['address_2'];
$mobile = $vendor_info['mobile'];
$email = $vendor_info['email'];
$description = $vendor_info['description'];
?>
<div class="warp-vendor-info"<?php if ($vendor_banner != '') { ?> style="background-image: url('<?php echo esc_url($vendor_banner); ?>');"<?php } ?>>
        <div class="vendor-img-profile">
            <?php if ($vendor_info['profile']) { ?>
                <img src="<?php echo esc_url($vendor_info['profile']); ?>">
            <?php } ?>
        </div>
        <div class="vendor-content-profile">
            <?php if ($vendor_info['display_name']) { ?>
                <h2 class="vendor-title"><?php echo esc_attr($vendor_info['display_name']); ?></h2>
            <?php } ?>
            <div class="vendor-rating">
                <?php
                if (get_wcmp_vendor_settings('is_sellerreview', 'general') == 'Enable') {
                    $queried_object = get_queried_object();
                    if (isset($queried_object->term_id) && !empty($queried_object)) {
                        $rating_val_array = wcmp_get_vendor_review_info($queried_object->term_id);
                        $WCMp->template->get_template('review/rating.php', array('rating_val_array' => $rating_val_array));
                    }
                }
                ?>
            </div>
            <?php if ($vendor_hide_address != 'Enable') {
                if (!empty($location)) { ?>
                    <p class="vendor-address vendor-content"><i class="cs-font clever-icon-place-localizer"></i>
                        <span><?php echo apply_filters('vendor_shop_page_location', $location, $vendor_id); ?></span>
                    </p> <?php }
                if (!empty($address_1)) { ?>
                    <p class="vendor-address vendor-content"><i class="cs-font clever-icon-place-localizer"></i>
                        <span><?php echo esc_html($address_1); ?></span>
                    </p> <?php }
                if (!empty($address_2)) { ?>
                    <p class="vendor-address vendor-content"><i class="cs-font clever-icon-place-localizer"></i>
                        <span><?php echo esc_html($address_2); ?></span>
                    </p> <?php }
            } ?>
            <?php if (!empty($mobile) && $vendor_hide_phone != 'Enable') { ?>
                <p class="vendor-phone vendor-content"><i class="cs-font clever-icon-phone-6"></i>
                <span><?php echo apply_filters('vendor_shop_page_contact', $mobile, $vendor_id); ?></span></p><?php } ?>

            <?php if (!empty($email) && $vendor_hide_email != 'Enable') { ?><p class="vendor-email vendor-content"><a
                        href="mailto:<?php echo apply_filters('vendor_shop_page_email', $email, $vendor_id); ?>"
                        class="wcmp_vendor_detail"><i
                            class="cs-font  clever-icon-mail-3"></i><?php echo apply_filters('vendor_shop_page_email', $email, $vendor_id); ?>
                </a></p><?php } ?>
            <ul class="vendor-social">
                <?php if ($vendor_info['social']['fb']) { ?>
                    <li class="facebook"><a href="<?php echo esc_url($vendor_info['social']['fb']) ?>"
                                            title="<?php echo esc_html__('Facebook', 'fona') ?>">
                        <i class="cs-font clever-icon-facebook"></i></a></li><?php } ?>
                <?php if ($vendor_info['social']['tw']) { ?>
                    <li class="twitter"><a href="<?php echo esc_url($vendor_info['social']['tw']) ?>"
                                           title="<?php echo esc_html__('Twitter', 'fona') ?>">
                        <i class="cs-font clever-icon-twitter"></i></a></li><?php } ?>
                <?php if ($vendor_info['social']['gp']) { ?>
                    <li class="googleplus"><a href="<?php echo esc_url($vendor_info['social']['gp']) ?>"
                                              title="<?php echo esc_html__('Google plus', 'fona') ?>">
                        <i class="cs-font clever-icon-googleplus"></i></a></li><?php } ?>
                <?php if ($vendor_info['social']['ld']) { ?>
                    <li class="linkedln"><a href="<?php echo esc_url($vendor_info['social']['ld']) ?>"
                                            title="<?php echo esc_html__('pinterest', 'fona') ?>">
                        <i class="cs-font clever-icon-linkedin"></i></a></li><?php } ?>
                <?php if ($vendor_info['social']['yt']) { ?>
                    <li class="youtube"><a href="<?php echo esc_url($vendor_info['social']['yt']) ?>"
                                           title="<?php echo esc_html__('Youtube', 'fona') ?>">
                        <i class="cs-font clever-icon-youtube-1"></i></a></li><?php } ?>
                <?php if ($vendor_info['social']['it']) { ?>
                    <li class="instagram"><a href="<?php echo esc_url($vendor_info['social']['it']) ?>"
                                             title="<?php echo esc_html__('Instagram', 'fona') ?>">
                        <i class="cs-font clever-icon-instagram"></i></a></li><?php } ?>
            </ul>
            <?php
            $vendor_hide_description = apply_filters('wcmp_vendor_store_header_hide_description', get_user_meta($vendor_id, '_vendor_hide_description', true), $vendor->id);
            if (!$vendor_hide_description && $description != '') {
                ?>
                <div class="vendor-description">
                    <?php
                    echo stripslashes($description); ?>
                </div>
            <?php } ?>
        </div>
</div>
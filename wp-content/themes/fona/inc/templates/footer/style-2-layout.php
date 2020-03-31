<?php
/**
 * 2 columns Footer Layout
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
$zoo_main_footer = zoo_main_footer();
if ($zoo_main_footer) {
    if (is_active_sidebar('main-footer-1-2') || is_active_sidebar('main-footer-2-2') || is_active_sidebar('main-footer-3-2') || is_active_sidebar('main-footer-4-2')) { ?>
        <div id="main-footer" class="footer-block">
            <div class="container">
                <div class="wrap-main-footer row">
                    <div class="col-xs-12 col-sm-3 main-footer-block">
                        <?php dynamic_sidebar('main-footer-1-2'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-3 main-footer-block">
                        <?php dynamic_sidebar('main-footer-2-2'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-3 main-footer-block">
                        <?php dynamic_sidebar('main-footer-3-2'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-3 main-footer-block">
                        <?php dynamic_sidebar('main-footer-4-2'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}
$zoo_copyright_text = get_theme_mod('zoo_footer_copyright', 'Copyright © 2018 ZooTemplate. All rights reserved.');
if ($zoo_copyright_text != '' || is_active_sidebar('bottom-footer-2')) { ?>
    <div id="bottom-footer" class="footer-block">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 bottom-footer-block pull-right">
                    <?php dynamic_sidebar('bottom-footer-2'); ?>
                </div>
                <div id="copyright" class="col-xs-12 col-sm-6 pull-left">
                    <?php
                    echo wp_kses($zoo_copyright_text, array('a' => array('href' => array(), 'title' => array()), 'i' => array('class' => array()), 'br' => array('class' => array())));
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

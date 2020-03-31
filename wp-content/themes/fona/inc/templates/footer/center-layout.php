<?php
/**
 * Center Footer Layout
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
$zoo_copyright_text = get_theme_mod('zoo_footer_copyright', 'Copyright © 2018 ZooTemplate. All rights reserved.');
if ($zoo_copyright_text != '' || is_active_sidebar('bottom-footer')) { ?>
    <div id="bottom-footer" class="footer-block">
        <div class="container">
            <div class="row">
                <div id="copyright" class="col-xs-12">
                    <?php
                    echo wp_kses($zoo_copyright_text, array('a' => array('href' => array(), 'title' => array()), 'i' => array('class' => array()), 'br' => array('class' => array())));
                    ?>
                </div>
                <div class="col-xs-12 bottom-footer-block">
                    <?php dynamic_sidebar('bottom-footer'); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

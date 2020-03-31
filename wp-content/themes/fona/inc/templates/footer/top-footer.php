<?php
/**
 * Default Top Footer Layout
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */

if(is_active_sidebar('top-footer')){
?>
<div id="top-footer">
        <?php dynamic_sidebar('top-footer'); ?>
</div>
<?php }
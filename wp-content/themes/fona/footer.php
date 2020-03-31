<?php
/**
 * Default site footer
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */

$zoo_top_footer = zoo_top_footer();
$zoo_footer_layout = zoo_footer_layout();
$zoo_footer_class = 'wrap-' . $zoo_footer_layout . '-layout';
if ($zoo_top_footer) {
    $zoo_footer_class .= ' top-footer-active';
}
?>
<footer id="zoo-footer" class="<?php echo esc_attr($zoo_footer_class) ?>">
    <?php
    if ($zoo_top_footer) {
        get_template_part('/inc/templates/footer/top', 'footer');
    }
    get_template_part('/inc/templates/footer/' . $zoo_footer_layout, 'layout');
    ?>
</footer>
<?php
if (zoo_boxes()) : ?>
    </div>
<?php endif;

wp_footer();
?>
</body>
</html>
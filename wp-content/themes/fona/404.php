<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */

get_header(); ?>
<main id="main" class="site-main">
    <div class="container error-404 not-found">
            <header class="page-header">
                <h2 class="page-title"><?php esc_html_e( '404', 'fona' ); ?></h2>
            </header>
            <div class="error-404-content">
                <h3><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'fona' ); ?></h3>
                <a href="<?php echo esc_url(home_url('/'));?>" class="btn" title="<?php echo esc_attr__('Back to Home','fona');?>">
                    <?php echo esc_html__('Back to Home','fona');?>
                </a>
            </div>
    </div>
</main>
<?php get_footer(); ?>

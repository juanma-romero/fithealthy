<?php
/**
 * Theme functions
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
/**
 * Register features
 */
if (!function_exists('is_plugin_active')) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}
if (!function_exists('zoo_theme_setup')) :
    function zoo_theme_setup()
    {
        load_theme_textdomain('fona', get_template_directory() . '/languages');

        add_theme_support('title-tag');

        add_theme_support('post-thumbnails');

        add_theme_support('automatic-feed-links');

        add_theme_support('customize-selective-refresh-widgets');

        add_theme_support('post-formats', array('gallery', 'quote', 'video', 'audio'));

        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
        add_theme_support('custom-logo', array(
            'height' => 100,
            'width' => 400,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => array('site-title', 'site-description'),
        ));
        add_theme_support("custom-header");
        add_theme_support("custom-background");
        add_editor_style();
        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'fona'),
            'second' => esc_html__('Second Menu (For layout Menu Bottom)', 'fona'),
            'mobile' => esc_html__('Mobile Menu', 'fona'),
        ));
        if (!isset($GLOBALS['content_width'])) $GLOBALS['content_width'] = 640;
        add_theme_support('advanced-image-compression');
        if (class_exists('WooCommerce', false)) {
            add_theme_support('woocommerce');
        }
        add_theme_support('testimonial-post-type');
    }
endif;
add_action('after_setup_theme', 'zoo_theme_setup');

/**
 * Register Sidebar
 * */
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'fona'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here to appear in your sidebar.', 'fona'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Sidebar 2', 'fona'),
        'id' => 'sidebar-2',
        'description' => esc_html__('Add widgets here to appear in your sidebar 2.', 'fona'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Topbar Header', 'fona'),
        'id' => 'top-header',
        'description' => esc_html__('Add widgets here to appear in your top header.', 'fona'),
        'before_widget' => '<div id="%1$s" class="top-head-widget header-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Main header widget', 'fona'),
        'id' => 'main-header',
        'description' => esc_html__('Add widgets here to appear in left main header of layout Stack Center 2.', 'fona'),
        'before_widget' => '<div id="%1$s" class="main-header-widget header-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Top Footer', 'fona'),
        'id' => 'top-footer',
        'description' => esc_html__('Add widgets here to appear in your top footer.', 'fona'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Main Footer 1', 'fona'),
        'id' => 'main-footer-1',
        'description' => esc_html__('Add widgets here to appear in your main footer 1.', 'fona'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Main Footer 2', 'fona'),
        'id' => 'main-footer-2',
        'description' => esc_html__('Add widgets here to appear in your Main footer 2.', 'fona'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Main Footer 3', 'fona'),
        'id' => 'main-footer-3',
        'description' => esc_html__('Add widgets here to appear in your Main footer 3.', 'fona'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Main Footer 4', 'fona'),
        'id' => 'main-footer-4',
        'description' => esc_html__('Add widgets here to appear in your Main footer 4.', 'fona'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Bottom Footer', 'fona'),
        'id' => 'bottom-footer',
        'description' => esc_html__('Add widgets here to appear in your bottom footer.', 'fona'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Main Footer 1 #2', 'fona'),
        'id' => 'main-footer-1-2',
        'description' => esc_html__('Add widgets here to appear in your main footer 1 of footer style 2.', 'fona'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Main Footer 2 #2', 'fona'),
        'id' => 'main-footer-2-2',
        'description' => esc_html__('Add widgets here to appear in your Main footer 2 of footer style 2.', 'fona'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Main Footer 3 #2', 'fona'),
        'id' => 'main-footer-3-2',
        'description' => esc_html__('Add widgets here to appear in your Main footer 3 of footer style 2.', 'fona'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Main Footer 4 #2', 'fona'),
        'id' => 'main-footer-4-2',
        'description' => esc_html__('Add widgets here to appear in your Main footer 4 of footer style 2.', 'fona'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Bottom Footer 2', 'fona'),
        'id' => 'bottom-footer-2',
        'description' => esc_html__('Add widgets here to appear in your bottom footer style 2.', 'fona'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Canvas Sidebar', 'fona'),
        'id' => 'canvas-sidebar',
        'description' => esc_html__('Add widgets here to appear in canvas sidebar.', 'fona'),
        'before_widget' => '<div id="%1$s" class="canvas-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="cv-widget-title">',
        'after_title' => '</h4>',
    ));

    if (class_exists('WooCommerce', false)) {
        register_sidebar(array(
            'name' => esc_html__('Shop Sidebar', 'fona'),
            'id' => 'shop',
            'description' => esc_html__('Add widgets here to appear in your sidebar of shop page.', 'fona'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
    } else {
        unregister_sidebar('shop');
    }
}
/**
 * Enqueue scripts and styles for front end.
 *
 * @since 1.0
 */
function zoo_theme_styles()
{
    /**
     * Enqueue styles.
     *
     * @since 1.0
     */
    // Bootstrap
    wp_enqueue_style('bootstrap', ZOO_THEME_URI . 'assets/vendor/bootstrap/bootstrap.min.css');
    if (is_rtl()) {
        wp_enqueue_style('bootstrap-rtl', ZOO_THEME_URI . 'assets/vendor/bootstrap/bootstrap-rtl.min.css');
    }
    // FontAwesome
    if (get_theme_mod('zoo_enable_font_awesome', 'off') == 'on') {
        wp_enqueue_style('fontawesome', ZOO_THEME_URI . 'assets/vendor/font-awesome/css/font-awesome.min.css');
    }
    // Cleversoft font
    wp_enqueue_style('cleverfont', ZOO_THEME_URI . 'assets/vendor/cleverfont/style.css');
    wp_register_style('slick', ZOO_THEME_URI . 'assets/vendor/slick/slick.css');
    wp_enqueue_style('zoo-layout', ZOO_THEME_URI . 'assets/css/zoo-layout.css');
    if (class_exists('WooCommerce', false)) {
        wp_register_style('zoomove', ZOO_THEME_URI . 'assets/vendor/zoomove/zoomove.min.css');
        wp_deregister_style('woocommerce-layout');
        wp_deregister_style('woocommerce-smallscreen');
        //Remove style don't use.
        // wp_deregister_style('wpdreams-ajaxsearchlite');
        wp_deregister_style('woocommerce_prettyPhoto_css');
        wp_deregister_style('yith-wcwl-font-awesome');
        wp_deregister_style('jquery-selectBox');
        //Custom Woocommerce Css
        wp_enqueue_style('zoo-woocommerce', ZOO_THEME_URI . 'assets/css/zoo-woocommerce.css');
    }
    // Load style for child theme
    if (is_child_theme()) {
        wp_enqueue_style('zoo-theme-parent-style', ZOO_THEME_URI . 'style.css', array(), false, 'all');
        wp_enqueue_style('zoo-theme-parent-rtl', ZOO_THEME_URI . 'rtl.css', array(), false, 'all');
    }
    // Main style
    wp_enqueue_style('fona', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'zoo_theme_styles', 999);
/*Load theme Script*/
function zoo_theme_scripts()
{
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    wp_register_script('jquery', ZOO_THEME_URI . 'assets/vendor/jquery/jquery.min.js', array(), false, true);
    wp_enqueue_script('zoo-libs', ZOO_THEME_URI . 'assets/js/libs.js', array(), false, true);
    if (class_exists('WooCommerce', false)) {
        wp_enqueue_script('zoo-ajax-cart', ZOO_THEME_URI . 'assets/js/ajax-cart.min.js', array('jquery-core'), false, true);
        wp_register_script('zoo-product-embed', ZOO_THEME_URI . 'assets/js/product-embed.min.js', array('jquery-core'), false, true);
        wp_enqueue_script('zoo-woocommerce', ZOO_THEME_URI . 'assets/js/woocommerce.min.js', array('jquery-core'), false, true);
    }
    wp_register_script('fona', ZOO_THEME_URI . 'assets/js/theme.min.js', array('jquery-core'), false, true);
    wp_localize_script('fona', 'zooScriptSettings', array(
        'ABSPATH' => ABSPATH,
        'baseDir' => ZOO_THEME_DIR,
        'baseUri' => ZOO_THEME_URI,
    ));
    wp_enqueue_script('fona');
}

add_action('wp_enqueue_scripts', 'zoo_theme_scripts');
/*Admin css*/
function zoo_admin_style()
{
    wp_enqueue_style('custom_wp_admin_css', get_template_directory_uri() . '/assets/css/zoo-admin.css', false, '');
}

add_action('admin_enqueue_scripts', 'zoo_admin_style');
/**
 * Remove Script Version
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if (!function_exists('zoo_remove_script_version')) {
    function zoo_remove_script_version($src)
    {
        if (strpos($src, $_SERVER['SERVER_NAME']) != false) {
            $parts = explode('?', $src);
            return $parts[0];
        } else {
            return $src;
        }
    }
}
add_filter('script_loader_src', 'zoo_remove_script_version', 15, 1);
add_filter('style_loader_src', 'zoo_remove_script_version', 15, 1);
/**
 * Edit the except length characters.
 *
 */
if (!function_exists('zoo_custom_excerpt_length')) {
    function zoo_custom_excerpt_length()
    {
        return get_theme_mod('zoo_blog_excerpt_length', '60');
    }
}
add_filter('excerpt_length', 'zoo_custom_excerpt_length', 999);

//Include widget of theme
include get_template_directory() . '/inc/widgets/icon-field.php';
include get_template_directory() . '/inc/widgets/img-hover.php';
include get_template_directory() . '/inc/widgets/recent-post.php';
include get_template_directory() . '/inc/widgets/widget-social.php';
//Helper of theme for check conditional of customize and meta options
include get_template_directory() . '/inc/theme-functions/helper.php';


/**
 * Register the required plugins for this theme.
 */
add_action('tgmpa_register', 'zoo_theme_register_required_plugins');
if (!function_exists('zoo_theme_register_required_plugins')) {
    function zoo_theme_register_required_plugins()
    {
        $zoo_directory_plugins = get_template_directory() . '/inc/plugins/';
        $plugins = array(
            array(
                'name' => esc_html__('WPBakery Page Builder', 'fona'),
                'slug' => 'js_composer',
                'required' => true,
                'source' => $zoo_directory_plugins . 'js_composer.zip',
                'version' => '6.0.5'
            ),
            array(
                'name' => esc_html__('Slider Revolution', 'fona'),
                'slug' => 'revslider',
                'required' => true,
                'source' => $zoo_directory_plugins . 'revslider.zip',
                'version' => '6.1.3'
            ), array(
                'name' => esc_html__('Clever MegaMenu', 'fona'),
                'slug' => 'clever-mega-menu',
                'required' => false,
                'source' => $zoo_directory_plugins . 'clever-mega-menu.zip',
                'version' => '1.0.9'
            ),
            array(
                'name' => esc_html__('Contact Form 7', 'fona'),
                'slug' => 'contact-form-7',
                'required' => false,
            ),
            array(
                'name' => esc_html__('Clever Visual Composer Addon', 'fona'),
                'slug' => 'clever-vc-addon',
                'required' => true,
                'source' => $zoo_directory_plugins . 'clever-vc-addon.zip',
                'version' => '1.0.2'
            ),
            array(
                'name' => esc_html__('Zoo Framework', 'fona'),
                'slug' => 'zoo-framework',
                'required' => true,
                'source' => $zoo_directory_plugins . 'zoo-framework.zip',
                'version' => '1.0.0'
            ),
            array(
                'name' => esc_html__('Meta Box', 'fona'),
                'slug' => 'meta-box',
                'required' => true,
            ),
            array(
                'name' => esc_html__('WooCommerce', 'fona'),
                'slug' => 'woocommerce',
                'required' => true,
            ),
            array(
                'name' => esc_html__('Clever Swatches', 'fona'),
                'slug' => 'clever-swatches',
                'required' => false,
                'source' => $zoo_directory_plugins . 'clever-swatches.zip',
                'version' => '2.1.7'
            ),
            array(
                'name' => esc_html__('Clever Layered Navigation', 'fona'),
                'slug' => 'clever-layered-navigation',
                'required' => false,
                'source' => $zoo_directory_plugins . 'clever-layered-navigation.zip',
                'version' => '1.3.3'
            ),
            array(
                'name' => esc_html__('Currency Switcher for WooCommerce', 'fona'),
                'slug' => 'currency-switcher-woocommerce',
                'required' => false,
            ), array(
                'name' => esc_html__('WC Marketplace', 'fona'),
                'slug' => 'dc-woocommerce-multi-vendor',
                'required' => false,
            ), array(
                'name' => esc_html__('WP User Avatar', 'fona'),
                'slug' => 'wp-user-avatar',
                'required' => false,
            ), array(
                'name' => esc_html__('Ajax Search Lite', 'fona'),
                'slug' => 'ajax-search-lite',
                'required' => false,
            ),
            array(
                'name' => esc_html__('Newsletter', 'fona'),
                'slug' => 'newsletter',
                'required' => false,
            ),
            array(
                'name' => esc_html__('YITH WooCommerce Wishlist', 'fona'),
                'slug' => 'yith-woocommerce-wishlist',
                'required' => false,
            ), array(
                'name' => esc_html__('YITH WooCommerce Social Login', 'fona'),
                'slug' => 'yith-woocommerce-social-login',
                'required' => false,
            ),
            array(
                'name' => esc_html__('Better AMP', 'fona'),
                'slug' => 'better-amp',
                'required' => false,
            ),
            array(
                'name' => esc_html__('GDPR', 'fona'),
                'slug' => 'gdpr',
                'required' => false,
            ),
        );
        $config = array(
            'id' => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to pre-packaged plugins.
            'menu' => 'tgmpa-install-plugins', // Menu slug.
            'parent_slug' => 'themes.php',            // Parent menu slug.
            'capability' => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices' => true,                    // Show admin notices or not.
            'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message' => '',                      // Message to output right before the plugins table.
            'strings' => array(
                'page_title' => esc_html(__('Install Required Plugins', 'fona')),
                'menu_title' => esc_html(__('Install Plugins', 'fona')),
                'installing' => esc_html(__('Installing Plugin: %s', 'fona')), // %s = plugin name.
                'oops' => esc_html(__('Something went wrong with the plugin API.', 'fona')),
                'notice_can_install_required' => _n_noop(
                    'This theme requires the following plugin: %1$s.',
                    'This theme requires the following plugins: %1$s.',
                    'fona'
                ), // %1$s = plugin name(s).
                'notice_can_install_recommended' => _n_noop(
                    'This theme recommends the following plugin: %1$s.',
                    'This theme recommends the following plugins: %1$s.',
                    'fona'
                ), // %1$s = plugin name(s).
                'notice_cannot_install' => _n_noop(
                    'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
                    'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
                    'fona'
                ), // %1$s = plugin name(s).
                'notice_ask_to_update' => _n_noop(
                    'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                    'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                    'fona'
                ), // %1$s = plugin name(s).
                'notice_ask_to_update_maybe' => _n_noop(
                    'There is an update available for: %1$s.',
                    'There are updates available for the following plugins: %1$s.',
                    'fona'
                ), // %1$s = plugin name(s).
                'notice_cannot_update' => _n_noop(
                    'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
                    'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
                    'fona'
                ), // %1$s = plugin name(s).
                'notice_can_activate_required' => _n_noop(
                    'The following required plugin is currently inactive: %1$s.',
                    'The following required plugins are currently inactive: %1$s.',
                    'fona'
                ), // %1$s = plugin name(s).
                'notice_can_activate_recommended' => _n_noop(
                    'The following recommended plugin is currently inactive: %1$s.',
                    'The following recommended plugins are currently inactive: %1$s.',
                    'fona'
                ), // %1$s = plugin name(s).
                'notice_cannot_activate' => _n_noop(
                    'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
                    'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
                    'fona'
                ), // %1$s = plugin name(s).
                'install_link' => _n_noop(
                    'Begin installing plugin',
                    'Begin installing plugins',
                    'fona'
                ),
                'update_link' => _n_noop(
                    'Begin updating plugin',
                    'Begin updating plugins',
                    'fona'
                ),
                'activate_link' => _n_noop(
                    'Begin activating plugin',
                    'Begin activating plugins',
                    'fona'
                ),
                'return' => esc_html(__('Return to Required Plugins Installer', 'fona')),
                'plugin_activated' => esc_html(__('Plugin activated successfully.', 'fona')),
                'activated_successfully' => esc_html(__('The following plugin was activated successfully:', 'fona')),
                'plugin_already_active' => esc_html(__('No action taken. Plugin %1$s was already active.', 'fona')),  // %1$s = plugin name(s).
                'plugin_needs_higher_version' => esc_html(__('Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'fona')),  // %1$s = plugin name(s).
                'complete' => esc_html(__('All plugins installed and activated successfully. %1$s', 'fona')), // %s = dashboard link.
                'contact_admin' => esc_html(__('Please contact the administrator of this site for help.', 'fona')),
                'nag_type' => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
            )
        );

        tgmpa($plugins, $config);

    }
}

/**
 * Custom functions of theme.
 */
/* COMMENTS */
if (!function_exists('zoo_custom_comments')) {
    function zoo_custom_comments($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        $GLOBALS['comment_depth'] = $depth;
        ?>
        <li id="comment-<?php comment_ID() ?>" <?php comment_class('clearfix') ?>>
        <div class="comment-wrap clearfix">
            <div class="comment-avatar">
                <?php if (function_exists('get_avatar')) {
                    echo wp_kses(get_avatar($comment, '55'), array('img' => array('class' => array(), 'width' => array(), 'height' => array(), 'alt' => array(), 'src' => array())));
                } ?>
            </div>
            <div class="comment-content">
                <div class="comment-meta">
                    <?php
                    printf('<h5 class="author-name">%1$s</h5>',
                        get_comment_author_link()
                    );
                    echo '<span class="date-post">' . esc_html(get_comment_date('', get_comment_ID())) . '</span>';
                    ?>
                </div>
                <?php if ($comment->comment_approved == '0') wp_kses(__("\t\t\t\t\t<span class='unapproved'>" . esc_html__('Your comment is awaiting moderation.', 'fona') . "</span>\n", 'fona'), array('span' => array('class' => array()))); ?>
                <div class="comment-body">
                    <?php comment_text() ?>
                </div>
                <div class="comment-meta-actions">
                    <?php
                    edit_comment_link(esc_html(__('Edit', 'fona')), '<span class="edit-link">', '</span>');
                    ?>
                    <?php if ($args['type'] == 'all' || get_comment_type() == 'comment') :
                        comment_reply_link(array_merge($args, array(
                            'reply_text' => esc_html(__('Reply', 'fona')),
                            'login_text' => esc_html(__('Log in to reply.', 'fona')),
                            'depth' => $depth,
                            'before' => '<span class="comment-reply">',
                            'after' => '</span>'
                        )));
                    endif; ?>
                </div>
            </div>
        </div>
    <?php }
}
if (!function_exists('zoo_custom_pings')) {
    function zoo_custom_pings($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        $GLOBALS['comment_depth'] = $depth;
        ?>
    <li id="comment-<?php comment_ID() ?>" <?php comment_class('clearfix') ?>>
        <div class="comment-wrap clearfix">
            <div class="comment-content">
                <div class="comment-meta">
                    <?php
                    printf('<h6 class="author-name">%1$s</h6>',
                        get_comment_author_link()
                    );
                    ?>
                </div>
                <?php if ($comment->comment_approved == '0') wp_kses(__("\t\t\t\t\t<span class='unapproved'>" . esc_html__('Your comment is awaiting moderation.', 'fona') . "</span>\n", 'fona'), array('span' => array('class' => array()))); ?>
                <div class="comment-meta-actions">
                    <?php
                    edit_comment_link(esc_html(__('Edit', 'fona')), '<span class="edit-link">', '</span>');
                    ?>
                    <?php if ($args['type'] == 'all' || get_comment_type() == 'comment') :
                        comment_reply_link(array_merge($args, array(
                            'reply_text' => esc_html(__('Reply', 'fona')),
                            'login_text' => esc_html(__('Log in to reply.', 'fona')),
                            'depth' => $depth,
                            'before' => '<span class="comment-reply">',
                            'after' => '</span>'
                        )));
                    endif; ?>
                </div>
            </div>
        </div>
    <?php }
}
if (!function_exists('zoo_custom_search_form')) {
    function zoo_custom_search_form($form)
    {
        $form = '<form role="search" method="get" id="searchform" class="custom-search-form" action="' . home_url('/') . '" >
                <input type="text" placeholder="' . esc_attr__('Search…', 'fona') . '"  class="search-field" value="' . get_search_query() . '" name="s" id="s" />
                <button type="submit" id="searchsubmit" value="' . esc_attr__('Search', 'fona') . '"><i class="cs-font clever-icon-search-5"></i> </button>
                </form>';

        return $form;
    }
}
add_filter('get_search_form', 'zoo_custom_search_form');


if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
    add_filter('wpcf7_load_js', '__return_false');
    add_filter('wpcf7_load_css', '__return_false');
    if (!function_exists('zoo_cf7_shortcode_scripts')) {
        function zoo_cf7_shortcode_scripts()
        {
            global $post;
            if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'contact-form-7')) {
                if (function_exists('wpcf7_enqueue_scripts')) {
                    wpcf7_enqueue_scripts();
                }
                if (function_exists('wpcf7_enqueue_styles')) {
                    wpcf7_enqueue_styles();
                }
            }
        }
    }
    add_action('wp_enqueue_scripts', 'zoo_cf7_shortcode_scripts');
}
add_filter('body_class', 'zoo_body_custom_class');
if (!function_exists('zoo_body_custom_class')) {
    function zoo_body_custom_class($classes)
    {
        if (zoo_boxes()) {
            $classes[] = 'boxes-page';
        }
        return $classes;
    }
}
update_option('yith_wcwl_rounded_corners', 'no');
//Custom vc row
add_action('vc_after_init_base', 'zoo_add_more_custom_layouts');
function zoo_add_more_custom_layouts()
{
    global $vc_row_layouts;
    array_push($vc_row_layouts, array(
            'cells' => '16_712_14',
            'mask' => '331',
            'title' => 'Custom 1/6 + 7/12 + 1/4',
            'icon_class' => 'l_16_712_14')
    );
    array_push($vc_row_layouts, array(
            'cells' => '16_13_12',
            'mask' => '311',
            'title' => 'Custom 1/6 + 1/3 + 1/2',
            'icon_class' => 'l_16_13_12')
    );
    array_push($vc_row_layouts, array(
            'cells' => '16_13_13_16',
            'mask' => '418',
            'title' => 'Custom 1/6 + 1/3 + 1/3 + 1/6',
            'icon_class' => 'l_16_13_13_16')
    );
}

//Meta function
if (!function_exists('zoo_meta')) {
    function zoo_meta()
    {
        global $wp;
        $zoo_url = home_url($wp->request);
        $zoo_meta = '';
        $zoo_img = get_theme_mod('zoo_site_featured_imaged', '');
        $zoo_img = $zoo_img != '' ? $zoo_img : get_theme_mod('custom_logo');
        $zoo_img = wp_get_attachment_url($zoo_img);
        $zoo_title = get_bloginfo('name');
        $zoo_des = get_bloginfo('description');
        if (!is_front_page()) {
            if (is_page() || is_single()) {
                $zoo_title = get_the_title();
                $zoo_des = apply_filters('the_excerpt', get_post_field('post_excerpt', get_the_ID()));;
                if (has_post_thumbnail()) {
                    $zoo_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
                }
            }
            if (is_archive()) {
                $zoo_title = get_the_archive_title();
                $zoo_des = get_the_archive_description();
            }
            if (class_exists('WooCommerce')) {
                if (is_shop()) {
                    if (get_theme_mod('zoo_shop_cover_img_bg', '') != '') {
                        $zoo_img = get_theme_mod('zoo_shop_cover_img_bg', '');
                    }
                    if (get_theme_mod('zoo_shop_cover_text', '') != '') {
                        $zoo_title = get_theme_mod('zoo_shop_cover_text', '');
                    }
                }
                if (is_product_category()) {
                    global $wp_query;
                    $cat = $wp_query->get_queried_object();
                    if ($cat->description != '') {
                        $zoo_des = $cat->description;
                    }
                    $thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
                    if ($thumbnail_id) {
                        $zoo_img = wp_get_attachment_url($thumbnail_id);
                    }
                }
            }
        }
        $zoo_meta .= '<meta property="og:title" content="' . wp_strip_all_tags($zoo_title) . '">
    <meta property="og:description" content="' . esc_attr(strip_tags($zoo_des)) . '">
    <meta property="og:image" content="' . esc_url($zoo_img) . '">
    <meta property="og:url" content="' . esc_url($zoo_url) . '">';
        echo $zoo_meta;
    }
}
//add_action('wp_head', 'zoo_meta');
if (!function_exists('zoo_check_better_amp')) {
    function zoo_check_better_amp()
    {
        $is_better_amp = false;
        if (function_exists('is_better_amp')) {
            $is_better_amp = is_better_amp();
        }
        return $is_better_amp;
    }
}

if (!function_exists("zoo_redirect_amp_link")) {
    function zoo_redirect_amp_link()
    {
        if (is_cart()) {
            header('Location: ' . str_replace('amp/', '', wc_get_cart_url()));
            exit();
        }
        if (is_checkout()) {
            header('Location: ' . str_replace('amp/', '', wc_get_checkout_url()));
            exit();
        }
    }
}
if (zoo_check_better_amp()) {
    add_action('woocommerce_before_cart_contents', 'zoo_redirect_amp_link', 10);
}
function zoo_gdpr_consent()
{
    if (class_exists('GDPR')) {
        return GDPR::get_consent_checkboxes();
    } else {
        return false;
    }
}

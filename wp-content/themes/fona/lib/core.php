<?php
/**
 * Theme core functions and definitions
 *
 * @package    Zoo_Theme\Lib
 */

/**
 * Pre-activation
 *
 * Check for minimum compatibility
 */
if (!function_exists('zoo_theme_pre_activate'))
{
    function zoo_theme_pre_activate()
    {
        $wp_compare = version_compare( $GLOBALS['wp_version'], '4.5' );
        $php_compare = version_compare( phpversion(), '5.4' );

        if ($wp_compare < 0) {
            throw new Exception( sprintf('Whoops, Zoo Theme requires %1$s version %2$s at least. Please delete this theme and upgrade %1$s to latest version for better perfomance and security.', 'WordPress', '4.5') );
        }

        if ($php_compare < 0) {
            throw new Exception( sprintf('Whoops, Zoo Theme requires %1$s version %2$s at least. Please delete this theme and upgrade %1$s to latest version for better perfomance and security.', 'PHP', '5.4') );
        }
    }
}

/**
 * Do activation
 */
if (!function_exists('zoo_theme_activate'))
{
    function zoo_theme_activate()
    {
        try {
            zoo_theme_pre_activate();
        } catch (Exception $e) {
            wp_die($e->getMessage());
        }

        add_option('zoo_theme_settings', apply_filters('zoo_theme_core_settings', array(
            'header_scripts'         => '',
            'footer_scripts'         => '',
            'google_map_api'         => '',
            'import_settings'        => '',
            'enable_adaptive_images' => '0',
            'adaptive_image_sizes'   => '258,516,720,1032,1440,2064,2880',
        )));

        if (!is_child_theme()) {
            set_transient('theme_setup_wizard_redirect', '1');
        }
    }
    add_action('after_switch_theme', 'zoo_theme_activate', 10, 0);
}

/**
 * Register and enqueue admin assets
 */
if (!function_exists('zoo_theme_load_admin_assets'))
{
    function zoo_theme_load_admin_assets($hook_suffix)
    {
        $assets_uri = ZOO_THEME_URI . 'lib/assets/';

        if (isset($_GET['page']) && 'zoo-theme-settings' === $_GET['page']) {
            echo '<style>#wpcontent{padding-left:0 !important}</style>';
        }

        // Register stylesheets.
        wp_register_style( 'zoo-theme-admin', $assets_uri . 'css/admin.min.css', array('dashicons'), ZOO_THEME_VERSION );
        wp_register_style( 'zoo-theme-customize', $assets_uri . 'css/customize.min.css', array('dashicons'), ZOO_THEME_VERSION );

        // Register scripts.
        wp_register_script( 'zoo-theme-admin', $assets_uri . 'js/admin.min.js', array('jquery-core'), ZOO_THEME_VERSION, true);
        wp_register_script( 'zoo-theme-customize',  $assets_uri . 'js/customize.min.js', array('customize-preview'), ZOO_THEME_VERSION, true );

        // Localize scripts
        wp_localize_script( 'zoo-theme-customize', 'ZooCustomizeSettings', array(
            'url'	  => admin_url( 'customize.php' ),
            'confirmReset' => esc_html__( "Attention! This will reset all customizations ever made via customizer to this theme!\n\nThis action is irreversible!", 'fona' ),
            'confirmImport' => esc_html__( "Attention! This will override all customizations ever made via customizer to this theme!\n\nThis action is irreversible!", 'fona' ),
            'nonce'   => wp_create_nonce( 'cust0miz3r-n0nc3' ),
        ) );

        // Enqueue media assets.
        wp_enqueue_media();

        // Enqueue stylesheets.
        wp_enqueue_style('thickbox');
        wp_enqueue_style( 'zoo-theme-admin' );

        // Enqueue scripts.
        wp_enqueue_script('thickbox');
        wp_enqueue_script( 'zoo-theme-admin' );

        // Enqueue customize assets.
        if ( is_customize_preview() ) {
            wp_enqueue_style( 'zoo-theme-customize' );
            wp_enqueue_script( 'zoo-theme-customize' );
        }
    }
    add_action( 'admin_enqueue_scripts', 'zoo_theme_load_admin_assets' );
}

/**
 * Maybe add header scripts
 */
if (!function_exists('zoo_maybe_add_header_scripts')) {
    function zoo_maybe_add_header_scripts()
    {
        $settings = get_option('zoo_theme_settings');
        $settings['adaptive_image_sizes'] = !empty($settings['adaptive_image_sizes']) ? $settings['adaptive_image_sizes'] : '258,516,720,1032,1440,2064,2880';
        $url_home = parse_url(home_url());
        $url_home = !empty($url_home['path']) ? '/' . trim($url_home['path'], '/') . '/' : '/';

        if (!empty($settings['enable_adaptive_images'])) {
            echo '<script type="text/javascript" src="'.ZOO_THEME_URI.'assets/js/ais.min.js" id="ais-script" data-home="'.$url_home.'" data-image-breakpoints="'.$settings['adaptive_image_sizes'].'" data-async="true"></script>';
        }

        if (!empty($settings['header_scripts'])) {
            if ((false !== strpos($settings['header_scripts'], '<script')) && (false !== strpos($settings['header_scripts'], '</script>'))) {
                echo ent2ncr($settings['header_scripts']);
            } else {
                echo '<script type="text/javascript">' . $settings['header_scripts'] . '</script>';
            }
        }
    }
    add_action('wp_head', 'zoo_maybe_add_header_scripts', PHP_INT_MAX, 0);
}

/**
 * Maybe add header scripts
 */
if (!function_exists('zoo_maybe_add_footer_scripts')) {
    function zoo_maybe_add_footer_scripts()
    {
        $settings = get_option('zoo_theme_settings');

        if (!empty($settings['footer_scripts'])) {
            if ((false !== strpos($settings['footer_scripts'], '<script')) && (false !== strpos($settings['footer_scripts'], '</script>'))) {
                echo ent2ncr($settings['footer_scripts']);
            } else {
                echo '<script type="text/javascript">' . $settings['footer_scripts'] . '</script>';
            }
        }
    }
    add_action('wp_footer', 'zoo_maybe_add_footer_scripts', PHP_INT_MAX, 0);
}

/**
 * Register theme customize options
 */
if (!function_exists('zoo_register_customize_options'))
{
    function zoo_register_customize_options(ZooCustomizeManager $zoo_customize, array $theme_mods)
    {
        $transport = 'refresh';

        require ZOO_THEME_DIR . 'lib/options/general.php';
        require ZOO_THEME_DIR . 'lib/options/header.php';
        require ZOO_THEME_DIR . 'lib/options/footer.php';
        require ZOO_THEME_DIR . 'lib/options/style.php';
        require ZOO_THEME_DIR . 'lib/options/blog.php';
        require ZOO_THEME_DIR . 'lib/options/shop.php';
        require ZOO_THEME_DIR . 'lib/options/custom-js.php';
    }
    add_action('zoo_before_customize_register', 'zoo_register_customize_options', 10, 3);
}

/**
 * Do deactivation
 */
if (!function_exists('zoo_theme_deactivate'))
{
    function zoo_theme_deactivate()
    {
        flush_rewrite_rules(false);
    }
    add_action('switch_theme', 'zoo_theme_deactivate', 10, 0);
}

/**
 * Load common resources
 */
require ZOO_THEME_DIR . 'lib/helpers/admin.php';
require ZOO_THEME_DIR . 'lib/helpers/general.php';
require ZOO_THEME_DIR . 'lib/vendor/tgmpa/tgmpa.php';
require ZOO_THEME_DIR . 'lib/vendor/kirki/kirki.php';
require ZOO_THEME_DIR . 'lib/functions/media.php';
require ZOO_THEME_DIR . 'lib/functions/assets.php';
require ZOO_THEME_DIR . 'lib/functions/pagination.php';
require ZOO_THEME_DIR . 'lib/functions/breadcrumb.php';
require ZOO_THEME_DIR . 'lib/classes/class-zoo-wxr-parser.php';
require ZOO_THEME_DIR . 'lib/classes/class-zoo-breadcrumbs.php';
require ZOO_THEME_DIR . 'lib/classes/class-zoo-demo-importer.php';
require ZOO_THEME_DIR . 'lib/classes/class-zoo-customize-setting.php';
require ZOO_THEME_DIR . 'lib/classes/class-zoo-customize-manager.php';
require ZOO_THEME_DIR . 'lib/classes/class-zoo-customize-import-export-control.php';

/**
 * Load admin resources
 */
if (is_admin()) {
    require ZOO_THEME_DIR . 'lib/classes/class-zoo-theme-welcome-page.php';
    require ZOO_THEME_DIR . 'lib/classes/class-zoo-theme-settings-page.php';
    require ZOO_THEME_DIR . 'lib/classes/class-zoo-theme-setup-wizard.php';
}
/**
 ** Load all js at bottom page
 */
if(!function_exists('zoo_remove_head_scripts')) {
    function zoo_remove_head_scripts()
    {
        remove_action('wp_head', 'wp_enqueue_scripts', 1);
        add_action('wp_footer', 'wp_enqueue_scripts', 5);
    }
}
add_action( 'wp_enqueue_scripts', 'zoo_remove_head_scripts' );
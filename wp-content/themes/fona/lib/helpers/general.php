<?php
/**
 * General helpers
 *
 * @package    Zoo_Theme\Core\Helpers
 */

/**
 * Get sidebar options
 */
if (!function_exists('zoo_get_sidebar_options')) {
    function zoo_get_sidebar_options()
     {
         global $wp_registered_sidebars;

         $sidebar_options = array();
         $sidebar_options['none'] = esc_html__('None','fona');

         foreach ($wp_registered_sidebars as $sidebar) {
             $sidebar_options[$sidebar['id']] = $sidebar['name'];
         }

         return $sidebar_options;
     }
 }

/**
 * zoo_custom_excerpt_length
 */
if (!function_exists('zoo_custom_excerpt_length')) {
    function zoo_custom_excerpt_length()
    {
        return get_theme_mod('zoo_blog_excerpt_length', '60');
    }
}

/**
 * Get content of php file
 *
 * @since zoo theme 1.0
 *
 * @return string.
 */
if (!function_exists('zoo_get_file_content')) :
    function zoo_get_file_content($zoo_part)
    {
        if (!function_exists('WP_Filesystem')) {
            require ABSPATH . 'wp-admin/includes/file.php';
        }
        WP_Filesystem();
        global $wp_filesystem;
        return $wp_filesystem->get_contents(ZOO_THEME_DIR . $zoo_part);
    }
endif;
/**
 * Convert Hex color and opacity to Rgba
 *
 * @since zoo theme 1.0
 *
 * @return string.
 */
if (!function_exists('zoo_hex2rgba')) {
    function zoo_hex2rgba($hex, $opacity = 1)
    {
        $hex = str_replace("#", "", $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgba = 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $opacity . ')';
        return $rgba;
    }
}

/**
 * Convert px to rem
 *
 * @since zoo theme 1.0
 *
 * @return int.
 */
if (!function_exists('zoo_px2rem')) {
    function zoo_px2rem($var)
    {
        $body_font = get_theme_mod('zoo_typo_body_font');
        $base = apply_filters( 'zoo_body_font_size', 14 );
        if (isset($body_font['font-size'])) {
            $base = (int)str_replace(' ', 'px', $body_font['font-size']);
        }
        $var = $var / $base;
        return $var . 'rem';
    }
}

/**
 * Generate font size for customize
 *
 * @since zoo theme 1.0
 *
 * @return string.
 */
if (!function_exists('zoo_generate_color')) {
    function zoo_generate_color($class, $var)
    {
        if ($var != '') {
            $color = $class . '{';
            $color .= "color: " . $var . ";}";
            return $color;
        } else
            return '';
    }
}

<?php
//header layout
if (!function_exists('zoo_header_layout')) {
    function zoo_header_layout()
    {
        $zoo_header_layout = get_theme_mod('zoo_header_layout', 'menu-center');
        if (is_page() || is_single()) {
            if (get_post_meta(get_the_ID(), 'zoo_header_layout', true) != '' && get_post_meta(get_the_ID(), 'zoo_header_layout', true) != 'inherit') {
                $zoo_header_layout = get_post_meta(get_the_ID(), 'zoo_header_layout', true);
            }
        }
        return $zoo_header_layout;
    }
}
//Header stick
if (!function_exists('zoo_header_stick')) {
    function zoo_header_stick()
    {
        $zoo_sticky = '';
        if (get_theme_mod('zoo_header_sticky', '1') == 1) {
            $zoo_sticky = 'sticker';
        }
        if (is_page() || is_single()) {
            if (get_post_meta(get_the_ID(), 'zoo_header_sticky', true) == '1') {
                $zoo_sticky = 'sticker';
            }
        }
        return $zoo_sticky;
    }
}
//Header transparent
if (!function_exists('zoo_header_transparent')) {
    function zoo_header_transparent()
    {
        $zoo_header_transparent = '';
        if (get_theme_mod('zoo_enable_header_transparent', '')) {
            $zoo_header_transparent = 'header-transparent';
        }
        if (is_page() || is_single()) {
            if (get_post_meta(get_the_ID(), 'zoo_enable_header_transparent', true) == '1') {
                $zoo_header_transparent = 'header-transparent';
            }
        }
        return $zoo_header_transparent;
    }
}
//Header fullwidth
if (!function_exists('zoo_header_fullwidth')) {
    function zoo_header_fullwidth()
    {
        $zoo_header_fullwidth = '';
        if (get_theme_mod('zoo_enable_header_fullwidth', '0')) {
            $zoo_header_fullwidth = 'full-width';
        }
        if (is_page() || is_single()) {
            if (get_post_meta(get_the_ID(), 'zoo_enable_header_fullwidth', true) == '1') {
                $zoo_header_fullwidth = 'full-width';
            }
        }
        return $zoo_header_fullwidth;
    }
}
//Header fullwidth
if (!function_exists('zoo_enable_header_top')) {
    function zoo_enable_header_top()
    {
        if (get_theme_mod('zoo_enable_top_header', '1')) {
            $zoo_header_top = true;
        } else {
            $zoo_header_top = false;
        }
        if (is_page() || is_single()) {
            if (get_post_meta(get_the_ID(), 'zoo_disable_top_header', true) == '1') {
                $zoo_header_top = false;
            }
        }
        return $zoo_header_top;
    }
}
//Body full width
if (!function_exists('zoo_full_width')) {
    function zoo_full_width()
    {
        $zoo_fullwidth = get_theme_mod('zoo_enable_page_full_width') == 1 ? true : false;
        if (is_page() || is_single()) {
            $zoo_page_layout = get_post_meta(get_the_ID(), 'zoo_page_layout', true);
            if ($zoo_page_layout == 'full-width') {
                $zoo_fullwidth = true;
            } else if ($zoo_page_layout == 'boxed') {
                $zoo_fullwidth = false;
            }
        }
        return $zoo_fullwidth;
    }
}
//Body full width
if (!function_exists('zoo_site_width')) {
    function zoo_site_width()
    {
        $zoo_site_width = get_theme_mod('zoo_site_width', '1200');
        if (is_page() && get_post_meta(get_the_ID(), 'zoo_site_width', true) != '') {
            $zoo_site_width = get_post_meta(get_the_ID(), 'zoo_site_width', true);
        }
        if (isset($_GET['zoo_site_width'])) {
            $zoo_site_width = $_GET['zoo_site_width'];
        }
        if($zoo_site_width==0||$zoo_site_width==''){
            $zoo_site_width='100%;padding-left:40px;padding-right:40px';
        }else{
            $zoo_site_width=$zoo_site_width.'px';
        }
        return $zoo_site_width;
    }
}
//Boxed layout
if (!function_exists('zoo_boxes')) {
    function zoo_boxes()
    {
        $zoo_boxed = get_theme_mod('zoo_site_layout', '') == 'boxed' ? true : false;
        if (is_page() || is_single()) {
            $zoo_page_layout = get_post_meta(get_the_ID(), 'zoo_page_layout', true);
            if ($zoo_page_layout == 'full-width') {
                $zoo_boxed = false;
            } else if ($zoo_page_layout == 'boxes') {
                $zoo_boxed = true;
            }
        }
        return $zoo_boxed;
    }
}
//End functions control header layout
//header layout
if (!function_exists('zoo_footer_layout')) {
    function zoo_footer_layout()
    {
        $zoo_footer_layout = 'default';
        if (get_theme_mod('zoo_footer_layout', 'default') != '') {
            $zoo_footer_layout = get_theme_mod('zoo_footer_layout', 'default');
        }
        if (is_page() || is_single()) {
            if (get_post_meta(get_the_ID(), 'zoo_footer_layout', true) != '' && get_post_meta(get_the_ID(), 'zoo_footer_layout', true) != 'inherit') {
                $zoo_footer_layout = get_post_meta(get_the_ID(), 'zoo_footer_layout', true);
            }
        }
        return $zoo_footer_layout;
    }
}
//Function control Footer
if (!function_exists('zoo_top_footer')) {
    function zoo_top_footer()
    {
        $zoo_top_footer = false;
        if (get_theme_mod('zoo_top_footer', '1') == 1) {
            $zoo_top_footer = true;
        }
        if (is_page() || is_single()) {
            if (get_post_meta(get_the_ID(), 'zoo_top_footer', true) == '1') {
                $zoo_top_footer = false;
            }
        }
        return $zoo_top_footer;
    }
}
//End Function control Footer
if (!function_exists('zoo_main_footer')) {
    function zoo_main_footer()
    {
        $zoo_main_footer = false;
        if (get_theme_mod('zoo_main_footer', '1') == '1') {
            $zoo_main_footer = true;
        }
        if (is_page() || is_single()) {
            if (get_post_meta(get_the_ID(), 'zoo_disable_main_footer', true) == '1') {
                $zoo_main_footer = false;
            }
        }
        return $zoo_main_footer;
    }
}
// Check sidebar layout use on post/archive/category
if (!function_exists('zoo_get_sidebar')) {
    function zoo_get_sidebar($sidebar = 'left')
    {
        $sidebar_option = is_single() ? get_post_meta(get_the_ID(), 'zoo_sidebar_options', true) : '';
        if ($sidebar_option == 'no-sidebar') {
            $sidebar_config = 'none';
        } else {
            if ($sidebar == 'left') {
                $sidebar = 'zoo_blog_sidebar_left';
                $sidebar_config = get_theme_mod($sidebar) != '' ? get_theme_mod($sidebar) : 'none';
                if ($sidebar_option == 'left-sidebar') {
                    $sidebar_config = get_post_meta(get_the_ID(), 'zoo_left_sidebar', true);
                } elseif ($sidebar_option == 'right-sidebar') {
                    $sidebar_config = 'none';
                }
            } else {
                $sidebar = 'zoo_blog_sidebar_right';
                $sidebar_config = get_theme_mod($sidebar, 'sidebar-1') != '' ? get_theme_mod($sidebar, 'sidebar-1') : 'none';
                if ($sidebar_option == 'right-sidebar') {
                    $sidebar_config = get_post_meta(get_the_ID(), 'zoo_right_sidebar', true);
                } elseif ($sidebar_option == 'left-sidebar') {
                    $sidebar_config = 'none';
                }
            }
        }
        return $sidebar_config;
    }
}
//Edit password form
if (!function_exists('zoo_password_form')) {
    function zoo_password_form()
    {
        global $post;
        $zoo_id = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
        $zoo_form = '<div class="zoo-form-login"><form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post"><h4>
    ' . esc_html__('To view this protected post, enter the password below:', 'fona') . '</h4>
    <input name="post_password" id="' . $zoo_id . '" type="password" size="20" maxlength="20" placeholder="' . esc_attr__('Enter Password', 'fona') . ' " /><br><input type="submit" name="Submit" value="' . esc_attr__('Submit', 'fona') . '" />
    </form></div>
    ';
        return $zoo_form;
    }
}
add_filter('the_password_form', 'zoo_password_form');
//Convert to rgba
if (!function_exists('zoo_hex2rgba')) {
    /* Convert hexdec color string to rgb(a) string */
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
        return $rgba; // returns an array with the rgb values
    }
}
//Preset color
if(!function_exists('zoo_preset')){
    function zoo_preset(){
        $zoo_preset = get_theme_mod('zoo_color_accent', '');
        if (is_page() && get_post_meta(get_the_ID(), 'zoo_accent_color', true) != '') {
            $zoo_preset = get_post_meta(get_the_ID(), 'zoo_accent_color', true);
        }
        if (isset($_GET['zoo_preset'])) {
            $zoo_preset = '#'.$_GET['zoo_preset'];
            $_SESSION["zoo_preset"]=$zoo_preset;
        }elseif(isset($_SESSION["zoo_preset"])){
            $zoo_preset = $_SESSION['zoo_preset'];
        }
        return $zoo_preset;
    }
}
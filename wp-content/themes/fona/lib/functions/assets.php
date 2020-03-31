<?php
/**
 * Asset functionality
 *
 * @package    Lib\Functions
 */

/**
 * Register Google fonts for zoo theme
 *
 * @since zoo theme 1.0
 *
 * @return string Google fonts URL for the theme.
 * If use wp_enquere_style: set $wp_load
 * IF import font in file customize-style set $wp_load false
 */
if (!function_exists('zoo_import_fonts'))
{
    function zoo_import_fonts(array $list_fonts, $wp_load=true)
    {

        $fonts_url = '';
        $subsets = $list_variant = $fonts = array();
        $subsets[] = 'latin';
        $subsets[] = 'latin-ext';
        $subset = _x('no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'fona');
        if (!empty($list_fonts)) {
            foreach ($list_fonts as $font) {
                if ($font!= '') {
                    if (is_array($font)) {
                        if ('cyrillic' == $subset) {
                            $subsets[] = 'cyrillic';
                            $subsets[] = 'cyrillic-ext';
                        } elseif ('greek' == $subset) {
                            $subsets[] = 'greek';
                            $subsets[] = 'greek-ext';
                        } elseif ('devanagari' == $subset) {
                            $subsets[] = 'devanagari';
                        } elseif ('vietnamese' == $subset) {
                            $subsets[] = 'vietnamese';
                        }
                        if($font['font-family']!=' ') {
                            if (!isset($fonts[$font['font-family']])) {
                                $fonts[$font['font-family']] = str_replace(' ', '+', $font['font-family']) . (isset($font['variant']) ? ':' . $font['variant'] : '');
                                if (isset($font['variant'])) {
                                    $list_variant[$font['font-family']][] = $font['variant'];
                                }
                            } else {
                                if (isset($font['variant'])) {
                                    if (isset($list_variant[$font['font-family']])) {
                                        if (!in_array($font['variant'], $list_variant[$font['font-family']])) {
                                            $list_variant[$font['font-family']][] = $font['variant'];
                                            $fonts[$font['font-family']] .= ',' . $font['variant'];
                                        }
                                    } else {
                                        $list_variant[$font['font-family']][] = $font['variant'];
                                        $fonts[$font['font-family']] .= ':' . $font['variant'];
                                    }

                                }
                            }
                        }
                    } else {
                        $fonts[] = $font;
                    }
                }
            }

        }
        if ($fonts) {
            if($wp_load){
                $fonts_url = add_query_arg(array(
                    'family' => implode('|', $fonts),
                    'subset' => implode(',', $subsets),
                ), 'https://fonts.googleapis.com/css');
            }else{
                $fonts_url = add_query_arg(array(
                    'family' => urlencode(implode('|', $fonts)),
                    'subset' => urlencode(implode(',', $subsets)),
                ), 'https://fonts.googleapis.com/css');
            }

        }
        return $fonts_url;
    }
}
/**
 * Generate font for customize
 *
 * @since zoo theme 1.0
 *
 * @return string.
 */
if (!function_exists('zoo_generate_font'))
{
    function zoo_generate_font($class, $var)
    {
        $font = '';
        if (isset($var['font-family'])) {
            $font .= "font-family: '{$var['font-family']}', sans-serif;";
        }
        if (isset($var['font-size'])) {
            $font .= "font-size: " . zoo_px2rem((int)str_replace(' ', 'px', $var['font-size'])) . ";";
        }
        if (isset($var['variant'])) {
            $font_weight = ($var['variant'] == 'regular') ? 'normal' : $var['variant'];
            $font .= "font-weight: {$font_weight};";
        }
        if (isset($var['line-height'])) {
            $font .= "line-height: {$var['line-height']};";
        }
        if (isset($var['letter-spacing'])) {
            $font .= "letter-spacing: {$var['letter-spacing']};";
        }
        if (isset($var['text-transform'])) {
            $font .= "text-transform: {$var['text-transform']};";
        }
        if (isset($var['color'])) {
            $font .= "color: {$var['color']};";
        }
        if ($font != '') {
            $font = $class . '{' . $font . '}';
        }
        return $font;
    }
}

/**
 * Generate font size for customize
 *
 * @since zoo theme 1.0
 *
 * @return string.
 */
if (!function_exists('zoo_generate_font_size'))
{
    function zoo_generate_font_size($class, $var)
    {
        $font = $class . '{';
        $font .= "font-size: " . zoo_px2rem((int)str_replace(' ', 'px', $var)) . ";}";
        return $font;
    }
}

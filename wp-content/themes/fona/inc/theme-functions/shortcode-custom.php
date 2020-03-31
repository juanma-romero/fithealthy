<?php
/**
 * Custom file of shortcode, add/change remove shortcode attribute
 */
add_filter('CleverBlog_shortcode_atts', function ($atts) {
    $atts['preset'] = 'default';
    return $atts;
});
add_filter('CleverBanner_shortcode_atts', function ($atts) {
    $atts['box_shadow'] = '';
    $atts['preset'] = '';
    return $atts;
});
add_filter('CleverMultiBanner_shortcode_atts', function ($atts) {
    $atts['preset'] = 'default';
    return $atts;
});
add_filter('CleverProduct_shortcode_atts', function ($atts) {
    $atts['style'] = 'default';
    $atts['topnav'] = '';
    $atts['thumbnail'] = '';
    $atts['highlight-featured'] = '';
    $atts['cat_align'] = 'center';
    return $atts;
});
add_action('vc_after_init', function () {
    vc_add_params('CleverBlog', array(
            array(
                "type" => 'dropdown',
                "heading" => esc_html__('Layout', 'fona'),
                "param_name" => 'preset',
                'std' => 'default',
                "value" => array(
                    esc_html__('Default', 'fona') => 'default',
                    esc_html__('Style 1', 'fona') => 'style-1',
                    esc_html__('Style 2', 'fona') => 'style-2',
                    esc_html__('Style 3', 'fona') => 'style-3',
                ),
                'group' => esc_html__('Layout', 'fona'),
                'description' => esc_html__('Preset for grid posts', 'fona'),
                'dependency' => array('element' => 'layout', 'value' => array('grid')),
            ),
        )
    );
    vc_add_params('CleverMultiBanner', array(
            array(
                "type" => 'dropdown',
                "heading" => esc_html__('Preset', 'fona'),
                "param_name" => 'preset',
                'std' => 'default',
                "value" => array(
                    esc_html__('Default', 'fona') => 'default',
                    esc_html__('Style 1', 'fona') => 'style-1',
                    esc_html__('Style 2', 'fona') => 'style-2',
                    esc_html__('Style 3', 'fona') => 'style-3',
                    esc_html__('Style 4', 'fona') => 'style-4',
                ),
            ),
        )
    );
    vc_add_params('CleverBanner', array(
            array(
                "type" => 'checkbox',
                "heading" => esc_html__('Active box shadow', 'fona'),
                "param_name" => 'box_shadow',
                'std' => '',
            ),
            array(
                "type" => 'dropdown',
                "heading" => esc_html__('Preset', 'fona'),
                "param_name" => 'preset',
                'std' => 'default',
                "value" => array(
                    esc_html__('Default', 'fona') => 'default',
                    esc_html__('Style 1', 'fona') => 'style-1',
                    esc_html__('Style 2', 'fona') => 'style-2',
                    esc_html__('Style 3', 'fona') => 'style-3',
                    esc_html__('Style 4', 'fona') => 'style-4',
                    esc_html__('Style 5', 'fona') => 'style-5',
                ),
            ),
        )
    ); vc_add_params('CleverProduct', array(
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Style', 'fona'),
                'param_name' => 'style',
                'std' => 'default',
                'group' => esc_html__('Layout', 'fona'),
                "value" => array(
                    esc_html__('Default', 'fona') => 'default',
                    esc_html__('Style 2', 'fona') => 'style-2',
                    esc_html__('Style 3', 'fona') => 'style-3',
                    esc_html__('Style 4', 'fona') => 'style-4',
                    esc_html__('Style 5', 'fona') => 'style-5',
                    esc_html__('Style 6', 'fona') => 'style-6',
                ),
            ),array(
                'type' => 'dropdown',
                'heading' => esc_html__('Show carousel navigation position', 'fona'),
                'param_name' => 'topnav',
                'std' => 'center',
                'group' => esc_html__('Layout', 'fona'),
                "dependency" => Array('element' => 'products_type', 'value' => array('carousel')),
                "value" => array(
                    esc_html__('Center', 'fona') => 'center',
                    esc_html__('Top', 'fona') => 'top',
                    esc_html__('Bottom', 'fona') => 'bottom',
                ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Thumbnail size', 'fona'),
                'param_name' => 'thumbnail',
                'std' => '',
                'group' => esc_html__('Layout', 'fona'),
                'value' => array(esc_html__('Yes', 'fona') => '1'),
                'description' => esc_html__('If check, product image will use thumbnail size', 'fona'),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Highlight featured product', 'fona'),
                'param_name' => 'highlight-featured',
                'std' => '',
                'group' => esc_html__('Layout', 'fona'),
                'value' => array(esc_html__('Yes', 'fona') => '1'),
                "dependency" => Array('element' => 'products_type', 'value' => array('grid')),
                'description' => esc_html__('If check, Featured product will highlight', 'fona'),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Category filter align', 'fona'),
                'param_name' => 'cat_align',
                'std' => 'center',
                'group' => esc_html__('Filter', 'fona'),
                "dependency" => Array('element' => 'show_filter', 'value' => array('1')),
                "value" => array(
                    esc_html__('Center', 'fona') => 'center',
                    esc_html__('Left', 'fona') => 'left',
                    esc_html__('Right', 'fona') => 'right',
                ),
            ),
        )
    );
}, 10, 0);
/**
 *   New shortcode
 **/

if (class_exists('WooCommerce') && function_exists('clever_register_shortcode')) {
    function zoo_product_carousel_group_shortcode(array $atts, $content = null)
    {
        $html = cvca_get_shortcode_view('product-carousel-group', $atts, $content);
        return $html;
    }
    global $cvca_product_cats;
    /**
     * Register shortcode
     */
    clever_register_shortcode(
        'CleverProductCarouselGroup',
        array(
            'title' => '',
            'cats' => 'all',
            'columns' => '1',
            'rows' => '3',
            'show'=>'',
            'posts_per_page' => '6',
            'css' => ''
        ),
        'zoo_product_carousel_group_shortcode',
        array(
            'name' => esc_html__('Clever Products Carousel group', 'fona'),
            'base' => 'CleverProductCarouselGroup',
            'icon' => '',
            'category' => esc_html__('CleverSoft', 'fona'),
            'description' => esc_html__('Display group products with carousel layout', 'fona'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Title', 'fona'),
                    'value' => '',
                    'param_name' => 'title',
                ),
                array(
                    "type" => "cvca_product_categories",
                    "heading" => esc_html__("Categories", 'fona'),
                    "param_name" => "cats",
                    "default" => "all",
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Asset type', 'fona'),
                    'value' => array(
                        esc_html__('All', 'fona') => '',
                        esc_html__('Featured product', 'fona') => 'featured',
                        esc_html__('Onsale product', 'fona') => 'onsale',
                        esc_html__('Best Selling', 'fona') => 'best-selling',
                        esc_html__('Latest product', 'fona') => 'latest',
                        esc_html__('Top rate product', 'fona') => 'toprate ',
                        esc_html__('Sort by price: low to high', 'fona') => 'price',
                        esc_html__('Sort by price: high to low', 'fona') => 'price-desc',
                    ),
                    'std' => '',
                    'param_name' => 'show',
                    'description' => esc_html__('Select asset type of products', 'fona'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Number products', 'fona'),
                    'description' => esc_html__('Number products display', 'fona'),
                    'std' => '6',
                    'param_name' => 'posts_per_page',
                ), array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Columns', 'fona'),
                    'description' => esc_html__('Number columns of layout', 'fona'),
                    'std' => '1',
                    'param_name' => 'columns',
                ), array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Rows', 'fona'),
                    'description' => esc_html__('Number rows of 1 column', 'fona'),
                    'std' => '3',
                    'param_name' => 'rows',
                ), array(
                    'type' => 'css_editor',
                    'counterup' => esc_html__('Css', 'fona'),
                    'param_name' => 'css',
                    'group' => esc_html__('Design options', 'fona'),
                )
            )
        )
    );
}
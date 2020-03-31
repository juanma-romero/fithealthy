<?php
/**
 * Blog Panel
 *
 * @uses    object    $this          CleverTheme
 * @uses    object    $this    Clever_Customizer
 *
 * @package    Clever_Theme\Core\Backend\Customizer
 */
$zoo_customize->add_panel( 'blog', array(
    'title'       => esc_html__( 'Blog', 'fona' ),
    'description' => esc_html__( 'Blog theme options.', 'fona' ),
    'priority' => 83
) );
/* ----------------------------------------------------------
					Section - Blog Archive
---------------------------------------------------------- */
$zoo_customize->add_section( 'blog-archive', array(
    'title'       => esc_html__( 'Blog Archive', 'fona' ),
    'panel'       => 'blog',
    'description' => esc_html__( 'Set a default layout for your archive page.', 'fona' ),
    'priority' => 5
) );
$zoo_customize->add_field('zoo_customizer', array(
    'type' => 'custom',
    'settings' => 'zoo_blog_layout_heading',
    'label' => esc_html__('', 'fona'),
    'section' => 'blog-archive',
    'default' => '<div class="zoo-options-heading">' . esc_html__('Blog Layout', 'fona') . '</div>',
    'priority' => 5
));
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'     => 'select',
    'settings' => 'zoo_blog_layout',
    'label'    => esc_html__( 'Posts layout', 'fona' ),
    'section'  => 'blog-archive',
    'default'  => 'grid',
    'choices'  => array(
        'masonry'  => esc_html__('Masonry','fona'),
        'list'  => esc_html__('List','fona'),
    ),
    'priority' => 6
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'     => 'select',
    'settings' => 'zoo_blog_col',
    'label'    => esc_html__( 'Columns', 'fona' ),
    'section'  => 'blog-archive',
    'default'  => '3',
    'description' => esc_html__( 'Columns per row of masonry layout.', 'fona' ),
    'choices'  => array(
        '2'  => esc_html__('2','fona'),
        '3'  => esc_html__('3','fona'),
        '4'  => esc_html__('4','fona'),
        '5'  => esc_html__('5','fona'),
        '6'  => esc_html__('6','fona'),
    ),
    'priority' => 7
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'checkbox',
    'settings'  => 'zoo_blog_show_excerpt',
    'label'     => esc_html__( 'Show Excerpt', 'fona' ),
    'section'   => 'blog-archive',
    'default'   => '1',
    'priority' => 8
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'slider',
    'settings'  => 'zoo_blog_excerpt_length',
    'label'     => esc_html__( 'Number character display the post excerpt.', 'fona' ),
    'section'   => 'blog-archive',
    'default'   => '60',
    'choices'     => array(
        'min'  => '0',
        'max'  => '200',
        'step' => '1',
    ),
    'priority' => 9
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'     => 'select',
    'settings' => 'zoo_blog_pagination',
    'label'    => esc_html__( 'Posts Pagination type', 'fona' ),
    'section'  => 'blog-archive',
    'default'  => 'numeric',
    'choices'  => array(
        'numeric'  => esc_html__('Numeric','fona'),
        'simple'  => esc_html__('Simple','fona'),
        'ajaxload'  => esc_html__('Ajax load more','fona'),
        'infinity'  => esc_html__('Infinity scroll','fona'),
    ),
    'priority' => 10
) );
/* ----------------------------------------------------------
					Section - Blog Single Post
---------------------------------------------------------- */
$zoo_customize->add_section( 'blog-single', array(
    'title'       => esc_html__( 'Blog Single Post', 'fona' ),
    'panel'       => 'blog',
    'description' => esc_html__( 'Set a default layout for your single post page.', 'fona' ),
    'priority' => 15
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'custom',
    'settings'  => 'zoo_blog_single_settings',
    'label'     => esc_html__( '', 'fona' ),
    'section'   => 'blog-single',
    'default'   => '<div class="zoo-options-heading">' . esc_html__( 'Single Post Settings', 'fona' ) . '</div>',
    'priority' => 10
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'checkbox',
    'settings'  => 'zoo_blog_single_tags',
    'label'     => esc_html__( 'Show Tags', 'fona' ),
    'section'   => 'blog-single',
    'default'   => '1',
    'priority' => 16
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'checkbox',
    'settings' => 'zoo_blog_single_nav',
    'label'     => esc_html__( 'Show block single navigation', 'fona' ),
    'section'   => 'blog-single',
    'default'   => '',
    'priority' => 16
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'checkbox',
    'settings' => 'zoo_blog_post_author',
    'label'     => esc_html__( 'Show Post Author', 'fona' ),
    'description' => esc_html__( 'If check, About of author post will show.', 'fona' ),
    'section'   => 'blog-single',
    'default'   => '',
    'priority' => 16
) );
/* Options heading - Blog Related Posts */
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'custom',
    'settings'  => 'zoo_blog_single_related_heading',
    'label'     => esc_html__( '', 'fona' ),
    'section'   => 'blog-single',
    'default'   => '<div class="zoo-options-heading">' . esc_html__( 'Blog Related Posts', 'fona' ) . '</div>',
    'priority' => 17
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'checkbox',
    'settings'  => 'zoo_blog_single_related',
    'label'     => esc_html__( 'Show Related posts', 'fona' ),
    'section'   => 'blog-single',
    'default'   => '1',
    'priority' => 18
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'slider',
    'settings'  => 'zoo_blog_single_related_number_items',
    'label'     => esc_html__( 'Number items', 'fona' ),
    'section'   => 'blog-single',
    'default'   => '3',
    'choices'     => array(
        'min'  => '1',
        'max'  => '6',
        'step' => '1',
    ),
    'priority' => 19
) );
/* ----------------------------------------------------------
					Section - Blog Archive
---------------------------------------------------------- */
$zoo_customize->add_section( 'blog-sidebar', array(
    'title'       => esc_html__( 'Blog sidebar', 'fona' ),
    'panel'       => 'blog',
    'description' => esc_html__( 'Set a default sidebar for your archive page.', 'fona' ),
    'priority' => 20
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'     => 'select',
    'settings' => 'zoo_blog_sidebar_left',
    'label'    => esc_html__( 'Blog Sidebar Left', 'fona' ),
    'section'  => 'blog-sidebar',
    'description' => esc_html__( 'If select none, left sidebar will hide.', 'fona' ),
    'choices'  => zoo_get_sidebar_options(),
    'priority' => 21
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'     => 'select',
    'settings' => 'zoo_blog_sidebar_right',
    'label'    => esc_html__( 'Blog Sidebar Right', 'fona' ),
    'description' => esc_html__( 'If select none, right sidebar will hide.', 'fona' ),
    'section'  => 'blog-sidebar',
    'choices'  => zoo_get_sidebar_options(),
    'priority' => 22
) );

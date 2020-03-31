<?php
/**
 * Footer Panel
 *
 * @uses    object    $this          CleverTheme
 * @uses    object    $this    Clever_Customizer
 *
 * @package    Clever_Theme\Core\Backend\Customizer
 */

$zoo_customize->add_section('footer', array(
    'title'       => esc_html__('Footer', 'fona'),
    'description' => esc_html__('Footer theme options.', 'fona'),
    'priority' => 82
));
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'custom',
    'settings'  => 'zoo_footer_layout_heading',
    'label'     => esc_html__( '', 'fona' ),
    'section'   => 'footer',
    'default'   => '<div class="zoo-options-heading">' . esc_html__( 'Footer Layout', 'fona' ) . '</div>','priority' => 5
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'     => 'radio-image',
    'settings' => 'zoo_footer_layout',
    'label'    => esc_html__( 'Footer Layout', 'fona' ),
    'section'  => 'footer',
    'default'  => 'default',
    'choices'  => array(
        'default' => esc_url(get_template_directory_uri() . '/lib/assets/icons/footer-style1.png'),
    ),
    'priority' => 6
) );
/* Options heading - Top Footer */
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'custom',
    'settings'  => 'zoo_top_footer_heading',
    'label'     => esc_html__( '', 'fona' ),
    'section'   => 'footer',
    'default'   => '<div class="zoo-options-heading">' . esc_html__( 'Top Footer', 'fona' ) . '</div>',
    'priority' => 10
) );

$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'checkbox',
    'settings'  => 'zoo_top_footer',
    'label'     => esc_html__( 'Enable Top Footer', 'fona' ),
    'section'   => 'footer',
    'default'   => '1',
    'priority' => 11
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'      => 'checkbox',
    'settings'  => 'zoo_main_footer',
    'label'     => esc_html__( 'Enable Main Footer', 'fona' ),
    'section'   => 'footer',
    'default'   => '1',
    'priority' => 12
) );
$zoo_customize->add_field( 'zoo_customizer', array(
    'type'     => 'textarea',
    'settings' => 'zoo_footer_copyright',
    'label'    => esc_html__( 'Copyright text', 'fona' ),
    'section'  => 'footer',
    'default'  => esc_attr( 'Copyright &#169; 2016 Clever Theme by ZooTemplate','fona' ),
    'priority' => 13
) );

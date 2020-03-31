<?php
/**
 * Import/Export Options Panel
 *
 * @uses    object    $wp_customize     WP_Customize_Manager
 * @uses    object    $this             ZooCustomizeManager
 *
 * @package    Zoo_Theme\Core\Backend\Customizer
 */
if (isset($_REQUEST['customize-import-nonce']) && isset($_FILES['zoo-customize-import-file'])) {
	$this->import();
}

if (isset($_REQUEST['zoo-customize-export'])) {
	$this->export();
}

$wp_customize->add_section( 'import_export', array(
	'title'	   => esc_html__( 'Import/Export', 'fona' ),
	'priority' => 888888888888
));

$wp_customize->add_setting( 'import-export-setting', array(
	'default' => '',
	'type'	  => 'custom',
	'sanitize_callback' => 'sanitize_key'
));

$wp_customize->add_control(new ZooCustomizeImportExportControl(
	$wp_customize,
	'import-export-setting',
	array(
		'section'  => 'import_export',
		'priority' => 1
	)
));

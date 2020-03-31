<?php
if (!class_exists('WP_Customize_Control', false)) {
    require ABSPATH . 'wp-includes/class-wp-customize-control.php';
}

/**
 * A customizer control for rendering the export/import form.
 */
class ZooCustomizeImportExportControl extends WP_Customize_Control
{
	/**
	 * Render content
	 */
	protected function render_content()
	{
        ?><div class="zoo-options-heading">
        	<?php esc_html_e( 'Export customize options', 'fona' ); ?>
        </div>
        <span class="description customize-control-description">
        	<?php esc_html_e( 'Click the button below to export the customization data for this theme.', 'fona' ); ?>
        </span>
        <input type="button" id="zoo-customize-export-btn" class="button button-primary" name="zoo-customize-export-btn" value="<?php esc_attr_e( 'Download export file', 'fona' ); ?>" />
        <div class="zoo-options-heading">
        	<?php esc_html_e( 'Import customize options', 'fona' ); ?>
        </div>
        <span class="description customize-control-description">
        	<?php esc_html_e( 'Upload a file to import customization data for this theme.', 'fona' ); ?>
        </span>
        <div id="zoo-customizer-import-controls">
        	<input type="file" id="zoo-customize-import-file" name="zoo-customize-import-file" />
        	<label>
        		<input type="checkbox" id="zoo-customize-import-attachment" name="zoo-customize-import-attachment" value="1" />
                <?php esc_html_e( 'Import attachments', 'fona' ); ?>
        	</label>
        	<?php wp_nonce_field( 'z00-th3m3-0pti0ns-imp0rt-3xp0rt', 'customize-import-nonce' ); ?>
        </div>
        <input type="button" id="zoo-customize-import-btn" class="button button-primary" name="zoo-customize-import-btn" value="<?php esc_attr_e( 'Upload &amp; import', 'fona' ); ?>" /><?php
	}
}

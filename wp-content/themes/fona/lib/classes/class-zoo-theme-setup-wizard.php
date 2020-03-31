<?php
if (!class_exists('ZooThemeSetupWizard', false)) :
	/**
	 * ZooThemeSetupWizard
	 *
	 * @package    Zoo_Theme\Lib\Main
	 */
	class ZooThemeSetupWizard
	{
		/**
		 * Theme
		 *
		 * @var    object    \WP_Theme
		 */
		protected $theme;

		/**
		 * Current step
		 *
		 * @var    string
		 */
		protected $step = '';

	    /**
	     * System status
	     *
	     * Whether system meets the requirements or not.
	     *
	     * @var    bool
	     */
	    protected $system_status = true;

		/**
		 * Steps
		 *
		 * @var    array
		 */
		protected $steps = array();

		/**
		 * TGMPA instance
		 *
		 * @var    object
		 */
		protected $tgmpa;

		/**
		 * Importer
		 */
	 	protected $importer;

		/**
		 * Constructor
		 */
		private function __construct()
		{
			$this->theme = wp_get_theme();
			$this->importer = new ZooDemoImporter();
			$this->tgmpa = isset($GLOBALS['tgmpa']) ? $GLOBALS['tgmpa'] : TGM_Plugin_Activation::get_instance();
		}

		/**
		 * Singleton
		 */
		static function getInstance()
		{
			static $instance = null;

			if (null === $instance) {
				$instance = new self;
				add_action('admin_menu', array($instance, '_admin_menu'));
				add_action('admin_init', array($instance, '_admin_init'), 30, 0);
				add_action('admin_init', array($instance, '_wizard_steps'), 30, 0);
				add_action('admin_init', array($instance, '_setup_wizard'), 30, 0);
				add_filter('tgmpa_load', array($instance, '_load_tgmpa'), 10, 1);
				add_action('wp_ajax_envato_setup_plugins', array( $instance, '_ajax_plugins'), 10, 0);
				add_action('wp_ajax_envato_setup_content', array( $instance, '_ajax_content'), 10, 0);
				add_action('wp_ajax_envato_setup_child_theme', array( $instance, '_ajax_child_theme'), 10, 0);
				add_action('upgrader_post_install', array( $instance, '_upgrader_post_install'), 10, 2);
			}
		}

		/**
		 * After a theme update we clear the theme_setup_completed option. This prompts the user to visit the update page again.
		 *
		 * @internal    Used as a callback.
		 */
		function _upgrader_post_install( $return, $theme )
		{
			if ( is_wp_error( $return ) ) {
				return $return;
			}

			if ( $theme !== $this->theme->stylesheet ) {
				return $return;
			}

			update_option( $this->theme->template . '_theme_setup_completed', false );

			return $return;
		}

		/**
		 * Conditionally load TGMPA
		 *
		 * @internal    Used as a callback.
		 */
		function _load_tgmpa($status)
		{
			return is_admin() || current_user_can( 'install_themes' );
		}

		/**
		 * Redirect to setup wizard.
		 *
		 * @internal     Used as a calback.
		 */
		function _admin_init()
		{
			ob_start();

			if ( !get_transient( 'theme_setup_wizard_redirect' ) ) {
				return;
			}

			delete_transient( 'theme_setup_wizard_redirect' );

			wp_safe_redirect( admin_url('admin.php?page=theme-setup-wizard') );

			exit;
		}

		/**
		 * Add admin menus/screens.
		 *
		 * @internal    Used as a callback.
		 */
		function _admin_menu()
		{
			$customize_uri = add_query_arg( 'return', urlencode( wp_unslash(filter_input(INPUT_SERVER, 'REQUEST_URI') ) ), 'customize.php' );
			zoo_add_sub_menu_page(
				ZooThemeWelcomePage::SLUG,
				esc_html__( 'Theme Options', 'fona' ),
				esc_html__( 'Theme Options', 'fona' ),
				'manage_options',
				$customize_uri
			);

			$this->hook_suffix = zoo_add_sub_menu_page(
				ZooThemeWelcomePage::SLUG,
				esc_html__( 'Theme Setup', 'fona' ),
				esc_html__( 'Theme Setup', 'fona' ),
				'manage_options',
				'theme-setup-wizard',
				array($this, '_setup_wizard')
			);
		}

		/**
		 * Setup steps.
		 *
		 * @internal    Used as a callback.
		 *
		 * @since 1.1.1
		 * @return array
		 */
		function _wizard_steps()
		{
			$steps = array(
				'introduction' => array(
					'name'    => esc_html__( 'Introduction', 'fona' ),
					'view'    => array( $this, 'introduction' ),
					'handler' => array( $this, 'introduction_save' ),
				),
				'system_status' => array(
					'name'    => esc_html__( 'System', 'fona' ),
					'view'    => array( $this, 'system_status' ),
					'handler' => '',
				),
				'child_theme' => array(
					'name'    => esc_html__( 'Child', 'fona' ),
					'view'    => array( $this, 'child_theme' ),
					'handler' => '',
				),
				'default_plugins' => array(
					'name'    => esc_html__( 'Plugins', 'fona' ),
					'view'    => array( $this, 'default_plugins' ),
					'handler' => '',
				),
				'default_content' => array(
					'name'    => esc_html__( 'Content', 'fona' ),
					'view'    => array( $this, 'default_content' ),
					'handler' => '',
				),
				'demo' => array(
					'name'    => esc_html__( 'Demo', 'fona' ),
					'view'    => array( $this, 'demo' ),
					'handler' => array( $this, 'demo_save' ),
				),
				'next_steps' => array(
					'name'    => esc_html__( 'Ready!', 'fona' ),
					'view'    => array( $this, 'ready' ),
					'handler' => '',
				),
			);

			$this->steps = apply_filters( 'theme_setup_steps', $steps );
		}

		/**
		 * Show the setup wizard
		 *
		 * @internal    Used as a callback.
		 */
		function _setup_wizard()
		{
			if ( empty( $_GET['page'] ) || 'theme-setup-wizard' !== $_GET['page'] ) {
				return;
			}

			ob_end_clean();

			$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

			wp_register_script( 'envato-setup', ZOO_THEME_URI . 'lib/assets/js/envato-setup.min.js', array( 'jquery-core' ), '1.3.0' );

			wp_localize_script( 'envato-setup', 'envato_setup_params', array(
				'tgm_plugin_nonce' => array(
					'update'  => wp_create_nonce( 'tgmpa-update' ),
					'install' => wp_create_nonce( 'tgmpa-install' ),
				),
				'tgm_bulk_url' => $this->tgmpa->get_tgmpa_url(),
				'ajaxurl'      => admin_url( 'admin-ajax.php' ),
				'wpnonce'      => wp_create_nonce( 'envato_setup_nonce' ),
				'verify_text'  => esc_html__( ' Verifying', 'fona' ),
			) );

			wp_enqueue_media();

			wp_enqueue_script( 'envato-setup' );

			wp_enqueue_style( 'envato-setup', ZOO_THEME_URI . 'lib/assets/css/envato-setup.min.css', array( 'wp-admin', 'dashicons', 'install' ), '1.3.0' );

			ob_start();

			$this->setup_wizard_header();

			$this->setup_wizard_steps();

			$show_content = true;

			echo ent2ncr('<div class="envato-setup-content">');

			if ( !empty($_REQUEST['save_step']) && isset( $this->steps[$this->step]['handler'] ) ) {
				$show_content = call_user_func( $this->steps[$this->step]['handler'] );
			}

			if ( $show_content ) {
				$this->setup_wizard_content();
			}

			echo ent2ncr('</div>');

			$this->setup_wizard_footer();

			exit;
		}

		/**
		 * AJAX call to generate child theme
		 *
		 * @internal    Used as a callback.
		 */
		function _ajax_child_theme()
		{
			if ( ! check_ajax_referer( 'envato_setup_nonce', 'wpnonce' ) || empty( $_POST['cThemeName'] ) ) {
				wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'Invalid child theme data. Please try again!', 'fona' ) ) );
			}

			$child_theme_title = sanitize_text_field($_POST['cThemeName']);
			$child_theme_slug = sanitize_title($_POST['cThemeName']);
			$child_theme_path =  get_theme_root() . '/' . $child_theme_slug;
			$functiondotphp = "<?php
	/**
	 * Theme functions and definitions
	 *
	 * @link https://developer.wordpress.org/themes/basics/theme-functions/
	 */\n";
			$styledotphp = "/**
	 * Theme Name: {$child_theme_title}
	 * Description: This is a child theme of {$this->theme->name}
	 * Author: ZooTemplate
	 * Author URI: http://zootemlate.com
	 * Template: {$this->theme->template}
	 * Version: {$this->theme->version}
	 */\n";

			if ( !file_exists($child_theme_path) ) {
				WP_Filesystem();
				global $wp_filesystem;
				$wp_filesystem->mkdir( $child_theme_path );
				$wp_filesystem->put_contents( $child_theme_path . '/style.css', $styledotphp );
				$wp_filesystem->put_contents( $child_theme_path . '/functions.php', $functiondotphp );
				if ( file_exists(ZOO_THEME_DIR . 'screenshot.png') ) {
					copy( ZOO_THEME_DIR . 'screenshot.png', $child_theme_path . '/screenshot.png' );
				} elseif ( file_exists(ZOO_THEME_DIR . 'screenshot.jpg') ) {
					copy( ZOO_THEME_DIR . 'screenshot.jpg', $child_theme_path . '/screenshot.jpg' );
				} else {

				}
				$allowed_themes = get_option( 'allowedthemes' );
				$allowed_themes[$child_theme_slug] = true;
				update_option( 'allowedthemes', $allowed_themes );
			} else {
				wp_send_json( array( 'done' => 1, 'message' => sprintf( esc_html__('%s has already been created. Child theme files are stored in %s.', 'fona' ), $child_theme_title, '<code>' . $child_theme_path . '</code>' ) ) );
			}

			if ($this->theme->template !== $child_theme_slug) :
				update_option('theme_setup_child_theme', $child_theme_title);
				switch_theme( $child_theme_slug );
			endif;

			wp_send_json( array( 'done' => 1, 'message' => sprintf( esc_html__('%s has been created and activated successfully! Child theme files are stored in %s.', 'fona' ), $child_theme_title, '<code><strong>' . $child_theme_path . '</strong></code>' ) ) );
		}

		/**
		 * Do plugins' AJAX
		 *
		 * @internal    Used as a calback.
		 */
		function _ajax_plugins()
		{
			if ( ! check_ajax_referer( 'envato_setup_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
				exit(0);
			}

			$json = array();
			$tgmpa_url = $this->tgmpa->get_tgmpa_url();
			$plugins = $this->get_tgmpa_plugins();

			foreach ( $plugins['activate'] as $slug => $plugin ) {
				if ( $_POST['slug'] === $slug ) {
					$json = array(
						'url'           => $tgmpa_url,
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa->menu,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-activate',
						'action2'       => - 1,
						'message'       => esc_html__( 'Activating', 'fona' ),
					);
					break;
				}
			}

			foreach ( $plugins['update'] as $slug => $plugin ) {
				if ( $_POST['slug'] === $slug ) {
					$json = array(
						'url'           => $tgmpa_url,
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa->menu,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-update',
						'action2'       => - 1,
						'message'       => esc_html__( 'Updating', 'fona' ),
					);
					break;
				}
			}

			foreach ( $plugins['install'] as $slug => $plugin ) {
				if ( $_POST['slug'] === $slug ) {
					$json = array(
						'url'           => $tgmpa_url,
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa->menu,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-install',
						'action2'       => - 1,
						'message'       => esc_html__( 'Installing', 'fona' ),
					);
					break;
				}
			}

			if ( $json ) {
				$json['hash'] = md5( serialize( $json ) );
				wp_send_json( $json );
			} else {
				wp_send_json( array( 'done' => 1, 'message' => esc_html__( 'Success', 'fona' ) ) );
			}

			exit;
		}

		/**
		 * Do content's AJAX
		 *
		 * @internal    Used as a callback.
		 */
		function _ajax_content()
		{
			static $content = null;

			if (null === $content) {
				$content = $this->get_base_content();
			}

			if ( !check_ajax_referer( 'envato_setup_nonce', 'wpnonce' ) || empty( $_POST['content'] ) && isset( $content[$_POST['content']] ) ) {
				wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'Invalid content!', 'fona' ) ) );
			}

			$json = false;
			$this_content = $content[$_POST['content']];

			if ( isset($_POST['proceed']) ) {
				if ( is_callable($this_content['install_callback']) ) {
					$logs = call_user_func( $this_content['install_callback'], $this_content['data'] );
					if ( $logs ) {
						$json = array(
							'done'    => 1,
							'message' => $this_content['success'],
							'debug'   => '',
							'logs'    => $logs,
							'errors'  => '',
						);
					}
				}
			} else {
				$json = array(
					'url'      => admin_url( 'admin-ajax.php' ),
					'action'   => 'envato_setup_content',
					'proceed'  => 'true',
					'content'  => $_POST['content'],
					'_wpnonce' => wp_create_nonce( 'envato_setup_nonce' ),
					'message'  => $this_content['installing'],
					'logs'     => '',
					'errors'   => '',
				);
			}

			if ($json) {
				$json['hash'] = md5( serialize( $json ) );
				wp_send_json( $json );
			} else {
				wp_send_json( array(
					'error'   => 1,
					'message' => esc_html__( 'Error', 'fona' ),
					'logs'    => '',
					'errors'  => '',
				) );
			}
		}

		/**
		 * Get step URL
		 *
		 * @param    string    $step    Step name.
		 *
		 * @return    string
		 */
		protected function get_step_link( $step )
		{
			return add_query_arg( 'step', $step );
		}

		/**
		 * Get next step URL
		 *
		 * @param    string    $step    Step name.
		 *
		 * @return    string
		 */
		protected function get_next_step_link()
		{
			$keys = array_keys( $this->steps );
			$step = array_search( $this->step, $keys ) + 1;

			return add_query_arg( 'step', $keys[$step] );
		}

		/**
		 * Get previous step URL
		 *
		 * @param    string    $step    Step name.
		 *
		 * @return    string
		 */
		protected function get_prev_step_link()
		{
			$keys = array_keys( $this->steps );
			$step = array_search( $this->step, $keys ) - 1;

			return add_query_arg( 'step', $keys[$step] );
		}

		/**
		 * We determine if the user already has theme content installed. This can happen if swapping from a previous theme or updated the current theme. We change the UI a bit when updating / swapping to a new theme.
		 *
		 * @since 1.1.8
		 * @access public
		 */
		protected function is_possible_upgrade()
		{
			return false;
		}

		/**
		 * Get logo image
		 *
		 * @return    string
		 */
		protected function get_logo_image()
		{
			$logo_image_object = false;

			$logo_image_id = get_theme_mod( 'custom_logo' );

			if ($logo_image_id) {
				$logo_image_object = wp_get_attachment_image_src( $logo_image_id, 'full' );
			}

			if ( !empty($logo_image_object[0]) ) {
				$image_src = $logo_image_object[0];
			} elseif ( file_exists(ZOO_THEME_DIR . 'assets/images/logo.png') ) {
				$image_src = ZOO_THEME_URI . 'assets/images/logo.png';
			} else {
				$image_src = admin_url('images/w-logo-blue.png');
			}

			return apply_filters( 'theme_setup_logo_image_src', $image_src );
		}

		/**
		 * Setup Wizard Header
		 */
		protected function setup_wizard_header()
		{
			?><!DOCTYPE html>
			<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
			<head>
				<meta name="viewport" content="width=device-width"/>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
				<?php printf( esc_html__( '%s%sTheme &rsaquo; Setup Wizard%s', 'fona' ), '<ti', 'tle>', '</title>' ) ?>
				<?php do_action( 'admin_print_styles' ); ?>
				<?php do_action( 'admin_print_scripts' ); ?>
				<?php do_action( 'admin_head' ); ?>
			</head>
			<body class="envato-setup wp-core-ui">
			<h1 id="wc-logo">
				<a href="<?php echo esc_url(home_url('/')) ?>" target="_blank"><?php
					printf( '<img class="site-logo" src="%s" alt="%s" />', $this->get_logo_image(), get_option( 'blogname' ) );
				?></a>
			</h1><?php
		}

		/**
		 * Setup Wizard Footer
		 */
		protected function setup_wizard_footer()
		{
			?><a class="wc-return-to-dashboard" href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Return to the WordPress Dashboard', 'fona' ); ?></a>
			</body><?php
			do_action( 'admin_footer' );
			do_action( 'admin_print_footer_scripts' );
			?></html><?php
		}

		/**
		 * Output the steps
		 */
		protected function setup_wizard_steps()
		{
			$ouput_steps = $this->steps;
			$array_keys = array_keys( $this->steps );
			$current_step = array_search( $this->step, $array_keys );

			array_shift( $ouput_steps );

			?><ol class="envato-setup-steps"><?php
				foreach ( $ouput_steps as $step_key => $step ) :
					$class_attr = '';
					$show_link = false;
					if ( $step_key === $this->step ) {
						$class_attr = 'active';
					} elseif ( $current_step > array_search( $step_key, $array_keys ) ) {
						$class_attr = 'done';
						$show_link = true;
					}
					?><li class="<?php echo esc_attr($class_attr) ?>"><?php
						if ( $show_link ) :
							?><a href="<?php echo esc_url( $this->get_step_link( $step_key ) ); ?>"><?php echo esc_html( $step['name'] ); ?></a><?php
						else :
							echo esc_html( $step['name'] );
						endif;
					?></li><?php
				endforeach;
			?></ol><?php
		}

		/**
		 * Output the content for the current step
		 */
		protected function setup_wizard_content()
		{
			isset( $this->steps[$this->step] ) ? call_user_func( $this->steps[$this->step]['view'] ) : false;
		}

		/**
		 * Introduction step
		 */
		protected function introduction()
		{
			if ( $this->is_possible_upgrade() ) :
				?><h1><?php esc_html_e( 'Welcome to theme setup wizard!', 'fona' ); ?></h1>
				<p><?php esc_html_e( 'It looks like you may have recently upgraded to this theme. Great! This setup wizard will help ensure all the default settings are correct. It will also show some information about your new website and support options.', 'fona' ); ?></p>
				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
					   class="button-primary button button-large"><?php esc_html_e( 'Let&#8217;s go!', 'fona' ); ?></a>
					<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url() ); ?>"
					   class="button button-large"><?php esc_html_e( 'Not right now', 'fona' ); ?></a>
				</p>
				<?php
			elseif ( get_option( $this->theme->template . '_theme_setup_completed' ) && true === $this->tgmpa->is_tgmpa_complete() ) :
				?>
				<h1><?php esc_html_e( 'Welcome to theme setup wizard!', 'fona' ); ?></h1>
				<p class="lead success"><strong><?php esc_html_e( 'It looks like you have already run the setup wizard. If you want to run the wizard again, click on "Run setup wizard again".', 'fona' ); ?></strong></p>
				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large"><?php esc_html_e( 'Run setup wizard again', 'fona' ); ?></a>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large"><?php esc_html_e( 'Skip this step', 'fona' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
				</p>
				<?php
			else :
				?>
				<h1><?php esc_html_e( 'Welcome to theme setup wizard!', 'fona' ); ?></h1>
				<p><?php printf(esc_html__( 'Thank you for choosing %s theme! This setup wizard is to help you setup your new website quickly. Step by step, you will install necessary plugins, import demo content, customize site appearance...', 'fona' ), $this->theme->name); ?></p>
				<p><?php esc_html_e( 'If you don&#8217;t want to go through the wizard, you can skip any step or return to the WordPress admin dashboard. Come back anytime if you change your mind!', 'fona' ); ?></p>
				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large"><?php esc_html_e( 'Let&#8217;s go!', 'fona' ); ?></a>
					<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url() ); ?>" class="button button-large"><?php esc_html_e( 'Not right now', 'fona' ); ?></a>
				</p>
				<?php
			endif;
		}

		/**
		 *
		 * Handles save button from welcome page. This is to perform tasks when the setup wizard has already been run. E.g. reset defaults
		 *
		 * @since 1.2.5
		 */
		protected function introduction_save()
		{

			check_admin_referer( 'envato-setup' );

			return false;
		}

		/**
		 * System status
		 */
		protected function system_status()
		{
			?><p><?php esc_html_e('Before installing the theme, we need to check if your system environment. The theme will not work properly if your system doen not meet minimal requirements. Please check it carefully!', 'fona') ?></p>
			<table class="theme-setup-system-status" style="width:100%;padding-bottom:20px;">
				<thead>
					<th><?php esc_html_e('Environment', 'fona') ?></th>
					<th><?php esc_html_e('Info', 'fona') ?></th>
					<th><?php esc_html_e('Value', 'fona') ?></th>
					<th><?php esc_html_e('Status', 'fona') ?></th>
				</thead>
				<tbody>
	        <tr>
	            <?php
	                if (extension_loaded('simplexml')) {
						$xml_parser = 'SimpleXML';
	                } elseif (extension_loaded('xmlreader')) {
						$xml_parser = 'XMLReader';
	                } else {
						$xml_parser = false;
						$this->system_status = false;
	                }
	            ?>
	            <td class="field-label"><?php esc_html_e('XML Parser', 'fona'); ?></td>
	            <td>
	                <span class="field-tooltip" href="#">
	                    <span class="dashicons dashicons-info"></span>
	                    <span class="tip-content">
	                        <?php printf(esc_html__('%s requires SimpleXML or XMLReader extension of PHP to parse WXR file. Make sure to install one of them before importing sample data!', 'fona'), $this->theme->name); ?>
	                    </span>
	                </span>
	            </td>
	            <td class="field-value">
	                <?php
						if (!$xml_parser) {
							esc_html_e('Null', 'fona');
						} else {
							echo esc_html($xml_parser);
						}
					?>
	            </td>
	            <td class="field-status">
	                <span class="dashicons <?php echo esc_html($xml_parser ? 'dashicons-yes' : 'dashicons-no-alt'); ?>"></span>
	            </td>
	        </tr>
					<tr>
						<td><?php esc_html_e('PHP Version', 'fona') ?></td>
						<td>
	            <span class="field-tooltip">
	                <span class="dashicons dashicons-info"></span>
	                <span class="tip-content">
	                    <?php printf( esc_html__('%s requires PHP version 5.4 at least.', 'fona'), $this->theme->name ); ?>
	                    <?php esc_html_e('You should use latest version for better perfomance and security.', 'fona'); ?>
	                </span>
	            </span>
						</td>
						<td><?php echo phpversion() ?></td>
						<td class="field-status">
							<span class="dashicons <?php echo esc_attr($this->get_field_status(phpversion(), '5.4')); ?>"></span>
						</td>
					</tr>
					<tr>
						<td><?php esc_html_e('PHP Memory Limit', 'fona') ?></td>
						<td>
	                        <span class="field-tooltip">
	                            <span class="dashicons dashicons-info"></span>
	                            <span class="tip-content">
	                                <?php esc_html_e('Importing demo data could use large amount of memory.', 'fona'); ?>
									<?php printf( esc_html__('At peak, %s may require at least 256M of memory.', 'fona'), $this->theme->name ); ?>
	                            </span>
	                        </span>
						</td>
						<td><?php echo ini_get('memory_limit') ?></td>
						<td class="field-status">
							<span class="dashicons <?php echo esc_attr($this->get_field_status(wp_convert_hr_to_bytes(ini_get('memory_limit')), 256*MB_IN_BYTES)); ?>"></span>
						</td>
					</tr>
					<tr>
						<td><?php esc_html_e('WordPress Version', 'fona') ?></td>
						<td>
	                        <span class="field-tooltip">
	                            <span class="dashicons dashicons-info"></span>
	                            <span class="tip-content">
	                                <?php printf( esc_html__('%s requires WordPress version 4.4 at least.', 'fona'), $this->theme->name ); ?>
	                                <?php esc_html_e('You should use latest version for better perfomance and security.', 'fona'); ?>
	                            </span>
	                        </span>
						</td>
						<td><?php echo esc_html($GLOBALS['wp_version']); ?></td>
						<td class="field-status">
							<span class="dashicons <?php echo esc_attr($this->get_field_status($GLOBALS['wp_version'], '4.4')); ?>"></span>
						</td>
					</tr>
					<tr>
	            <?php
	                $max_execution_time = ini_get('max_execution_time');
	            ?>
	            <td class="field-label"><?php
	                esc_html_e('Max Execution Time', 'fona');
	            ?></td>
	            <td>
	                <span class="field-tooltip" href="#">
	                    <span class="dashicons dashicons-info"></span>
	                    <span class="tip-content">
	                        <?php printf(esc_html__('%s requires at least 30s of PHP execution time.', 'fona'), $this->theme->name); ?>
	                    </span>
	                </span>
	            </td>
	            <td><?php echo esc_html($max_execution_time); ?>s</td>
	            <td class="field-status">
	                <span class="dashicons <?php echo esc_attr($this->get_field_status($max_execution_time, 30)); ?>"></span>
	            </td>
	        </tr>
	        <tr>
	            <?php
	                $origin_file_size_limit = ini_get('upload_max_filesize');
	                $file_size_limit = wp_convert_hr_to_bytes($origin_file_size_limit);
	            ?>
	            <td class="field-label"><?php
	                esc_html_e('Max Upload File Size', 'fona');
	            ?></td>
	            <td>
	                <span class="field-tooltip" href="#">
	                    <span class="dashicons dashicons-info"></span>
	                    <span class="tip-content">
	                        <?php printf(esc_html__('%s requires at least 2M of total upload file size.', 'fona'), $this->theme->name); ?>
	                    </span>
	                </span>
	            </td>
	            <td><?php echo esc_html($origin_file_size_limit); ?></td>
	            <td class="field-status">
	                <span class="dashicons <?php echo esc_attr($this->get_field_status($file_size_limit, 2*MB_IN_BYTES)); ?>"></span>
	            </td>
	        </tr>
	               <tr>
	                    <?php
	                        $origin_upload_limit = ini_get('post_max_size');
	                        $upload_limit = wp_convert_hr_to_bytes($origin_upload_limit);
	                    ?>
	                    <td class="field-label"><?php
	                        esc_html_e('Server Max Post Size', 'fona');
	                    ?></td>
	                    <td>
	                        <span class="field-tooltip" href="#">
	                            <span class="dashicons dashicons-info"></span>
	                            <span class="tip-content"><?php
	                                printf( esc_html__('%s requires at least 8M of total file size.', 'fona'), $this->theme->name );
	                            ?></span>
	                        </span>
	                    </td>
						<td><?php echo esc_html($origin_upload_limit); ?></td>
	                    <td class="field-status">
	                        <span class="dashicons <?php echo esc_attr($this->get_field_status($upload_limit, 8*MB_IN_BYTES)); ?>"></span>
	                    </td>
	                </tr>
				</tbody>
			</table>
			<?php if (!$this->system_status) : ?>
				<p style="color:red"><strong><?php esc_html_e('Whoops, your system does not meet the requirements. You should contact your hosting or VPS provider to fix it before installing this theme.', 'fona') ?></strong></p>
			<?php endif; ?>
			<p class="envato-setup-actions step">
				<?php
					if ($this->system_status) :
						?><a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large"><?php esc_html_e( 'Continue', 'fona' ); ?></a><a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large"><?php esc_html_e( 'Skip this step', 'fona' ); ?></a><?php
					else :
						?><a href="<?php echo esc_url( admin_url() ); ?>" class="button-primary button button-large"><?php esc_html_e( 'Abort', 'fona' ); ?></a><a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large"><?php esc_html_e( 'Proceed anyway', 'fona' ); ?></a><?php
					endif;
				?>
			</p>
			<?php
		}

		/**
		 * Child theme
		 */
		protected function child_theme()
		{
			$is_child_theme = is_child_theme();
			$child_theme_option = get_option('theme_setup_child_theme');
			$theme = $child_theme_option ? wp_get_theme($child_theme_option)->name : $this->theme->name . ' Child';
			$class_attr = $is_child_theme ? 'lead success' : '';

			?><h1><?php esc_html_e('Setup a Child Theme', 'fona') ?></h1>
			<p id="envato-setup-child-theme-text" class="<?php echo esc_attr($class_attr) ?>"><?php
				if ($is_child_theme) {
					printf( esc_html__('%sGreat! A child theme named as %s has already been created and activated successfully%s.', 'fona'), '<strong>', $theme, '</strong>' );
				} else {
					printf( esc_html__('If you are going to make changes to theme source code, it&#8217;s better to use a %schild theme%s rather than modifying parent theme. This allows parent theme to receive updates without overwriting your modifications. To generate a child theme, please enter child theme name then click on the "Create child theme" button.', 'fona'), '<a href="https://codex.wordpress.org/Child_Themes" target="_blank">', '</a>' );
				}
			?></p>
			<form action="" method="post">
			 	<div class="child-theme-input" style="margin-bottom:20px;">
			 		<label for="child_theme_name" style="margin-bottom: 5px; display: block;"><strong><?php esc_html_e('Child Theme Name', 'fona') ?></strong></label>
					<input type="text" name="child_theme_name" id="child_theme_name" style="padding:10px;width:100%;" value="<?php echo esc_attr($theme); ?>" />
				 </div>
				<p class="envato-setup-actions step"><?php
					if (!$is_child_theme) :
				    	?><a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="install_child"><?php esc_html_e( 'Create child theme', 'fona' ); ?></a>
						<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large"><?php esc_html_e( 'Skip this step', 'fona' ); ?></a><?php
						wp_nonce_field('envato-setup');
					else :
						?><a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large"><?php esc_html_e( 'Continue', 'fona' ); ?></a><a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large"><?php esc_html_e( 'Skip this step', 'fona' ); ?></a>
						<?php wp_nonce_field( 'envato-setup' ); ?><?php
					endif;
				?></p>
			</form><?php
		}

		/**
		 * Get registered TGMPA plugins
		 *
		 * @return    array
		 */
		protected function get_tgmpa_plugins()
		{
			$plugins  = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
			);

			foreach ( $this->tgmpa->plugins as $slug => $plugin ) {
				if ( $this->tgmpa->is_plugin_active( $slug ) && false === $this->tgmpa->does_plugin_have_update( $slug ) ) {
					continue;
				} else {
					$plugins['all'][$slug] = $plugin;
					if ( !$this->tgmpa->is_plugin_installed( $slug ) ) {
						$plugins['install'][$slug] = $plugin;
					} else {
						if ( false !== $this->tgmpa->does_plugin_have_update( $slug ) ) {
							$plugins['update'][$slug] = $plugin;
						}
						if ( $this->tgmpa->can_plugin_activate( $slug ) ) {
							$plugins['activate'][$slug] = $plugin;
						}
					}
				}
			}

			return $plugins;
		}

		/**
		 * Theme plugins
		 */
		protected function default_plugins()
		{
			$url     = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), 'envato-setup' );
			$method  = '';
			$fields  = array_keys($_POST);
			$creds   = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields );

			tgmpa_load_bulk_installer();

			if ( false === $creds ) {
				return true;
			}

			if ( !WP_Filesystem( $creds ) ) {
				request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );
				return true;
			}

			?><h1><?php esc_html_e( 'Setup Plugins', 'fona' ); ?></h1>
			<form action="" method="post"><?php
				$plugins = $this->get_tgmpa_plugins();
				$count = count( $plugins['all'] );
				if ( $count ) :
					?><p><?php esc_html_e( 'Your website needs a few essential plugins. The following plugins will be installed or updated', 'fona' ); ?>:</p>
					<ul class="envato-wizard-plugins"><?php
						foreach ( $plugins['all'] as $slug => $plugin ) :
							?><li data-slug="<?php echo esc_attr( $slug ); ?>"><?php
								echo esc_html( $plugin['name'] );
								?><span><?php
								    $keys = array();
								    if ( isset( $plugins['install'][$slug] ) ) {
									    $keys[] = 'Installation';
								    }
								    if ( isset( $plugins['update'][$slug] ) ) {
									    $keys[] = 'Update';
								    }
								    if ( isset( $plugins['activate'][$slug] ) ) {
									    $keys[] = 'Activation';
								    }
								    echo implode( ' and ', $keys ) . ' required';
								?></span><div class="spinner"></div>
							</li><?php
						endforeach;
					?></ul><?php
				else :
					?><p class="lead success"><strong><?php esc_html_e( 'Great! All plugins has already been installed and up to date.', 'fona' ) ?></strong></p><?php
				endif;
				?><p><?php printf( esc_html__( 'Note that you can add and remove plugins from within %sWordPress admin dashboard%s whenever you want.', 'fona' ), '<a href="'.admin_url('plugins.php').'">', '</a>' ); ?></p>
				<p class="envato-setup-actions step">
					<?php
						if ($count) :
							?><a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="install_plugins"><?php esc_html_e( 'Install plugins', 'fona' ); ?></a><?php
						else :
							?><a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-primary button-large"><?php esc_html_e( 'Continue', 'fona' ); ?></a><?php
						endif;
					?>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large"><?php esc_html_e( 'Skip this step', 'fona' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
				</p>
			</form><?php
		}

		/**
		 * Page setup
		 */
		protected function default_content()
		{
			if (true !== $this->tgmpa->is_tgmpa_complete()) {
				wp_redirect($this->get_step_link('default_plugins'));
				exit;
			}

			$this->importer->importStart();

			$content = $this->get_base_content();

			?><h1><?php esc_html_e( 'Import Sample Content', 'fona' ); ?></h1>
			<form action="" method="post"><?php
				if ( $this->is_possible_upgrade() ) :
					?><p><?php esc_html_e( 'It looks like you already have content imported. If you would like to install the default demo content as well you can select it below. Otherwise just choose the upgrade option to ensure everything is up to date.', 'fona' ); ?></p><?php
				else :
					?><p><?php esc_html_e( 'It&#8217;s time to import some sample content for your new website. Tick the checkboxes of the contents you would like to import. Once imported, the content can be managed within the WordPress admin dashboard.', 'fona' ); ?></p><?php
				endif;
				?><table class="envato-setup-pages" cellspacing="0">
					<tbody><?php
					foreach ( $content as $slug => $default ) :
						if ('baseurl' === $slug || 'version' === $slug) {
							continue;
						}
						if ('users' === $slug) {
							$default['checked'] = false;
						}
						?><tr class="envato_default_content" data-content="<?php echo esc_attr( $slug ); ?>">
							<td>
								<input type="checkbox" name="default_content[<?php echo esc_attr( $slug ); ?>]" class="envato_default_content" id="default_content_<?php echo esc_attr( $slug ); ?>" value="1" <?php echo ( !isset( $default['checked'] ) || $default['checked'] ) ? ' checked' : ''; ?>>
							</td>
							<td><label for="default_content_<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $default['title'] ); ?></label>
							</td>
							<td class="description"><?php echo esc_html( $default['description'] ); ?></td>
							<td class="status"><span><?php echo esc_html( $default['pending'] ); ?></span>
							<div class="spinner"></div>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<br>
				<p><strong><em><?php esc_html_e('If you don&#8217;t know what content you should tick, it&#8217;s good idea to leave everything as default.', 'fona') ?></em></strong></p>
				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="install_content"><?php esc_html_e( 'Continue', 'fona' ); ?></a>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large"><?php esc_html_e( 'Skip this step', 'fona' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
				</p>
			</form><?php
		}

		/**
		 * Choose style
		 */
		protected function demo()
		{
			$folders = new DirectoryIterator(ZOO_THEME_DIR . 'inc/sample-data');
			$current_style = get_theme_mod( 'theme_setup_site_style', 'default' );

	        ?><form action="" method="post">
				<h2><?php esc_html_e('Select site demo', 'fona') ?></h2>
	            <div class="theme-presets">
	                <ul><?php
	                    foreach ($folders as $folder) :
							if ($folder->isDot() || !$folder->isDir() || !$folder->isReadable()) {
								continue;
							}
							$style = $folder->getFilename();
							if ('base' === $style) {
								continue;
							}
		                    ?><li class="<?php echo esc_attr($style === $current_style ? 'current ' : ''); ?>">
	                            <a href="#" data-style="<?php echo esc_attr($style); ?>"><img src="<?php echo ZOO_THEME_URI . 'inc/sample-data/'.$style.'/screen.jpg' ?>"></a>
	                        </li><?php
						endforeach;
					?></ul>
	            </div>
	            <input type="hidden" name="new_style" id="new_style" value="<?php echo esc_attr($current_style); ?>">
				<p><em><?php esc_html_e('If you are unsure to choose which style, just leave to it default. This works best on fresh new sites.', 'fona') ?></em></p>
	            <p class="envato-setup-actions step">
	                <input type="submit" class="button-primary button button-large" value="<?php esc_attr_e( 'Continue', 'fona' ); ?>" name="save_step" />
	                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large"><?php esc_html_e( 'Skip this step', 'fona' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
	            </p>
	        </form><?php
		}

		/**
		 * Save logo & design options
		 */
		protected function demo_save()
		{
			check_admin_referer( 'envato-setup' );

			$new_style = isset( $_POST['new_style'] ) ? sanitize_key($_POST['new_style']) : false;
			$imported_posts = get_transient('_wxr_imported_posts') ? : array();

			if ( $new_style ) {
				$style_demo_dir = ZOO_THEME_DIR . 'inc/sample-data/' . $new_style . '/';
				if ( file_exists($style_demo_dir . 'content.xml') ) {
					$xml_parser = new ZooWXRParser();
					$content = $xml_parser->parse($style_demo_dir . 'content.xml');
					$page_id = $content['posts'][0]['post_id'];
					if ( isset($imported_posts[$page_id]) ) {
						update_option( 'show_on_front', 'page' );
						update_option( 'page_on_front', $imported_posts[$page_id] );
					} else {
						$this->importer->importPosts($content['posts']);
						$imported_posts = get_transient('_wxr_imported_posts') ? : array();
						update_option( 'show_on_front', 'page' );
						update_option( 'page_on_front', $imported_posts[$page_id] );
					}
				}
				if ( file_exists($style_demo_dir . 'slider.zip') ) {
					$this->importer->importRevSliders($style_demo_dir . 'slider.zip');
				}
				set_theme_mod('theme_setup_site_style', $new_style);
			}

			$this->importer->remapImportedData();
			$this->importer->importEnd();

			wp_redirect( esc_url_raw( $this->get_next_step_link() ) );

			exit;
		}

		/**
		 * Final step
		 */
		protected function ready()
		{
			$customize_uri = add_query_arg( 'return', urlencode( wp_unslash( filter_input(INPUT_SERVER, 'REQUEST_URI') ) ), 'customize.php' );

			?><h1 style="color:#7eb62e;"><?php esc_html_e( 'Congratulations! Your website is ready!', 'fona' ); ?></h1>
			<p><?php esc_html_e('Theme has been installed successfully. Go back to your WordPress dashboard to customize the default content and appearance to suit your needs.', 'fona') ?></p>
			<div class="envato-setup-next-steps">
				<div class="envato-setup-next-steps-first">
					<h2 style="padding-bottom:10px"><?php esc_html_e( 'Next Steps', 'fona' ); ?></h2>
					<ul>
						<li class="setup-product">
							<a class="button button-primary button-large" href="https://themeforest.net/downloads" target="_blank"><?php esc_html_e( 'Rate this theme', 'fona' ); ?></a>
						</li>
						<li class="setup-product"><a class="button button-large" href="<?php echo esc_url( home_url('/') ); ?>"><?php esc_html_e( 'View your website', 'fona' ); ?></a></li>
						<li class="setup-product"><a class="button button-large" href="<?php echo esc_url(admin_url($customize_uri)); ?>"><?php esc_html_e( 'Customize your website', 'fona' ); ?></a></li>
					</ul>
				</div>
				<div class="envato-setup-next-steps-last">
					<h2 style="padding-bottom:10px"><?php esc_html_e( 'More Steps', 'fona' ); ?></h2>
					<ul>
						<li class="howto" style="font-style:normal">
							<a href="https://codex.wordpress.org/New_To_WordPress_-_Where_to_Start" target="_blank"><?php esc_html_e( 'Learn WordPress', 'fona' ); ?></a>
						</li>
						<li class="documentation">
							<a href="http://doc.zootemplate.com/<?php echo get_option('template') ?>" target="_blank"><?php esc_html_e( 'Read Documentation', 'fona' ); ?></a>
						</li>
						<li class="documentation">
							<a href="<?php echo esc_url('https://themeforest.net/page/item_support_policy') ?>" target="_blank"><?php esc_html_e( 'Item Support Policy', 'fona' ); ?></a>
						</li>
						<li class="support">
							<a href="<?php echo esc_url('http://member.zootemplate.com/helpdesk') ?>" target="_blank"><?php esc_html_e( 'Get Help and Support', 'fona' ); ?></a>
						</li>
					</ul>
				</div>
			</div><?php

			update_option( $this->theme->template . '_theme_setup_completed', time() );
		}

		/**
		 * Get base sample data
		 *
		 * @return    array
		 */
		protected function get_base_content()
		{
			$content = array();
			$base_dir = ZOO_THEME_DIR . 'inc/sample-data/base/';

			if ( file_exists($base_dir . 'content.xml') ) {
				$xml_parser = new ZooWXRParser();
				$content = $xml_parser->parse($base_dir . 'content.xml');
			}

			if ( !empty($content) && is_array($content) ) {
				foreach ($content as $slug => $data) {
					if ('baseurl' === $slug || 'version' === $slug) {
						continue;
					}
					$content[$slug]['title'] = ucwords($slug);
					$content[$slug]['description'] = esc_html__('Sample', 'fona') . ' ' . $slug . ' ' . esc_html__('data.', 'fona');
					$content[$slug]['pending'] = esc_html__('Pending', 'fona');
					$content[$slug]['installing'] = esc_html__('Installing', 'fona');
					$content[$slug]['success'] = esc_html__('Success', 'fona');
					$content[$slug]['checked'] = $this->is_possible_upgrade() ? 0 : 1;
					$content[$slug]['install_callback'] = array($this->importer, 'import' . ucfirst($slug));
					$content[$slug]['data'] = $data;
				}
			}

			if ( file_exists($base_dir . 'widgets.wie') ) {
				$content['widgets'] = array(
					'title'            => esc_html__('Widgets', 'fona'),
					'description'      => esc_html__('Sample widgets data.', 'fona'),
					'pending'          => esc_html__('Pending', 'fona'),
					'installing'       => esc_html__('Installing', 'fona'),
					'success'          => esc_html__('Success', 'fona'),
					'install_callback' => array($this->importer, 'importWidgets'),
					'checked'          => $this->is_possible_upgrade() ? 0 : 1,
					'data' 			   => $base_dir . 'widgets.wie'
				);
			}

			if ( file_exists($base_dir . 'slider.zip') ) {
				$content['sliders'] = array(
					'title'            => esc_html__('Sliders', 'fona'),
					'description'      => esc_html__('Sample sliders data.', 'fona'),
					'pending'          => esc_html__('Pending', 'fona'),
					'installing'       => esc_html__('Installing', 'fona'),
					'success'          => esc_html__('Success', 'fona'),
					'install_callback' => array($this->importer, 'importRevSliders'),
					'checked'          => $this->is_possible_upgrade() ? 0 : 1,
					'data' 			   => $base_dir . 'slider.zip'
				);
			}

			if ( file_exists($base_dir . 'customizer.dat') ) {
				$content['options'] = array(
					'title'            => esc_html__('Options', 'fona'),
					'description'      => esc_html__('Sample theme options data.', 'fona'),
					'pending'          => esc_html__('Pending', 'fona'),
					'installing'       => esc_html__('Installing', 'fona'),
					'success'          => esc_html__('Success', 'fona'),
					'install_callback' => array($this->importer, 'importThemeOptions'),
					'checked'          => $this->is_possible_upgrade() ? 0 : 1,
					'data' 			   => $base_dir . 'customizer.dat'
				);
			}

			if ( file_exists($base_dir . 'settings') ) {
				$content['settings'] = array(
					'title'            => esc_html__('Settings', 'fona'),
					'description'      => esc_html__('Sample theme and plugins&#8217; settings data.', 'fona'),
					'pending'          => esc_html__('Pending', 'fona'),
					'installing'       => esc_html__('Installing', 'fona'),
					'success'          => esc_html__('Success', 'fona'),
					'install_callback' => array($this->importer, 'importThemeSettings'),
					'checked'          => $this->is_possible_upgrade() ? 0 : 1,
					'data' 			   => $base_dir . 'settings/'
				);
			}

			$content = apply_filters( 'theme_setup_content', $content, $this );

			return $content;
		}

		/**
		 * Compare value to get status
		 *
		 * @param    int    $current      Current installed value.
		 * @param    int    $required     Required value.
		 *
		 * @return    string    $status    Field's status.
		 */
		protected function get_field_status($current, $required)
		{
			if ($current >= $required || $current === -1) {
				$status = 'dashicons-yes';
				$this->system_status = $this->system_status ? : false;
			} else {
				$status = 'dashicons-no-alt';
				$this->system_status = false;
			}

			return $status;
		}
	}
	ZooThemeSetupWizard::getInstance();
endif;

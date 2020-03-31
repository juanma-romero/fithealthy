<?php
if (!class_exists('ZooThemeWelcomePage', false)) {
    /**
     * ZooThemeWelcomePage
     */
    class ZooThemeWelcomePage
    {
        /**
         * Slug
         */
        const SLUG = 'zoo-theme-welcome';

        /**
         * Option group
         *
         * @var  string
         */
        const GROUP = 'zoo_theme_welcome_group';

        /**
         * Theme object
         */
        protected $theme;

        /**
         * Hook suffix
         */
        public $hook_suffix;

        /**
         * Settings
         *
         * @var  array
         */
        protected $settings;

        /**
         * Constructor
         */
        private function __construct()
        {
            $this->theme = wp_get_theme(get_option('template'));
            $this->settings = (array)get_option('zoo_theme_settings') ? : array();
        }

        /**
         * Singleton
         */
        static function getInstance()
        {
            static $instance = null;

            if (null === $instance) {
                $instance = new self;
                add_action('admin_menu', array($instance, '_add'));
            }
        }

        /**
         * Add to admin menu
         */
        function _add($context = '')
        {
            $label = !empty($this->theme->name) ? $this->theme->name : esc_html__('Welcome', 'fona');
            $this->hook_suffix = zoo_add_menu_page(
                $label,
                $label,
                'manage_options',
                self::SLUG,
                array($this, '_render'),
                'dashicons-admin-generic',
                3
            );
        }

        /**
         * Render
         */
        function _render()
        {
            global $wpdb;

            wp_enqueue_script('dashboard');
            $logo_src = get_template_directory_uri().'/inc/sample-data/base/logo.png';

            if (defined('WP_DEBUG') && WP_DEBUG) {
                $wp_debug_mode = 'true';
            } else {
                $wp_debug_mode = 'false';
            }

            $active_plugin_slugs = get_option('active_plugins');

            $active_plugins = array();

            foreach ($active_plugin_slugs as $slug) {
                $plugin = get_plugin_data(WP_PLUGIN_DIR . '/' . $slug);
                $active_plugins[] = $plugin['Name'] . ' v' . $plugin['Version'];
            }

            $multisize = is_multisite() ? 'true' : 'false';

            ?><div class="zoo-theme-welcome">
                <div id="zoo-welcome-panel" class="zoo-welcome-panel">
                    <div class="zoo-welcome-panel-content">
                        <div class="zoo-welcome-heading">
                        	<h1><?php printf(esc_html__( 'Welcome to %s', 'fona' ), $this->theme->name); ?></h1>
                        	<p class="description"><?php printf(esc_html__( 'Thank you for choosing %s.', 'fona'), $this->theme->name); ?></p>
                        </div>
                        <div class="zoo-welcome-theme-logo">
                            <img src="<?php echo esc_url($logo_src) ?>" alt="<?php bloginfo('name'); ?>" width="120" height="auto">
                            <p><strong><?php echo esc_html($this->theme->name) . ' &nbsp;<span>v' . esc_html($this->theme->version) ?></span></strong></p>
                        </div>
                    </div>
            	</div>
                <div class="dashboard-widgets-wrap">
                    <div id="dashboard-widgets" class="metabox-holder">
                        <table class="system-status widefat" cellspacing="0">
                        	<thead>
                        		<tr>
                        			<th colspan="3"><?php esc_html_e('System Status', 'fona') ?></th>
                        		</tr>
                        	</thead>
                        	<tbody>
                        		<tr>
                        			<td>Server:</td>
                        			<td><?php echo esc_html($_SERVER['SERVER_SOFTWARE']) ?></td>
                        		</tr>
                                <tr>
                    				<td data-export-label="MySQL Version">MySQL version:</td>
                    				<td><?php echo esc_html($wpdb->db_version()) ?></td>
                    			</tr>
                        		<tr>
                        			<td>PHP version:</td>
                        			<td><?php echo phpversion() ?></td>
                        		</tr>
                        		<tr>
                    				<td>PHP post max size:</td>
                    				<td><?php echo ini_get('post_max_size') ?></td>
                    			</tr>
                    			<tr>
                    				<td>PHP max execution time:</td>
                    				<td><?php echo ini_get('max_execution_time') ?></td>
                    			</tr>
                    			<tr>
                    				<td>PHP max input vars:</td>
                    				<td><?php echo ini_get('max_input_vars') ?></td>
                    			</tr>
                                <tr>
                        			<td>PHP max upload size:</td>
                        			<td><?php echo ini_get('upload_max_filesize') ?></td>
                        		</tr>
                    			<tr>
                    				<td>WordPress version:</td>
                    				<td><?php echo esc_html($GLOBALS['wp_version']) ?></td>
                    			</tr>
                    			<tr>
                    				<td>WordPress multisite:</td>
                    				<td><?php echo esc_html($multisize) ?></td>
                    			</tr>
                                <tr>
                        			<td>WordPress debug mode:</td>
                        			<td><?php echo esc_html($wp_debug_mode) ?></td>
                        		</tr>
                                <tr>
                        			<td>WordPress active plugins:</td>
                        			<td><?php echo implode(', ', $active_plugins) ?></td>
                        		</tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><?php
        }
    }
    ZooThemeWelcomePage::getInstance();
}

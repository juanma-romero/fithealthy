<?php
if (!class_exists('ZooThemeSettingsPage', false)) {
    /**
     * ZooThemeSettingsPage
     */
    class ZooThemeSettingsPage
    {
        /**
         * Option name
         */
        const NAME = 'zoo_theme_settings';

        /**
         * Slug
         */
        const SLUG = 'zoo-theme-settings';

        /**
         * Option group
         *
         * @var  string
         */
        const GROUP = 'zoo_theme_settings_group';

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
                add_action('admin_init', array($instance, '_register'), 10, 0);
                add_action('admin_notices', array($instance, '_notify'), 10, 0);
            }
        }

        /**
         * Add to admin menu
         */
        function _add($context = '')
        {
            if (!function_exists('zoo_base69_encode')) {
                return;
            }
            
            $this->hook_suffix = zoo_add_sub_menu_page(
                ZooThemeWelcomePage::SLUG,
                esc_html__('Theme Settings', 'fona'),
                esc_html__('Theme Settings', 'fona'),
                'manage_options',
                self::SLUG,
                array($this, '_render')
            );
        }

        /**
         * Register setting
         */
        function _register()
        {
            register_setting(self::GROUP, self::NAME, array($this, '_sanitize'));
        }

        /**
         * Render
         */
        function _render()
        {
            $logo = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
            $logo_src = !empty($logo) ? $logo[0] : admin_url('images/w-logo-blue.png');

            ?>
            <div class="zoo-theme-settings">
                <div class="nav-bar">
                    <div class="theme-logo">
                        <img src="<?php echo esc_url($logo_src) ?>" alt="<?php bloginfo('name'); ?>" width="90" height="auto">
                        <p><strong><?php echo esc_html($this->theme->name) . ' &nbsp;<span>v' . esc_html($this->theme->version) ?></span></strong></p>
                    </div>
                    <ul>
                        <li><a class="nav-item active-item" href="#global-settings"><?php esc_html_e('General', 'fona') ?></a></li>
                        <li><a class="nav-item" href="#media-settings"><?php esc_html_e('Media', 'fona') ?></a></li>
                        <li><a class="nav-item" href="#apis-settings"><?php esc_html_e('3rd APIs', 'fona') ?></a></li>
                        <li><a class="nav-item" href="#import-export"><?php esc_html_e('Import/Export', 'fona') ?></a></li>
                    </ul>
                </div>
                <div class="content-tabs">
                    <form class="form-table" action="options.php" method="post">
                        <?php settings_fields(self::GROUP) ?>
                        <table id="global-settings" class="tab-table active-tab">
                            <caption><?php esc_html_e('General', 'fona') ?></caption>
                            <tr>
                                <th scope="row"><?php esc_html_e('Header scripts', 'fona') ?></th>
                                <td><p><textarea name="<?php echo esc_attr($this->getName('header_scripts')) ?>" rows="6" cols="80"><?php echo wp_unslash($this->getValue('header_scripts')) ?></textarea></p><p class="description"><?php esc_html_e('Add custom scripts inside HEAD tag. You need to have SCRIPT tag around the scripts.', 'fona') ?></p></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Footer scripts', 'fona') ?></th>
                                <td><p><textarea name="<?php echo esc_attr($this->getName('footer_scripts')) ?>" rows="6" cols="80"><?php echo wp_unslash($this->getValue('footer_scripts')) ?></textarea></p><p class="description"><?php esc_html_e('Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.', 'fona') ?></p></td>
                            </tr>
                            <?php do_settings_fields(self::GROUP, 'global') ?>
                        </table>
                        <table id="media-settings" class="tab-table" style="display:none">
                            <caption><?php esc_html_e('Media', 'fona') ?></caption>
                            <tr>
                                <th scope="row"><?php esc_html_e('Enable adaptive images', 'fona') ?></th>
                                <td><label><input id="enable-adaptive-images-checkbox" type="checkbox" name="<?php echo esc_attr($this->getName('enable_adaptive_images')) ?>" value="1" <?php checked($this->getValue('enable_adaptive_images')) ?>><span class="description"><?php esc_html_e('Whether to enable adaptive images or not.', 'fona') ?></span></label></td>
                            </tr>
                            <tr id="adaptive-image-sizes-row">
                                <th scope="row"><?php esc_html_e('Adaptive image sizes', 'fona') ?></th>
                                <td><input type="text" name="<?php echo esc_attr($this->getName('adaptive_image_sizes')) ?>" value="<?php echo esc_attr($this->getValue('adaptive_image_sizes')) ?>"><p class="description"><?php esc_html_e('Comma-separated sizes which make images look good on modern devices&#8217; screen.', 'fona') ?></p></td>
                            </tr>
                            <?php do_settings_fields(self::GROUP, 'media') ?>
                        </table>
                        <table id="apis-settings" class="tab-table" style="display:none">
                            <caption><?php esc_html_e('Third-Party APIs', 'fona') ?></caption>
                            <tr>
                                <th rowspan="scope"><?php esc_html_e('Google map API key', 'fona') ?></th>
                                <td>
                                    <input type="text" name="<?php echo esc_attr($this->getName('google_map_api')) ?>" value="<?php echo esc_attr($this->getValue('google_map_api')) ?>">
                                    <p class="description"><?php echo sprintf(esc_html__('Enter your Google Map API key to enable maps. You can generate one at: %sGoogle Map API%s.', 'fona'), '<a href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key">', '</a>'); ?></p>
                                </td>
                            </tr>
                            <?php do_settings_fields(self::GROUP, 'apis') ?>
                        </table>
                        <table id="import-export" class="tab-table" style="display:none">
                            <caption><?php esc_html_e('Import/Export', 'fona') ?></caption>
                            <tr>
                                <th scope="row"><?php esc_html_e('Import', 'fona') ?></th>
                                <td>
                                    <p class="description"><?php esc_html_e('Paste encoded settings saved from the "Export" box and click on the "Save Changes" to import.', 'fona') ?></p>
                                    <textarea name="<?php echo esc_attr($this->getName('import_settings')) ?>" rows="8" cols="80"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Export', 'fona') ?></th>
                                <td>
                                    <p class="description"><?php esc_html_e('Copy the below JSON encoded settings and save it somewhere to import later.', 'fona') ?></p>
                                    <textarea rows="8" cols="80"><?php echo zoo_base69_encode(serialize($this->settings)) ?></textarea>
                                </td>
                            </tr>
                            <?php do_settings_fields(self::GROUP, 'import/export') ?>
                        </table>
                        <?php do_settings_sections(self::GROUP); submit_button() ?>
                    </form>
                </div>
            </div>
            <?php
        }

        /**
         * Sanitize
         */
        function _sanitize($settings)
        {
            if (!empty($settings['import_settings']) && function_exists('zoo_base69_decode')) {
                $_settings = unserialize(zoo_base69_decode($settings['import_settings']));
                if (is_array($_settings)) {
                    $this->importSettings($_settings);
                }
            }

            unset($settings['import_settings']);

            $settings['google_map_api'] = isset($settings['google_map_api']) ? sanitize_key($settings['google_map_api']) : '';
            $settings['adaptive_image_sizes'] = isset($settings['adaptive_image_sizes']) ? preg_replace('/\s+/', '', $settings['adaptive_image_sizes']) : '258,516,720,1032,1440,2064,2880';

            return $settings;
        }

        /**
         * Do notification
         */
        function _notify()
        {
            if ($GLOBALS['page_hook'] !== $this->hook_suffix) {
                return;
            }

            if (isset($_REQUEST['settings-updated']) && 'true' === $_REQUEST['settings-updated']) {
                echo '<div class="updated notice is-dismissible"><p><strong>' . esc_html__('Settings have been saved successfully!', 'fona') . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' . esc_html__('Dismiss this notice.', 'fona') . '</span></div>';
            }

            if (isset($_REQUEST['error']) && 'true' === $_REQUEST['error']) {
                echo '<div class="updated error is-dismissible"><p><strong>' . esc_html__('Failed to save settings. Please try again!', 'fona') . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' . esc_html__('Dismiss this notice.', 'fona') . '</span></div>';
            }
        }

        /**
         * Import settings
         */
        function importSettings(array $settings)
        {
            $updated = update_option(self::NAME, $settings, true);

            if (!$updated) {
                if (defined('DOING_AJAX') && DOING_AJAX) {
                    wp_send_json_error();
                } else {
                    wp_redirect( add_query_arg( 'error', 'true',  wp_get_referer() ) );
                    exit;
                }
            } else {
                if (defined('DOING_AJAX') && DOING_AJAX) {
                    wp_send_json_success();
                } else {
                    wp_redirect( add_query_arg( 'settings-updated', 'true',  wp_get_referer() ) );
                    exit;
                }
            }
        }

        /**
         * Get name
         *
         * @param  string  $field  Key name.
         *
         * @return  string
         */
        private function getName($key)
        {
            return self::NAME . '[' . $key . ']';
        }

        /**
         * Get value
         *
         * @param  string  $key  Key name.
         *
         * @return  mixed
         */
        private function getValue($key)
        {
            return isset($this->settings[$key]) ? $this->settings[$key] : '';
        }
    }
    ZooThemeSettingsPage::getInstance();
}

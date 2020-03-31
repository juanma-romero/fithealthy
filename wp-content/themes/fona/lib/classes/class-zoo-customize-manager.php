<?php
if (!class_exists('ZooCustomizeManager')) :
    /**
     * ZooCustomizeManager
     */
    class ZooCustomizeManager
    {
        /**
         * Theme mods
         *
         * @var    array
         */
        protected $mods;
        /**
         * WP_Customize_Manager
         */
        protected $wp_customize;
        /**
         * Constructor
         */
        private function __construct()
        {
            $this->mods = get_theme_mods();
        }
        /**
         * Singleton
         */
        static function getInstance()
        {
            static $instance = null;
            if (null === $instance) {
                $instance = new self;
                add_action( 'init', array( $instance, '_register' ) );
                add_action( 'wp_ajax_customize_reset', array( $instance, '_ajaxReset' ), 10, 0 );
                add_action( 'customize_register', array( $instance, 'afterLoadCustomizeRegister' ) );
            }
        }
        /**
         * Add a panel
         *
         * @param    string    $id      Panel's ID.
         * @param    array     $args    Panel's arguments.
         */
        function add_panel($id, array $args)
        {
            Kirki::add_panel($id, $args);
        }
        /**
         * Add a section
         *
         * @param    string    $id      Section's ID.
         * @param    array     $args    Section's arguments.
         */
        function add_section($id, array $args)
        {
            Kirki::add_section($id, $args);
        }
        /**
         * Add a field
         *
         * @param    string    $id      Field's ID.
         * @param    array     $args    Field's arguments.
         */
        function add_field($id, array $args)
        {
            Kirki::add_field($id, $args);
        }
        /**
         * Add a config
         *
         * @param    string    $id      Config's ID.
         * @param    array     $args    Config's arguments.
         */
        function add_config($id, array $args)
        {
            Kirki::add_config($id, $args);
        }
        /**
         * Define option for kirki when wp init
         */
        function _register()
        {
            $transport = 'refresh';
            $this->add_config( 'fona', array(
                'option_type' => 'theme_mod',
                'capability'  => 'edit_theme_options'
            ) );
            require ZOO_THEME_DIR . 'lib/options/reset.php';
            do_action( 'zoo_before_customize_register', $this, $this->mods );
        }
        /**
         * Register
         *
         * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
         *
         * @see    https://developer.wordpress.org/reference/hooks/customize_register/
         */
        function afterLoadCustomizeRegister(WP_Customize_Manager $wp_customize)
        {
            $wp_customize->remove_section('colors');
            $wp_customize->remove_control('colors');
            $wp_customize->remove_section('background_image');
            $this->wp_customize = $wp_customize;
            require ZOO_THEME_DIR . 'lib/options/import-export.php';
            do_action( 'zoo_after_customize_register', $this, $this->mods );
        }
        /**
         * Export
         */
        protected function export()
        {
            if (!wp_verify_nonce($_REQUEST['zoo-customize-export'], 'cust0miz3r-n0nc3')) {
                return;
            }
            $charset = get_option('blog_charset');
            $data	 = array(
                'mods'	  => $this->mods ? array_filter($this->mods) : array(),
                'options' => array()
            );
            $settings = $this->wp_customize->settings();
            foreach ($settings as $key => $setting) {
                if ('option' === $setting->type) {
                    if (false !== strpos($key, 'widget_')) {
                        continue;
                    }
                    if (false !== strpos($key, 'sidebars_')) {
                        continue;
                    }
                    if (in_array($key, array('blogname', 'blogdescription', 'show_on_front', 'page_on_front', 'page_for_posts'))) {
                        continue;
                    }
                    $data['options'][$key] = $setting->value();
                }
            }
            header('Content-disposition: attachment; filename=customizer.dat');
            header('Content-Type: application/octet-stream; charset=' . $charset);
            exit(json_encode($data));
        }
        /**
         * Import
         */
        protected function import()
        {
            if (!wp_verify_nonce($_REQUEST['customize-import-nonce'], 'z00-th3m3-0pti0ns-imp0rt-3xp0rt')) {
                return;
            }
            if (empty($_FILES['zoo-customize-import-file']['tmp_name']) || !empty($_FILES['zoo-customize-import-file']['error'])) {
                return;
            }
            if (!function_exists('WP_Filesystem')) {
                require ABSPATH . 'wp-admin/includes/file.php';
            }
            global $wp_filesystem;
            WP_Filesystem();
            $raw  = $wp_filesystem->get_contents($_FILES['zoo-customize-import-file']['tmp_name']);
            $data = json_decode($raw, true);
            if (isset($_POST['zoo-customize-import-attachment'])) {
                $data['mods'] = $this->importCustomizeAttachment($data['mods']);
            }
            if (!empty($data['options'])) {
                foreach ($data['options'] as $option_key => $option_value) {
                    $option = new ZooCustomizeSetting($this->wp_customize, $option_key, array(
                        'default'	 => '',
                        'type'		 => 'option',
                        'capability' => 'edit_theme_options'
                    ));
                    $option->import($option_value);
                }
            }
            do_action('customize_save', $this->wp_customize);
            if (!empty($data['mods'])) {
                foreach ($data['mods'] as $key => $val) {
                    do_action('customize_save_' . $key, $this->wp_customize);
                    set_theme_mod($key, $val);
                }
            }
            do_action('customize_save_after', $this->wp_customize);
            $customize_uri = add_query_arg( 'return', urlencode( wp_unslash( filter_input(INPUT_SERVER, 'REQUEST_URI') ) ), 'customize.php' );
            wp_redirect(admin_url($customize_uri));
            exit;
        }
        /**
         * AJAX reset options
         *
         * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
         */
        function _ajaxReset()
        {
            if (!$this->wp_customize->is_preview()) {
                wp_send_json(array(
                    'success' => false,
                    'message' => esc_html__('Not previewing', 'fona')
                ));
            }
            if ( !check_ajax_referer('cust0miz3r-n0nc3', 'nonce', false)) {
                wp_send_json(array('success' => false, 'message' => esc_html__('Cheating?', 'fona')));
            }
            $options = $this->wp_customize->settings();
            foreach ($options as $option) {
                if ('theme_mod' === $option->type) {
                    remove_theme_mod($option->id);
                }
            }
            wp_send_json(array('success' => true, 'message' => esc_html__('Customize data reset successfully!', 'fona')));
        }
        /**
         * Import attachment
         */
        protected function importCustomizeAttachment($mods)
        {
            foreach ($mods as $key => $mod) {
                $data = $this->sideLoadCustomizeImage((string)$mod);
                if (!is_wp_error($data)) {
                    $mods[$key] = $data->url;
                    if (isset($mods[$key . '_data'])) {
                        $mods[$key . '_data'] = $data;
                        update_post_meta($data->attachment_id, '_wp_attachment_is_custom_header', get_stylesheet());
                    }
                }
            }
            return $mods;
        }
        /**
         * Sideload customizer image
         *
         * @author  ProteusThemes
         */
        protected function sideLoadCustomizeImage($file)
        {
            if (!preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches)) {
                return new WP_Error('_invalid_attachment', esc_html__('Invalid attachment!', 'fona'));
            }
            $data = new \stdClass();
            if (!function_exists('media_handle_sideload')) {
                require ABSPATH . 'wp-admin/includes/media.php';
                require ABSPATH . 'wp-admin/includes/file.php';
                require ABSPATH . 'wp-admin/includes/image.php';
            }
            if ( !empty($file) ) {
                $file_array = array();
                $file_array['name'] = basename($matches[0]);
                $file_array['tmp_name'] = download_url($file);
                if (is_wp_error($file_array['tmp_name'])) {
                    return $file_array['tmp_name'];
                }
                $id = media_handle_sideload($file_array, 0);
                if (is_wp_error($id)) {
                    unlink($file_array['tmp_name']);
                    return $id;
                }
                $meta                = wp_get_attachment_metadata($id);
                $data->attachment_id = $id;
                $data->url           = wp_get_attachment_url($id);
                $data->thumbnail_url = wp_get_attachment_thumb_url($id);
                $data->height        = $meta['height'];
                $data->width         = $meta['width'];
            }
            return $data;
        }
    }
    ZooCustomizeManager::getInstance();
endif;
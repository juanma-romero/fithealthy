<?php
/**
 * Zoo Social Widget
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */

if (!class_exists('ZooSocialWidget')) {
    class ZooSocialWidget extends WP_Widget
    {
        public $socials = array(
            'ion-social-facebook' => array(
                'title' => 'Facebook',
                'name' => 'facebook_username',
                'link' => '*',
                'icon' => 'clever-icon-facebook',
            ),
            'ion-social-googleplus' => array(
                'title' => 'Googleplus',
                'name' => 'googleplus_username',
                'link' => '*',
                'icon' => 'clever-icon-googleplus',
            ),
            'ion-social-twitter' => array(
                'title' => 'Twitter',
                'name' => 'Twitter_username',
                'link' => '*',
                'icon' => ' clever-icon-twitter',
            ),
            'ion-social-instagram' => array(
                'title' => 'Instagram',
                'name' => 'instagram_username',
                'link' => '*',
                'icon' => 'clever-icon-instagram',
            ),
            'ion-social-pinterest' => array(
                'title' => 'Pinterest',
                'name' => 'pinterest_username',
                'link' => '*',
                'icon' => 'clever-icon-pinterest',
            ),
            'ion-social-skype' => array(
                'title' => 'Skype',
                'name' => 'skype_username',
                'link' => 'skype:*',
                'icon' => 'clever-icon-skype',
            ),
            'ion-social-vimeo' => array(
                'title' => 'Vimeo',
                'name' => 'vimeo_username',
                'link' => '*',
                'icon' => 'clever-icon-vimeo',
            ),
            'ion-social-youtube' => array(
                'title' => 'Youtube',
                'name' => 'youtube_username',
                'link' => '*',
                'icon' => ' clever-icon-youtube-1',
            ),
            'ion-social-rss' => array(
                'title' => 'Rss',
                'name' => 'rss',
                'link' => '*',
                'icon' => ' clever-icon-rss',
            ),
        );

        function __construct()
        {
            $widget_ops = array('classname' => 'ZooSocialWidget', 'description' => esc_html__('Displays your social profile.', 'fona'));

            parent::__construct(false, esc_html__('Zoo: Social profile', 'fona'), $widget_ops);
        }

        function widget($args, $instance)
        {
            extract($args);
            $title = apply_filters('widget_title', $instance['title']);
            echo htmlspecialchars_decode(esc_html($before_widget));
            if ($title) {
                echo htmlspecialchars_decode(esc_html($before_title . $title . $after_title));
            }
            echo '<ul class="zoo-widget-social-icon ' . esc_attr($instance['mode']) . ' clearfix">';
            foreach ($this->socials as $key => $social) {
                if (!empty($instance[$social['name']])) {
                    ?>
                    <li><a href="<?php echo str_replace('*', esc_attr($instance[$social['name']]), $social['link']) ?>" target="_blank" title="<?php echo esc_attr($social['title'])?>" class="<?php echo esc_attr($key . ' social-icon')?>"><?php
                    if ($instance['mode'] == 'icon' || $instance['mode'] == 'both') {
                        echo '<i class="cs-font ' . esc_attr($social['icon']) . '"></i>';
                    }
                    if ($instance['mode'] == 'text' || $instance['mode'] == 'both') {
                        echo esc_html($social['title']);
                    }
                    ?>
                        </a></li><?php
                }
            }
            echo '</ul>';
            echo htmlspecialchars_decode(esc_html($after_widget));
        }

        function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance = $new_instance;
            /* Strip tags (if needed) and update the widget settings. */
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['mode'] = $new_instance['mode'];
            return $instance;
        }

        function form($instance)
        {
            if (!isset($instance['mode'])) {
                $instance['mode'] = 'text';
            }
            ?>
            <p>
                <label
                    for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_html__('Title', 'fona'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" type="text"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                       value="<?php echo isset($instance['title']) ? esc_attr($instance['title']) : ''; ?>"/>
            </p>
            <p>
                <label
                    for="<?php echo esc_attr($this->get_field_id('mode')); ?>"><?php echo esc_html__('Display', 'fona'); ?></label>
                <select id="<?php echo esc_attr($this->get_field_id('mode')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('mode')); ?>" style="width:100%;">
                    <option
                        value='text' <?php if ('text' == $instance['mode'] || $instance['mode'] == '') echo 'selected="selected"'; ?>><?php echo esc_html__('Only Text', 'fona'); ?></option>
                    <option
                        value='icon' <?php if ('icon' == $instance['mode']) echo 'selected="selected"'; ?>><?php echo esc_html__('Only Icon', 'fona'); ?></option>
                    <option
                        value='both' <?php if ('both' == $instance['mode']) echo 'selected="selected"'; ?>><?php echo esc_html__('Both Text and Icon', 'fona'); ?></option>
                </select>
            </p> <?php
            foreach ($this->socials as $key => $social) {
                ?>
                <p>
                <label
                    for="<?php echo esc_attr($this->get_field_id($social['name'])); ?>"><?php echo esc_html($social['title']); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id($social['name'])); ?>" type="text"
                       name="<?php echo esc_attr($this->get_field_name($social['name'])); ?>"
                       value="<?php echo isset($instance[$social['name']]) ? esc_attr($instance[$social['name']]) : ''; ?>"/>
                </p><?php
            }
        }
    }
}

add_action('widgets_init', 'zoo_social_load_widgets');

function zoo_social_load_widgets()
{
    register_widget('ZooSocialWidget');
}
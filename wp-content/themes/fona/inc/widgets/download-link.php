<?php
/**
 * Plugin Name: Download block link
 */

add_action('widgets_init', 'zoo_theme_download_block_widget');

function zoo_theme_download_block_widget()
{
    register_widget('zoo_theme_download_block_widget');
}

class zoo_theme_download_block_widget extends WP_Widget
{

    /**
     * Widget setup.
     */
    function __construct()
    {
        /* Widget settings. */
        $widget_ops = array('classname' => 'zoo_theme_download_block_widget', 'description' => esc_html__('A widget button for download file', 'fona'));

        /* Widget control settings. */
        $control_ops = array('width' => 250, 'height' => 350, 'id_base' => 'zoo_theme_download_block_widget', 'public' => true);

        /* Create the widget. */
        parent::__construct('zoo_theme_download_block_widget', esc_html__('Zoo: Download block', 'fona'), $widget_ops, $control_ops);
    }

    /**
     * How to display the widget on the screen.
     */
    function widget($args, $instance)
    {
        extract($args);
        echo ent2ncr($before_widget);
        /* Our variables from the widget settings. */
        $text_link = $instance['text_link'] != '' ? $instance['text_link'] : esc_html__('Download', 'fona');
        $font_icon = $instance['icon'] != '' ? $instance['icon'] :'fa fa-cloud-download';
        $link = $instance['link'] != '' ? $instance['link'] : '#'; ?>
        <div class="zoo_download_block">
            <a class="text-download" href="<?php echo esc_url($link) ?>"
               title="<?php echo esc_attr($text_link) ?>" target="_blank" download>
                <i class="<?php echo esc_attr($font_icon)?>"></i>
                <?php echo esc_html($text_link) ?>
            </a>
        </div>
        <?php
        echo ent2ncr($after_widget);
    }

    /**
     * Update the widget settings.
     */
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['text_link'] = strip_tags($new_instance['text_link']);
        $instance['link'] = $new_instance['link'];
        $instance['icon'] = $new_instance['icon'];

        return $instance;
    }


    function form($instance)
    {

        /* Set up some default widget settings. */
        $defaults = array('text_link' => esc_html__('Download', 'fona'), 'link' => '#', 'icon' => 'fa fa-cloud-download');
        $instance = wp_parse_args((array)$instance, $defaults); ?>

        <p>
            <label
                    for="<?php echo esc_attr($this->get_field_id('icon')); ?>"><?php esc_html_e('Class font icon:', 'fona'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('icon')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('icon')); ?>"
                   value="<?php echo esc_attr($instance['icon']); ?>"/>
        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('text_link')); ?>"><?php esc_html(esc_html_e('Text link:', 'fona')); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('text_link')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('text_link')); ?>"
                   value="<?php echo esc_attr($instance['text_link']); ?>"/>
        </p>
        <!-- Number of posts -->
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('link')); ?>"><?php esc_html_e('Link of file:', 'fona'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('link')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('link')); ?>"
                   value="<?php echo esc_attr($instance['link']); ?>"/>
        </p>
        <?php
    }
}

?>
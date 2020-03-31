<?php
/**
 * Zoo List Services
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */
if( is_plugin_active('clever-vc-addon/clever-vc-addon.php')) {
    add_action('widgets_init', 'zoo_list_services_widget');

    function zoo_list_services_widget()
    {
        register_widget('zoo_list_services');
    }

    class zoo_list_services extends WP_Widget
    {

        /**
         * Widget setup.
         */
        function __construct()
        {
            /* Widget settings. */
            $widget_ops = array('classname' => 'zoo_list_services', 'description' => esc_html__('A widget that all services', 'fona'));

            /* Widget control settings. */
            $control_ops = array('width' => 250, 'height' => 350, 'id_base' => 'zoo_list_services');

            /* Create the widget. */
            parent::__construct('zoo_list_services', esc_html__('Zoo: List services for Sidebar', 'fona'), $widget_ops, $control_ops);
        }

        /**
         * How to display the widget on the screen.
         */
        function widget($args, $instance)
        {
            extract($args);

            /* Our variables from the widget settings. */
            $title = apply_filters('widget_title', $instance['title']);
            $number = $instance['number'];
            $orderby = $instance['orderby'];
            $order = $instance['order'];


            $query = array('post_type' => 'service', 'showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'orderby' => $orderby, 'order' => $order);

            $loop = new WP_Query($query);
            if ($loop->have_posts()) :

                /* Before widget (defined by themes). */
                echo ent2ncr($before_widget);
                /* Display the widget title if one was input (before and after defined by themes). */
                if ($title)
                    echo ent2ncr($before_title) . esc_html($title) . ent2ncr($after_title);
                ?>
                <ul class="zoo-list-services">

                <?php while ($loop->have_posts()) : $loop->the_post(); ?>

                <li class="service-item">
                    <a href="<?php echo esc_url(get_permalink()); ?>" rel="<?php echo esc_attr('bookmark'); ?>"
                       title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </li>

            <?php endwhile;
                wp_reset_postdata(); endif; ?>

            </ul>

            <?php

            /* After widget (defined by themes). */
            echo ent2ncr($after_widget);
        }

        /**
         * Update the widget settings.
         */
        function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            /* Strip tags for title and name to remove HTML (important for text inputs). */
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['number'] = strip_tags($new_instance['number']);
            $instance['orderby'] = $new_instance['orderby'];
            $instance['order'] = $new_instance['order'];
            return $instance;
        }


        function form($instance)
        {

            /* Set up some default widget settings. */
            $defaults = array('title' => esc_html__('Our Services', 'fona'), 'number' => 5, 'orderby' => 'date', 'order' => 'DESC');
            $instance = wp_parse_args((array)$instance, $defaults); ?>

            <!-- Widget Title: Text Input -->
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'fona'); ?></label>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                       value="<?php echo esc_attr($instance['title']); ?>"/>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('orderby')); ?>"><?php echo esc_html(__('Order by:', 'fona')); ?></label>
                <select id="<?php echo esc_attr($this->get_field_id('orderby')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('orderby')); ?>" class="widefat orderby"
                        style="width:100%;">
                    <option value='date' <?php if ('date' == $instance['orderby']) echo 'selected="selected"'; ?>><?php echo esc_html(__('Date', 'fona')); ?></option>
                    <option value='date' <?php if ('author' == $instance['orderby']) echo 'selected="selected"'; ?>><?php echo esc_html(__('Author', 'fona')); ?></option>
                    <option value='date' <?php if ('title' == $instance['orderby']) echo 'selected="selected"'; ?>><?php echo esc_html__('Title', 'fona'); ?></option>
                    <option value='date' <?php if ('name' == $instance['orderby']) echo 'selected="selected"'; ?>><?php echo esc_html__('Name', 'fona'); ?></option>
                    <option value='date' <?php if ('comment_count' == $instance['orderby']) echo 'selected="selected"'; ?>><?php echo esc_html__('Comment Count', 'fona'); ?></option>
                    <option value='date' <?php if ('rand' == $instance['orderby']) echo 'selected="selected"'; ?>><?php echo esc_html__('Random', 'fona'); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('order')); ?>"><?php echo esc_html(__('Order:', 'fona')); ?></label>
                <select id="<?php echo esc_attr($this->get_field_id('order')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('order')); ?>" class="widefat orderby"
                        style="width:100%;">
                    <option value='date' <?php if ('DESC' == $instance['order']) echo 'selected="selected"'; ?>><?php echo esc_html(__('DESC', 'fona')); ?></option>
                    <option value='date' <?php if ('ASC' == $instance['order']) echo 'selected="selected"'; ?>><?php echo esc_html(__('ASC', 'fona')); ?></option>
                </select>
            </p>
            <!-- Number of posts -->
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of posts to show:', 'fona'); ?></label>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('number')); ?>"
                       value="<?php echo esc_attr($instance['number']); ?>" size="3"/>
            </p>


            <?php
        }
    }
}
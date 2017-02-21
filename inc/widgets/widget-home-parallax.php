<?php

/**
 * Homepage parralax section Widget
 * Shapely Theme
 */
class shapely_home_parallax extends WP_Widget
{
    function __construct()
    {
        add_action('admin_init', array($this, 'enqueue'));
        add_action('customize_controls_enqueue_scripts', array($this, 'enqueue'));
        add_action('customize_preview_init', array($this, 'enqueue'));


        $widget_ops = array(
            'classname' => 'shapely_home_parallax',
            'description' => esc_html__("Shapely FrontPage Parallax Section", 'shapely'),
            'customize_selective_refresh' => true
        );
        parent::__construct('shapely_home_parallax', esc_html__('[Shapely] Parralax Section For FrontPage', 'shapely'), $widget_ops);
    }

    public function enqueue()
    {
        wp_enqueue_style('epsilon-styles', plugins_url('epsilon-framework/assets/css/style.css', dirname(__FILE__)));
        wp_enqueue_script('epsilon-object', plugins_url('epsilon-framework/assets/js/epsilon.js', dirname(__FILE__)), array('jquery'));
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = isset($instance['title']) ? $instance['title'] : '';
        $image_src = isset($instance['image_src']) ? $instance['image_src'] : '';
        $image_pos = isset($instance['image_pos']) ? $instance['image_pos'] : esc_html__('left', 'shapely');
        $body_content = isset($instance['body_content']) ? $instance['body_content'] : '';
        $button1 = isset($instance['button1']) ? $instance['button1'] : '';
        $button2 = isset($instance['button2']) ? $instance['button2'] : '';
        $button1_link = isset($instance['button1_link']) ? $instance['button1_link'] : '';
        $button2_link = isset($instance['button2_link']) ? $instance['button2_link'] : '';
        $border_bottom = isset($instance['border_bottom']) ? $instance['border_bottom'] : '';

        echo $before_widget;

        /* Classes */
        $class1 = ($image_pos == 'background-full') ? 'cover fullscreen image-bg' : (($image_pos == 'background-small') ? 'small-screen image-bg p0' : (($image_pos == 'right') ? 'bg-secondary' : (($image_pos == 'bottom') ? 'bg-secondary pb0' : '')));
        $class2 = (($image_pos == 'background-full') || ($image_pos == 'background-small')) ? 'top-parallax-section' : (($image_pos == 'right') ? 'col-md-4 col-sm-5 mb-xs-24' : (($image_pos == 'left') ? 'col-md-4 col-md-offset-1 col-sm-5 col-sm-offset-1' : (($image_pos == 'bottom') ? 'col-sm-10 col-sm-offset-1 text-center' : (($image_pos == 'top') ? 'col-sm-10 col-sm-offset-1 text-center mt30' : ''))));
        $class3 = (($image_pos == 'background-full') || ($image_pos == 'background-small')) ? 'col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 text-center' : '';
        $class4 = ($image_pos == 'left' || $image_pos == 'right') ? 'row align-children' : 'row';
        $class5 = ($image_pos == 'right') ? 'col-md-7 col-md-offset-1 col-sm-6 col-sm-offset-1 text-center' : '';
        $class6 = ($image_pos == 'left') ? 'col-md-7 col-sm-6 text-center mb-xs-24' : '';
        $class7 = ($image_pos == 'background-full') ? 'fullscreen' : '';

        if ($border_bottom == 'on') {
            $class1 .= ' border-bottom';
        }
        /**
         * Widget Content
         */
        ?>
        <section class="<?php echo esc_attr($class1); ?>"><?php
            if (($image_pos == 'background-full' || $image_pos == 'background-small') && $image_src != '') { ?>
            <div class="parallax-window <?php echo esc_attr($class7); ?>" data-parallax="scroll"
                 data-image-src="<?php echo esc_url($image_src); ?>">
                <div class="<?php echo ($image_pos == 'background-full') ? 'align-transform' : ''; ?>">
                    <?php } else { ?>
                    <div class="container">
                        <?php } ?>

                        <div class="<?php echo esc_attr($class4); ?>">

                            <?php
                            if (($image_pos == 'left' || $image_pos == 'top') && $image_src != '') { ?>
                            <div class="<?php echo esc_attr($class6); ?>">
                                <img class="cast-shadow img-responsive" alt="<?php echo esc_attr($title); ?>"
                                     src="<?php echo esc_url($image_src); ?>">
                                </div><?php
                            } ?>

                            <div class="<?php echo esc_attr($class2); ?>">
                                <div class="<?php echo esc_attr($class3); ?>"><?php
                                    echo ($title != '') ? (($image_pos == 'background-full') || ($image_pos == 'background-small')) ? '<h1>' . wp_kses_post($title) . '</h1>' : '<h3>' . wp_kses_post($title) . '</h3>' : '';
                                    echo ($body_content != '') ? '<p class="mb32">' . wp_kses_post($body_content) . '</p>' : '';
                                    echo ($button2 != '' && $button2_link != '') ? '<a class="btn btn-lg btn-white" href="' . esc_url($button2_link) . '">' . wp_kses_post($button2) . '</a>' : '';
                                    echo ($button1 != '' && $button1_link != '') ? '<a class="btn btn-lg btn-filled" href="' . esc_url($button1_link) . '">' . wp_kses_post($button1) . '</a>' : ''; ?>
                                </div>
                            </div>
                            <!--end of row-->
                            <?php
                            if (($image_pos == 'right' || $image_pos == 'bottom') && $image_src != '') { ?>
                            <div class="<?php echo esc_attr($class5); ?>">
                                <img class="cast-shadow img-responsive" alt="<?php echo esc_attr($title); ?>"
                                     src="<?php echo esc_url($image_src); ?>">
                                </div><?php
                            } ?>
                        </div>
                    </div>
                    <?php if ($image_pos == 'background-full' || $image_pos == 'background-small') { ?>
                </div>
                <?php } ?>
        </section>
        <div class="clearfix"></div>
        <?php

        echo $after_widget;
    }


    function form($instance)
    {
        if (!isset($instance['title'])) {
            $instance['title'] = '';
        }
        if (!isset($instance['image_src'])) {
            $instance['image_src'] = '';
        }
        if (!isset($instance['image_pos'])) {
            $instance['image_pos'] = 'left';
        }
        if (!isset($instance['body_content'])) {
            $instance['body_content'] = '';
        }
        if (!isset($instance['button1'])) {
            $instance['button1'] = '';
        }
        if (!isset($instance['button2'])) {
            $instance['button2'] = '';
        }
        if (!isset($instance['button1_link'])) {
            $instance['button1_link'] = '';
        }
        if (!isset($instance['button2_link'])) {
            $instance['button2_link'] = '';
        }
        if (!isset($instance['border_bottom'])) {
            $instance['border_bottom'] = '';
        }
        ?>

        <p><label
                for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title ', 'shapely') ?></label>

            <input type="text" value="<?php echo esc_attr($instance['title']); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   class="widefat"/>
        </p>

        <p class="shapely-media-control"
           data-delegate-container="<?php echo esc_attr($this->get_field_id('image_src')) ?>">
            <label
                for="<?php echo esc_attr($this->get_field_id('image_src')); ?>"><?php _e('Image', 'shapely');
                ?>:</label>

            <img src="<?php echo esc_url($instance['image_src']); ?>"/>

            <input type="hidden"
                   name="<?php echo esc_attr($this->get_field_name('image_src')); ?>"
                   id="<?php echo esc_attr($this->get_field_id('image_src')); ?>"
                   value="<?php echo esc_url($instance['image_src']); ?>"
                   class="image-id blazersix-media-control-target">

            <button type="button" class="button upload-button"><?php _e('Choose Image', 'shapely'); ?></button>
            <button type="button" class="button remove-button"><?php _e('Remove Image', 'shapely'); ?></button>
        </p>

        <p><label
                for="<?php echo esc_attr($this->get_field_id('body_content')); ?>"><?php esc_html_e('Content ', 'shapely') ?></label>

			<textarea name="<?php echo esc_attr($this->get_field_name('body_content')); ?>"
                      id="<?php echo esc_attr($this->get_field_id('body_content')); ?>"
                      class="widefat"><?php echo esc_attr($instance['body_content']); ?></textarea>
        </p>

        <p><label
                for="<?php echo esc_attr($this->get_field_id('image_pos')); ?>"><?php esc_html_e('Image Position ', 'shapely') ?></label>
            <select name="<?php echo esc_attr($this->get_field_name('image_pos')); ?>"
                    id="<?php echo esc_attr($this->get_field_id('image_pos')); ?>" class="widefat">
                <option
                    value="left" <?php selected($instance['image_pos'], 'left'); ?>><?php _e('Left', 'shapely'); ?></option>
                <option
                    value="right" <?php selected($instance['image_pos'], 'right'); ?>><?php _e('Right', 'shapely'); ?></option>
                <option
                    value="top" <?php selected($instance['image_pos'], 'top'); ?>><?php _e('Top', 'shapely'); ?></option>
                <option
                    value="bottom" <?php selected($instance['image_pos'], 'bottom'); ?>><?php _e('Bottom', 'shapely'); ?></option>
                <option
                    value="background-full" <?php selected($instance['image_pos'], 'background-full'); ?>><?php _e('Background Full', 'shapely'); ?></option>
                <option
                    value="background-small" <?php selected($instance['image_pos'], 'background-small'); ?>><?php _e('Background Small', 'shapely'); ?></option>
            </select>
        </p>

        <p><label
                for="<?php echo esc_attr($this->get_field_id('button1')); ?>"><?php esc_html_e('Button 1 Text ', 'shapely') ?></label>

            <input type="text" value="<?php echo esc_attr($instance['button1']); ?>"
                   name="<?php echo esc_attr($this->get_field_name('button1')); ?>"
                   id="<?php echo esc_attr($this->get_field_id('button1')); ?>"
                   class="widefat"/>
        </p>

        <p><label
                for="<?php echo esc_attr($this->get_field_id('button1_link')); ?>"><?php esc_html_e('Button 1 Link ', 'shapely') ?></label>

            <input type="text" value="<?php echo esc_url($instance['button1_link']); ?>"
                   name="<?php echo esc_attr($this->get_field_name('button1_link')); ?>"
                   id="<?php echo esc_attr($this->get_field_id('button1_link')); ?>"
                   class="widefat"/>
        </p>

        <p><label
                for="<?php echo esc_attr($this->get_field_id('button2')); ?>"><?php esc_html_e('Button 2 Text ', 'shapely') ?></label>

            <input type="text" value="<?php echo esc_attr($instance['button2']); ?>"
                   name="<?php echo esc_attr($this->get_field_name('button2')); ?>"
                   id="<?php echo esc_attr($this->get_field_id('button2')); ?>"
                   class="widefat"/>
        </p>

        <p><label
                for="<?php echo esc_attr($this->get_field_id('button2_link')); ?>"><?php esc_html_e('Button 2 Link ', 'shapely') ?></label>

            <input type="text" value="<?php echo esc_url($instance['button2_link']); ?>"
                   name="<?php echo esc_attr($this->get_field_name('button2_link')); ?>"
                   id="<?php echo esc_attr($this->get_field_id('button2_link')); ?>"
                   class="widefat"/>
        </p>

        <div class="checkbox_switch">
				<span class="customize-control-title onoffswitch_label">
                    <?php _e('Border bottom', 'shapely'); ?>
				</span>
            <div class="onoffswitch">
                <input type="checkbox" id="<?php echo esc_attr($this->get_field_name('border_bottom')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('border_bottom')); ?>"
                       class="onoffswitch-checkbox"
                       value="on"
                    <?php checked($instance['border_bottom'], 'on'); ?>>
                <label class="onoffswitch-label"
                       for="<?php echo esc_attr($this->get_field_name('border_bottom')); ?>"></label>
            </div>
        </div>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? esc_html($new_instance['title']) : '';
        $instance['image_src'] = (!empty($new_instance['image_src'])) ? esc_url_raw($new_instance['image_src']) : '';
        $instance['image_pos'] = (!empty($new_instance['image_pos'])) ? esc_html($new_instance['image_pos']) : '';
        $instance['body_content'] = (!empty($new_instance['body_content'])) ? wp_kses_post($new_instance['body_content']) : '';
        $instance['button1'] = (!empty($new_instance['button1'])) ? wp_kses_post($new_instance['button1']) : '';
        $instance['button2'] = (!empty($new_instance['button2'])) ? wp_kses_post($new_instance['button2']) : '';
        $instance['button1_link'] = (!empty($new_instance['button1_link'])) ? esc_url_raw($new_instance['button1_link']) : '';
        $instance['button2_link'] = (!empty($new_instance['button2_link'])) ? esc_url_raw($new_instance['button2_link']) : '';
        $instance['border_bottom'] = (!empty($new_instance['border_bottom'])) ? esc_html($new_instance['border_bottom']) : '';

        return $instance;
    }
}

?>

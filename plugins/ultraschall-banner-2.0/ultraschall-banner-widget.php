<?php
/*
Plugin Name:  Ultraschall-Banner 2.0
Description:  Use the widget to create an Ultraschall banner in the sidebar of your podcasts.
Plugin URI:   http://ultraschall.fm
Version:      2.0 Update
Author:       Michael McCouman Jr. (Ultraschall.fm)
Author URI:   http://ultraschall.fm
Props:        Michael McCouman Jr.

	The MIT License (MIT)

	Copyright (c) 2017 Ultraschall

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in all
	copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
	SOFTWARE.

License:      MIT
*/


include_once 'inc/handling.php';


/**
 * Adds Ultraschall-Banner widget.
 */
add_action('widgets_init', create_function('', 'return register_widget("ultraschall_banner_i_widget");'));

class ultraschall_banner_i_widget extends WP_Widget
{
    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'Ultraschall_Banner_Widget',      // Base ID
            'Ultraschall Banner 2.0',   // Name
            array(
                'description' => __('Create an Ultraschall Banner for your podcast!', 'text_domain'),
            )
        );
    }

    /**
     * Front-end display of widget.
     * @see WP_Widget::widget()
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $weblink = "http://ultraschall.fm";
        extract($args);

        //args:
        $title = apply_filters('widget_title', $instance['title']);
        $stream = apply_filters('widget_us_banner', $instance['stream']);
        $description = apply_filters('widget_us_banner', $instance['description']);

        echo $before_widget;
        //Start out-----------------------

        //Widget title
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        //Widget banner
        if (!empty($stream)) {
            if ($stream == 'transparent') {
                echo '<a style="color: transparent;box-shadow: none;" target="_blank" title="Ultraschall" href="' . $weblink . '">';
                echo us_banner_transparent();
                echo '</a>';
            } elseif ($stream == 'background') {
                echo '<a style="color: transparent;box-shadow: none;" target="_blank" title="Ultraschall" href="' . $weblink . '">';
                echo us_banner_background();
                echo '</a>';
            } elseif ($stream == 'transparent_light') {
                echo '<a style="color: transparent;box-shadow: none;" target="_blank" title="Ultraschall" href="' . $weblink . '">';
                echo us_banner_transparent_light();
                echo '</a>';
            } elseif ($stream == 'image_400') {
                echo '<a target="_blank" title="Ultraschall" href="' . $weblink . '">';
                echo us_banner_image_400();
                echo '</a>';
            } elseif ($stream == 'image_800') {
                echo '<a target="_blank" title="Ultraschall" href="' . $weblink . '">';
                echo us_banner_image_800();
                echo '</a>';
            } elseif ($stream == 'image_2000') {
                echo '<a target="_blank" title="Ultraschall" href="' . $weblink . '">';
                echo us_banner_image_2000();
                echo '</a>';
            } else {
                echo '<a style="color: transparent;" target="_blank" title="Ultraschall" href="' . $weblink . '">';
                echo us_banner_transparent();
                echo '</a>';
            }
        }

        //Widget description
        if (!empty($description)) {
            echo '<p><small>' . $description . '</small></p>';
        }

        //End out-------------------------
        echo $after_widget;
    }

    /**
     * Back-end widget form.
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {

        //titel widget:
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = '';
        }

        //stream outputs:
        if (isset($instance['stream'])) {
            $stream = $instance['stream'];
        } else {
            $stream = 'background';
        }

        //description:
        if (isset($instance['description'])) {
            $description = $instance['description'];
        } else {
            $description = ''; //no input
        }

        ?>
        <div id="us-widget">
            <center>
                <p>
                    <a href="https://github.com/Ultraschall/Ultraschall-Banner">
                        <?php echo us_banner_transparent(); ?>
                    </a>
                </p>
            </center>


            <?php #################### Label Title
            ?>
            <p>
                <label id="tc" for="<?php echo $this->get_field_name('title'); ?>"><b>Titel:</b></label>
                <input class="widefat itc"
                       id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>"
                       type="text"
                       value="<?php echo esc_attr($title); ?>"/>
                <br>
                <br>

                <?php #################### Label Type (stream out)
                ?>
                <label id="tc" for="<?php echo $this->get_field_name('stream'); ?>"><b>Type:</b></label>
            <div class="inside">
                <select class="ins" id="<?php echo $this->get_field_id('stream'); ?>"
                        name="<?php echo $this->get_field_name('stream'); ?>">
                    <?php
                    // (check) ? (then true) : (then false);
                    echo '<option';
                    echo (esc_attr($stream) == '') ? '
                        value="" selected="selected"> -- Please select -- </option>' : '
                        value=""> -- Please select -- </option>';

                    ##---------

                    //Background
                    echo '<option';
                    echo (esc_attr($stream) == 'background') ? '
                        value="background" selected="selected"> Standard Banner </option>' : '
                        value="background"> Standard Banner </option>';

                    ##---------

                    //Transparent Black
                    echo '<option';
                    echo (esc_attr($stream) == 'transparent') ? '
                        value="transparent" selected="selected"> Light Themes </option>' : '
                        value="transparent"> Light Themes </option>';

                    ##---------

                    //Transparent Light
                    echo '<option';
                    echo (esc_attr($stream) == 'transparent_light') ? '
                        value="transparent_light" selected="selected"> Dark Themes </option>' : '
                        value="transparent_light"> Dark Themes </option>';

                    ##---------

                    //Image 400er
                    echo '<option';
                    echo (esc_attr($stream) == 'image_400') ? '
                        value="image_400" selected="selected"> Image (400 Pixel) </option>' : '
                        value="image_400"> Image (400 Pixel) </option>';

                    ##---------

                    //Image 800er
                    echo '<option';
                    echo (esc_attr($stream) == 'image_800') ? '
                        value="image_800" selected="selected"> Image (800 Pixel) </option>' : '
                        value="image_800"> Image (800 Pixel) </option>';

                    ##---------

                    //Image 2000er
                    echo '<option';
                    echo (esc_attr($stream) == 'image_2000') ? '
                        value="image_2000" selected="selected"> Image (2000 Pixel) </option>' : '
                        value="image_2000"> Image (2000 Pixel) </option>';

                    ?>
                </select>
            </div>

            <br>

            <?php #################### Label Description
            ?>
            <label id="tc" for="<?php echo $this->get_field_name('description'); ?>"><b>Description:</b></label>
            <div class="inside">
                <p>
				<textarea class="ins" style="width: 100%;" id="<?php echo $this->get_field_id('description'); ?>"
                          name="<?php echo $this->get_field_name('description'); ?>"><?php
                    echo esc_attr($description); ?></textarea>
                </p>
            </div>

            <p>You can find more information on <a target="_blank" href="http://ultraschall.fm/">Ultraschall.fm</a>
                or <a target="_blank" href="https://github.com/Ultraschall/Ultraschall-Banner">Github</a>.</p>
        </div>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
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
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['stream'] = (!empty($new_instance['stream'])) ? strip_tags($new_instance['stream']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? strip_tags($new_instance['description']) : '';

        return $instance;
    }
}
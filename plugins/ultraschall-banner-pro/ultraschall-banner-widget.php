<?php
/*
Plugin Name:  Ultraschall-Banner Pro
Description:  Use the widget to create an Ultraschall banner in the sidebar of your podcasts.
Plugin URI:   http://ultraschall.fm
Version:      1.0
Author:       Michael McCouman jr.
Author URI:   http://wikibyte.org/
Props:        Michael McCouman jr.
License:      MIT
*/

include_once 'func.php';


/**
 * Adds Ultraschall-Banner widget.
 */
// register message box widget
add_action( 'widgets_init', create_function( '', 'return register_widget("ultraschall_banner_i_widget");' ) );

class ultraschall_banner_i_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Ultraschall_Banner_Widget',      // Base ID
			'Ultraschall Banner Pro',   // Name
			array(
				'description' => __( 'Create an Ultrachall Banner in the sidebar of your podcasts.', 'text_domain' ),
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
	public function widget( $args, $instance ) {

		extract( $args );

		//args:
		$title       = apply_filters( 'widget_title', $instance['title'] );
		$stream      = apply_filters( 'widget_us_banner', $instance['stream'] );
		$description = apply_filters( 'widget_us_banner', $instance['description'] );
		$color       = apply_filters( 'widget_us_banner', $instance['color'] );

		//Start out-----------------------
		echo $before_widget;

		//Widget title
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		//Stream out
		if ( ! empty( $stream ) ) {
			if ( $stream == 'transparent' ) {
				echo '<a target="_blank" href="http://ultraschall.fm">';
				echo us_banner_transparent();
				echo '</a>';
			} elseif ( $stream == 'background' ) {
				echo '<a target="_blank" href="http://ultraschall.fm">';
				echo us_banner_background();
				echo '</a>';
			} elseif ( $stream == 'color' ) {
				if ( ! empty( $color ) ) {
					$us_color = $color;
					echo '<a target="_blank" href="http://ultraschall.fm">';
					echo us_banner_color( $us_color );
					echo '</a>';
				} else {
					echo us_banner_transparent();
					echo 'ERROR: Coloring hat nicht funktioniert :(';
				}
			} else {
				echo '<a target="_blank" href="http://ultraschall.fm">';
				echo us_banner_transparent();
				echo '</a>';
			}
		}

		if ( ! empty( $description ) ) {
			echo '<p><small>';
			echo $description;
			echo '</small></p>';
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
	public function form( $instance ) {

		//titel widget:
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = '';
		}

		//stream outputs:
		if ( isset( $instance['stream'] ) ) {
			$stream = $instance['stream'];
		} else {
			$stream = 'background';
		}

		//description:
		if ( isset( $instance['description'] ) ) {
			$description = $instance['description'];
		} else {
			$description = ''; //no input
		}

		//color:
		if ( isset( $instance['color'] ) ) {
			$color = $instance['color'];
		} else {
			$color = ''; //no input
		}
		?>

		<center>
			<a href="https://github.com/Ultraschall/Ultraschall-Banner">
				<?php echo us_banner_transparent(); ?>
			</a>
			<a href="https://github.com/Ultraschall/Ultraschall-Banner">Find more information on Github</a>.
		</center>


		<?php #################### Label Title ?>
		<p>
			<label id="tc" for="<?php echo $this->get_field_name( 'title' ); ?>"><b>Titel:</b></label>
			<input class="widefat itc"
			       id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>"
			       type="text"
			       value="<?php echo esc_attr( $title ); ?>"/>
			<br>
			<br>

			<?php #################### Label Type (stream out) ?>
			<label id="tc" for="<?php echo $this->get_field_name( 'stream' ); ?>"><b>Type:</b></label>
		<div class="inside">
			<select class="ins" id="<?php echo $this->get_field_id( 'stream' ); ?>"
			        name="<?php echo $this->get_field_name( 'stream' ); ?>">
				<?php
				// (check) ? (then true) : (then false);
				echo '<option';
				echo ( esc_attr( $stream ) == '' ) ? ' 
	                    value="" selected="selected"> -- Please select -- </option>' : ' 
	                    value=""> -- Please select -- </option>';

				##---------

				//Background
				echo '<option';
				echo ( esc_attr( $stream ) == 'background' ) ? ' 
						value="background" selected="selected"> Ultraschall Banner (Standard) </option>' : ' 
						value="background"> Ultraschall Banner (Standard) </option>';

				##---------

				//Transparent
				echo '<option';
				echo ( esc_attr( $stream ) == 'transparent' ) ? '  
	                    value="transparent" selected="selected"> Ultraschall Banner (Transparent) </option>' : ' 
	                    value="transparent"> Ultraschall Banner (Transparent) </option>';

				##---------

				//Color
				echo '<option';
				echo ( esc_attr( $stream ) == 'color' ) ? ' 
						value="color" selected="selected"> Design US-Logo (Color-Designer) </option>' : ' 
						value="color"> Design US-Logo (Color-Designer) </option>';

				?>
			</select>
		</div>
		<br>


		<?php #################### Label Description ?>
		<label id="tc" for="<?php echo $this->get_field_name( 'description' ); ?>"><b>Description:</b></label>
		<div class="inside">
			<p>
				<textarea class="ins" style="width: 100%;" id="<?php echo $this->get_field_id( 'description' ); ?>"
				          name="<?php echo $this->get_field_name( 'description' ); ?>"><?php
					echo $description; ?></textarea>
			</p>
		</div>


		<?php #################### Label Color ?>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function () {
				// colorpicker field
				jQuery('.cw-color-picker').each(function () {
					var $this = jQuery(this),
						id = $this.attr('rel');
					$this.farbtastic('#' + id);
				});
			});
			//]]>
		</script>
		<style>
			div#colla {
				width: 100% !important;
				cursor: pointer !important;
				border-top: none !important;
				box-shadow: none !important;
				background-image: none !important;
				background: none !important;
			}

			div#wtitle {
				padding: 0 !important;
			}
		</style>
		<div class="widget" id="colla">
			<label id="tc" for="<?php echo $this->get_field_id( 'color' ); ?>"><b>Logo Color-Designer:</b></label>
			<p>Please select the type "Design US-Logo (Color-Designer)" before using.</p>
			<div class="widget-top">
				<div class="widget-title" id="wtitle">
					<h4><input class="widefat init"
					           id="<?php echo $this->get_field_id( 'color' ); ?>"
					           name="<?php echo $this->get_field_name( 'color' ); ?>" type="text"
					           value="<?php if ( $color ) {
						           echo '#' . $color;
					           } else {
						           echo '#';
					           } ?>"/></h4>
				</div>
			</div>

			<div class="widget-inside">
				<center>
					<p>
						<div class="cw-color-picker" rel="<?php echo $this->get_field_id( 'color' ); ?>"></div>
					</p>
				</center>
			</div>
			<br>
			<br>
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
	public function update( $new_instance, $old_instance ) {
		$instance                = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['stream']      = ( ! empty( $new_instance['stream'] ) ) ? strip_tags( $new_instance['stream'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['color']       = ( ! empty( $new_instance['color'] ) ) ? str_replace( "#", "", $new_instance['color'] ) : '';

		return $instance;
	}
}


add_action( 'admin_print_scripts-widgets.php', 'sample_load_color_picker_script' );
function sample_load_color_picker_script() {
	wp_enqueue_script( 'farbtastic' );
}


add_action( 'admin_print_styles-widgets.php', 'sample_load_color_picker_style' );
function sample_load_color_picker_style() {
	wp_enqueue_style( 'farbtastic' );
}


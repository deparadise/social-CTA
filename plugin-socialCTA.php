<?php 
/*Plugin Name: Social Call-To-Action
Description: Sets up the control for the social-CTA widget.
Version: 0.1
Author: David Pineda_DEParadise Creative
Author URI: http://www.deparadise.com
License: GPLv2
*/

	class socialCTA extends WP_Widget {

		function __construct() {
			parent::__construct(

				// base ID of the widget
				'socialCTA_widget',

				// name of the widget
				__('Social Call-To-Action', 'DEParadise_asdf' ),

				// widget options
				array (
					'description' => __(
						'Control the social-CTA widget.',
						'DEParadise_asdf'
					)
				)

			);
		}

		function form( $instance ) {
			// $defaults = array(
			// 	'SM_service' => 'Choose a service'
			// );

			// - Assign instance values to call vars
			$service = $instance['SM_service'];
			// - Assignment example from WP.org
			//$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );

			// - Widget form markup below
			// - Use value or placeholder for incoming data models
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'SM_service' ); ?>">Type of Social Media account</label>
				<input 
					class=""
					type="text"
					id="<?php echo $this->get_field_id( 'SM_service' ); ?>"
					name="<?php echo $this->get_field_name( 'SM_service' ); ?>"
					value="<?php echo esc_attr( $service ); ?>"
				>
			</p>

			<?php
		}

		function update( $new_instance, $old_instance ) {
			// - Pull old model
			$instance = $old_instance;
			// - Apply incoming new model
			$instance['SM_service'] = strip_tags( $new_instance['SM_service'] );
			// - saves to WP db instance
			return $instance;
		}

		function widget( $args, $instance ) {

		}

	} // END socialCTA

	function register_socialCTA() {

		register_widget( 'socialCTA' );

	}

	add_action( 'widgets_init', 'register_socialCTA' );

// END socialCTA plugin
?>
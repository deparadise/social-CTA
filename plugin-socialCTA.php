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
			// $instance['service_selection'] = array();
			// $instance['service_selection'] = array(
			// 	'Facebook',
			// 	'Twitter',
			// 	'Instagram'
			// );

			// - Assign instance values to call vars
			$services = $instance['service_selection'];
			// - Assignment example from WP.org
			//$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );

		/// - Widget form markup below
			// - Use value or placeholder for incoming data models
			// TESTING
			?>
			$instance:<br/>
			<?php print_r($instance)?>
			<ul>
				<!-- <li>test</li> -->
				<?php 
				foreach($services as $service) {
				//foreach($instance as $v) {
					echo '<li>' . $service . '</li>';
				}?>
			</ul>

			<?php // END TESTING?>

			<p>
				<label for="<?php echo $this->get_field_id( 'add_service' ); ?>">Add a service URL</label>
				<input 
					class=""
					type="text"
					id="<?php echo $this->get_field_id( 'add_service' ); ?>"
					name="<?php echo $this->get_field_name( 'add_service' ); ?>"
					placeholder="Add a service"
					value=""
				>
			</p>
			
			<?php
		}

		function update( $new_instance, $old_instance ) {
		// - Pull old model to apply changes
			$instance = $old_instance;
		// - Apply from incoming new model to old

			// Service Collection

			// Test for no array and init when true
			$checkServSelection = $instance['service_selection'];
			if (empty($checkServSelection)) {
				$instance['service_selection'] = array();
			}
			// start new arr and apply exsisting arr
			$servicesArr = array();
			$servicesArr = array_merge($servicesArr, $instance['service_selection']);
			// Add new entry to collection
			array_push($servicesArr, $new_instance['add_service']);
			// Re-assign to key
			$instance['service_selection'] = $servicesArr;

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
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
			$serviceSelection = array(
				'Facebook',
				'Twitter',
				'Instagram'
			);

			$serviceCollection = $instance['service_collection'];
			
			//$services = $instance['service_collection'];
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
				<?php foreach($serviceCollection as $group) {
					echo '<li><span>' . $group['service'] . '</span><br><span>' . $group['service_url'] . '</span></li>';
				}?>
			</ul>

			<?php // END TESTING?>
			<p>
				<label for="<?php echo $this->get_field_id( 'service_select' ); ?>">
					Select Service:
				</label>
				<select
					id="<?php echo $this->get_field_id( 'service_select' ); ?>"
				>
					<?php foreach($serviceSelection as $serviceOption) {
						echo '<option value="' . $serviceOption . '">' . $serviceOption . '</option>';
					}?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'service_url' ); ?>">
					What is the service page URL:
				</label>
				<input 
					class=""
					type="text"
					id="<?php echo $this->get_field_id( 'service_url' ); ?>"
					name="<?php echo $this->get_field_name( 'service_url' ); ?>"
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

			// Service Collection: Test for no array and init when true
			$checkServSelection = $instance['service_collection'];
			if (empty($checkServSelection)) {
				$instance['service_collection'] = array();
			}
			// start new arr and apply exsisting arr
			$servicesArr = array();
			$servicesArr = array_merge($servicesArr, $instance['service_collection']);
			
			// Collect for new service group
			$newServiceGroup = array(
				'service' => 'asdf',
				'service_url' => $new_instance['service_url']
			);

			// Add new entry to collection
			array_push($servicesArr, $newServiceGroup);
			
			// Re-assign to key
			$instance['service_collection'] = $servicesArr;

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
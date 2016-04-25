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
			$instance['service_selection'] = array(
				'Facebook' => 'social-facebook',
				'Twitter' => 'social-twitter',
				'Instagram' => 'social-instagram'
			);

			$serviceCollection = $instance['service_collection'];
			
			//$services = $instance['service_collection'];
			// - Assignment example from WP.org
			//$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );

		/// - Widget form markup below
			// - Use value or placeholder for incoming data models
			// TESTING
			?>
			<!-- $instance:<br/> -->
			<?php //print_r($instance)?>
			<ul>
				<!-- <li>test</li> -->
				<?php foreach($serviceCollection as $index=>$group) { ?>
					<li>
						<span> <?php echo $group['service'] ?> </span><br>
						<span> <?php echo $group['service_url'] ?> </span><br>
						<span>
							<label>Delete</label>
							<input 
								type="checkbox"
								id="<?php echo $this->get_field_id( 'delete_group_' . $index ); ?>"
								name="<?php echo $this->get_field_name( 'delete_group_' . $index  ); ?>"
							>
						</span>
					</li>
				<?php } ?>
			</ul>

			<?php // END TESTING?>
			<p>
				<label for="<?php echo $this->get_field_id( 'service_select' ); ?>">
					Select Service:
				</label>
				<select
					id="<?php echo $this->get_field_id( 'service_select' ); ?>"
					name="<?php echo $this->get_field_name( 'service_select' ); ?>"
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

			// Search new_instance for delete requests
			$instance['delete_requests'] = array();
			foreach ($new_instance as $key=>$value) {
				// check current key if it is a delete req.
				if('delete_group_' == substr($key, 0, 13)) {
					$instance['delete_requests'][] = substr($key, 13);
				}
			}
			
			// Reverse requests order for deletion request
			$instance['delete_requests'] = array_reverse($instance['delete_requests']);

			// Delete from collection based delete_requests
			foreach ($instance['delete_requests'] as $position=>$request) {
				array_splice($instance['service_collection'], $request, 1);
			}

			// If there is no URL provided do not add to the collection
			if ($new_instance['service_url'] !== '') {
				// Service Collection: Test for no array and init when true
				if (empty($instance['service_collection'])) {
					// start new arr
					$instance['service_collection'] = array();
				}

				// Collect for new service group
				$newServiceGroup = array(
					'service' => $new_instance['service_select'],
					'service_url' => $new_instance['service_url']
				);

				// Add new entry to collection
				$serviceCount = count($instance['service_collection']);
				$instance['service_collection'][] = $newServiceGroup;

				// Remove init_empty record if present
				if ($serviceCount == 1 && $instance['service_collection'][0]['service_url'] == "") {
					array_shift($instance['service_collection']);
				}
			}

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
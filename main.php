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
			// - SERVICE SELECTION
			$instance['service_selection'] = array(
				'Facebook' => 'social-facebook',
				'Twitter' => 'social-twitter',
				'Instagram' => 'social-instagram'
			);

			$serviceCollection = $instance['service_collection'];

			// TESTING
			if (false) {
				?>
				<!-- $instance:<br/> -->
				<?php //print_r($instance)
			}
			?>
			<style>
				.service-collection {
					/*border: 1px solid red;*/
				}
				.service-collection li h3 {
					margin: 1em 0 .25em 0;
				}
				.service-remove {
					position: relative;
					margin: .25em 0 0 0;
					display: block;
				}
				.service-remove input {
					position: relative;
					top: 3px;
				}
				.service-remove input[type=checkbox]:checked:before {
					color: #FF7C7D;
					/*border: 1px solid fuchsia;*/
				}
			</style>
			<ul class="service-collection">
				<!-- <li>test</li> -->
				<?php foreach($serviceCollection as $index=>$group) { ?>
					<li>
						<h3 class="service-label"><?php echo array_search($group['service'], $instance['service_selection']) ?></h3>
						<span class="service-url"> <?php echo $group['service_url'] ?> </span><br>
						<span class="service-remove">
							<label>Remove </label>
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
					<?php foreach($instance['service_selection'] as $key=>$foundationIconCall) {
						echo '<option value="' . $foundationIconCall . '">' . $key . '</option>';
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
					placeholder="Add a service URL"
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
			// Generate side setup
			if (false) { // TEST: DISPLAY INCOMING WIDGET MODEL!
			?>
				<div class="dev-test-args">
				<?php //print_r($args)?>
				</div>
				<div class="dev-test-instance">
				<?php print_r($instance['service_collection'])?>
				</div>

			<?php } // end TEST ?>

				<aside class="social-CTA widget">
					<h1 class="row"><a class="small-8 small-offset-2 columns" href="#">When's our next event?</a></h1>
					<ul class="social-links row">
						<?php
							foreach ($instance['service_collection'] as $key=>$serviceDetails) {
								echo "<li class=\"small-4 columns\"><a 
								class=\"fi-" . $serviceDetails['service'] . "\"
								href=\"" . $serviceDetails['service_url'] . "\"
								target=\"_blank\"></a></li>";
							}
						?>
						
					</ul>
				</aside>
			<?php
		}

	} // END socialCTA

	function register_socialCTA() {

		register_widget( 'socialCTA' );

	}

	add_action( 'widgets_init', 'register_socialCTA' );

// END socialCTA plugin
?>
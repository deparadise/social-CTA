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
	    }
	     
	    function form( $instance ) {
	    }
	     
	    function update( $new_instance, $old_instance ) {       
	    }
	     
	    function widget( $args, $instance ) {
	         
	    }
	     
	}

	function register_socialCTA() {
	 
	    register_widget( 'socialCTA' );
	 
	}

	add_action( 'widgets_init', 'register_socialCTA' );

?> <!-- END socialCTA plugin -->
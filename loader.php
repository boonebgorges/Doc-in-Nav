<?php 
/*
Plugin Name: Buddypress Doc in Nav
Author: Sven Lehnert
Author URL: http://themekraft.com
Description: This small plugin adds an option to the BuddyPress Docs plugin to select a tag and display the last post from this tag as a group nav item
Version: 0.1
*/


add_action( 'bp_include', 'din_session_loader' );
function din_session_loader() {
	require_once( dirname(__FILE__) . '/includes/din-functions.php' );
}
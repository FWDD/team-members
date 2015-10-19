<?php
/**
 * RivalMind Team Members
 *
 * @package   Team_Post_Type
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: RivalMind Team Members
 * Plugin URI:  https://rivalmind.com
 * Description: Adds a custom post type for Team members to your WordPress website.
 * Version:     0.1.0
 * Author:      RivalMind
 * Author URI:  https://rivalmind.com
 * Text Domain: rivalmind-team
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define the path of this plugin.
define( 'TEAM__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Required files for registering the post type and taxonomies.
require_once ( TEAM__PLUGIN_DIR . 'includes/class-team.php');
require_once ( TEAM__PLUGIN_DIR . 'includes/class-team-registrations.php');
require_once ( TEAM__PLUGIN_DIR . 'includes/class-team-metaboxes.php');

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$post_type_registrations = new Team_Post_Type_Registrations;

// Instantiate main plugin file, so activation callback does not need to be static.
$post_type = new Team_Post_Type( $post_type_registrations );

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $post_type, 'activate' ) );

// Initialize registrations for post-activation requests.
$post_type_registrations->init();

// Initialize metaboxes
$post_type_metaboxes = new Team_Post_Type_Metaboxes;
$post_type_metaboxes->init();


/**
 * Adds styling to the dashboard for the post type and adds team posts
 * to the "At a Glance" metabox.
 */
if ( is_admin() ) {

	// Loads for users viewing the WordPress dashboard.
	if ( ! class_exists( 'Dashboard_Glancer' ) ) {
		require_once (TEAM__PLUGIN_DIR . 'includes/class-gamajo-dashboard-glancer.php');  // WP 3.8
	}

	require_once (TEAM__PLUGIN_DIR . 'includes/class-team-admin.php');

	$post_type_admin = new Team_Post_Type_Admin( $post_type_registrations );
	$post_type_admin->init();

	// Load the help tabs.
	require_once (TEAM__PLUGIN_DIR . 'includes/team-help-tabs.php');
}
// Load our functions file.
require_once(TEAM__PLUGIN_DIR . 'includes/team-functions.php');
// Load the Widget
require_once(TEAM__PLUGIN_DIR . 'includes/class-team-widget.php');
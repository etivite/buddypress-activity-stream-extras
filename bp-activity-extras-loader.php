<?php
/*
Plugin Name: BuddyPress Activity Stream Extras
Plugin URI: http://wordpress.org/extend/plugins/buddypress-activity-stream-extras/
Description: A collection of small tweaks for the activity stream
Author: rich @etivite
Author URI: http://etivite.com
License: GNU GENERAL PUBLIC LICENSE 3.0 http://www.gnu.org/licenses/gpl.txt
Version: 0.1.2
Text Domain: bp-activity-extras
Network: true
*/

function etivite_bp_activity_extras_init() {

	if ( file_exists( dirname( __FILE__ ) . '/languages/' . get_locale() . '.mo' ) )
		load_textdomain( 'bp-activity-extras', dirname( __FILE__ ) . '/languages/' . get_locale() . '.mo' );
		
	require( dirname( __FILE__ ) . '/bp-activity-extras.php' );
	
	add_action( bp_core_admin_hook(), 'etivite_bp_activity_extras_admin_add_admin_menu' );
	
}
add_action( 'bp_include', 'etivite_bp_activity_extras_init', 88 );
//add_action( 'bp_init', 'etivite_bp_activity_extras_init', 88 );

//add admin_menu page
function etivite_bp_activity_extras_admin_add_admin_menu() {
	global $bp;
	
	if ( !is_super_admin() )
		return false;

	//Add the component's administration tab under the "BuddyPress" menu for site administrators
	require ( dirname( __FILE__ ) . '/admin/bp-activity-extras-admin.php' );

	add_submenu_page( 'bp-general-settings', __( 'Activity Stream Extras Admin', 'bp-activity-extras' ), __( 'Activity Extras', 'bp-activity-extras' ), 'manage_options', 'bp-activity-extras-settings', 'etivite_bp_activity_extras_admin' );

}

/* Stolen from Welcome Pack - thanks, Paul! then stolen from boone*/
function etivite_bp_activity_extras_admin_add_action_link( $links, $file ) {
	if ( 'buddypress-activity-stream-extras/bp-activity-extras-loader.php' != $file )
		return $links;

	if ( function_exists( 'bp_core_do_network_admin' ) ) {
		$settings_url = add_query_arg( 'page', 'bp-activity-extras-settings', bp_core_do_network_admin() ? network_admin_url( 'admin.php' ) : admin_url( 'admin.php' ) );
	} else {
		$settings_url = add_query_arg( 'page', 'bp-activity-extras-settings', is_multisite() ? network_admin_url( 'admin.php' ) : admin_url( 'admin.php' ) );
	}

	$settings_link = '<a href="' . $settings_url . '">' . __( 'Settings', 'bp-activity-extras' ) . '</a>';
	array_unshift( $links, $settings_link );

	return $links;
}
add_filter( 'plugin_action_links', 'etivite_bp_activity_extras_admin_add_action_link', 10, 2 );
?>

<?php
/**
 * Plugin Name: GenTime
 * Plugin URI: https://wordpress.org/plugins/gentime/
 * Description: GenTime shows the page generation time in the WordPress admin bar.
 * Author: Sybre Waaijer
 * Author URI: https://cyberwire.nl/
 * Version: 1.0.4
 * License: GLPv2 or later
 * Text Domain: gentime
 * Domain Path: /language
 */

add_action( 'plugins_loaded', 'gentime_locale_init' );
/**
 * Loads plugin locale 'gentime'.
 * File located in plugin folder gentime/language/
 *
 * @since 1.0.0
 */
function gentime_locale_init() {
	load_plugin_textdomain( 'gentime', false, basename( dirname( __FILE__ ) ) . '/language/' );
}

add_action( 'admin_bar_menu', 'gentime_admin_item', 912 );
/**
 * Adds admin node for the generation time.
 *
 * @since 1.0.0
 * @global object $wp_admin_bar
 *
 * @return void
 */
function gentime_admin_item() {
	global $wp_admin_bar;

	if ( gentime_can_run() && is_object( $wp_admin_bar ) ) {

		/**
		 * Applies filters 'gentime_decimals'
		 * @param int The generation time decimals amount
		 * @since 1.0.0
		 */
		$decimals = (int) apply_filters( 'gentime_decimals', 3 );

		$time = timer_stop( 0, $decimals );

		$args = array(
			'id'    => 'gentime',
			'title' => '<span class="ab-icon"></span><span class="ab-label">' . $time . esc_html_x( 's', 'seconds', 'gentime' ) . '</span>',
			'href'  => '',
			'meta'  => array(
				'title' => esc_attr__( 'Page Generation Time', 'gentime' ),
			),
		);

		$wp_admin_bar->add_node( $args );
	}
}


add_action( 'wp_head', 'gentime_echo_css' );
add_action( 'admin_head', 'gentime_echo_css' );
/**
 * Echos a single line to output the clock in the admin bar next to the gentime.
 *
 * @since 1.0.0
 */
function gentime_echo_css() {

	if ( gentime_can_run() )
		echo '<style type="text/css">#wp-admin-bar-gentime .ab-icon:before{font-family:"dashicons";content:"\f469";top:2px}</style>';

}

/**
 * Checks whether we can run the plugin.
 *
 * @since 1.0.2
 * @staticvar bool $cache
 *
 * @return bool
 */
function gentime_can_run() {

	static $cache = null;

	if ( isset( $cache ) )
		return $cache;

	if ( function_exists( 'is_admin_bar_showing' ) && is_admin_bar_showing() && current_user_can( gentime_capability() ) )
		return $cache = true;

	return $cache = false;
}

/**
 * Returns the minimum gentime usage role.
 * @since 1.0.0
 *
 * @return string
 */
function gentime_capability() {
	/**
	 * Applies filters 'gentime_minimum_role'
	 * @param string The minimum role for the admin bar item is shown to the user.
	 * @since 1.0.0
	 */
	return (string) apply_filters( 'gentime_minimum_role', 'install_plugins' );
}

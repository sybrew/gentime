<?php
/**
 * Plugin Name: GenTime
 * Plugin URI: https://wordpress.org/plugins/gentime/
 * Description: GenTime shows the page generation time in the WordPress admin bar.
 * Author: Sybre Waaijer
 * Author URI: https://cyberwire.nl/
 * Version: 2.0.0
 * License: GLPv3
 * Text Domain: gentime
 * Domain Path: /language
 * Requires at least: 5.3
 * Requires PHP: 7.4.0
 *
 * @package GenTime
 */

namespace GenTime;

\defined( 'ABSPATH' ) or die;

\add_action( 'admin_bar_menu', __NAMESPACE__ . '\add_admin_item', 912 );

/**
 * Adds admin node for the generation time.
 *
 * @hook admin_bar_menu 912
 * @since 2.0.0
 */
function add_admin_item() {

	\defined( 'GENTIME_VIEW_CAPABILITY' )
		or \define( 'GENTIME_VIEW_CAPABILITY', 'manage_options' );

	if (
		   ! \function_exists( 'is_admin_bar_showing' )
		|| ! \is_admin_bar_showing()
		|| ! \current_user_can( \GENTIME_VIEW_CAPABILITY )
	)
		return;

	\load_plugin_textdomain(
		'gentime',
		false,
		\dirname( \plugin_basename( __FILE__ ) ) . '/language'
	);

	/**
	 * @param int $decimals The generation time decimals amount
	 * @since 1.0.0
	 */
	$decimals = (int) \apply_filters( 'gentime_decimals', 3 );

	$args = [
		'id'    => 'gentime',
		'title' => '<span class="ab-icon"></span><span class="ab-label">'
			. \number_format_i18n( \timer_float(), $decimals ) . \esc_html_x( 's', 'seconds', 'gentime' )
			. '</span>',
		'href'  => '',
		'meta'  => [
			'title' => \esc_attr__( 'Page Generation Time', 'gentime' ),
		],
	];

	$GLOBALS['wp_admin_bar']->add_node( $args );

	// Will be enqueued with print_late_styles(). Dashicons is a common script, but WP appears to be phasing it out.
	\wp_enqueue_style( 'dashicons' );

	\add_action(
		'wp_before_admin_bar_render',
		function () {
			print( '<style>#wp-admin-bar-gentime .ab-icon:before{font-family:dashicons;content:"\f469";top:2px}</style>' );
		}
	);
}

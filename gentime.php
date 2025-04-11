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
 *
 * @param \WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function add_admin_item( $wp_admin_bar ) {

	\defined( 'GENTIME_VIEW_CAPABILITY' )
		or \define( 'GENTIME_VIEW_CAPABILITY', 'manage_options' );

	if ( ! \current_user_can( \GENTIME_VIEW_CAPABILITY ) )
		return;

	// Redundant for most sites, but the plugin may be loaded via Composer.
	\load_plugin_textdomain(
		'gentime',
		false,
		\dirname( \plugin_basename( __FILE__ ) ) . '/language',
	);

	echo '<style>#wp-admin-bar-gentime .ab-icon:before{font-family:dashicons;content:"\f469";top:2px}</style>';

	// Enqueued with print_late_styles(). Dashicons is a common script, but WP appears to be phasing it out.
	\wp_enqueue_style( 'dashicons' );

	$wp_admin_bar->add_node(
		[
			'id'    => 'gentime',
			'title' => \sprintf(
				'<span class="ab-icon"></span><span class="ab-label">%s</span>',
				\number_format_i18n(
					\timer_float(),
					/**
					 * @since 1.0.0
					 * @param int $decimals The generation time decimals amount
					 */
					$decimals = (int) \apply_filters( 'gentime_decimals', 3 ),
				)
				. \esc_html_x( 's', 'seconds', 'gentime' ),
			),
			'href'  => '',
			'meta'  => [
				'title' => \esc_attr__( 'Page Generation Time', 'gentime' ),
			],
		],
	);
}

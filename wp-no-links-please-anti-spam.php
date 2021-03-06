<?php
/*
Plugin Name: No links please! Anti-SPAM
Version:     1.3.0
Description: This simple but effective anti-SPAM system protects your WordPress site from SPAM. It works without imposing annoying CAPTCHAs, quizzes, configurations, third-party services, artificial intelligence or unicorns. How? It just drops any anonymous comment with links inside, alerting humans about this netiquette.
Author:      Valerio Bozzolan
Author URI:  https://boz.reyboz.it/?l=en
Plugin URI:  https://github.com/valerio-bozzolan/wp-no-links-please-anti-spam
License:     GPL3+
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Domain Path: /languages
Text Domain: no-links-please-anti-spam
*/

defined( 'ABSPATH' ) or die( 'Hello lamer!' );

/**
 * Callback fired when a comment is submitted
 *
 * @param $approved bool
 * @param $commentdata array
 * @since 1.0.0
 */
function no_links_please_anti_spam_handler( $approved, $commentdata ) {
	if( empty( $commentdata[ 'user_ID' ] ) && empty( $commentdata[ 'type' ] ) ) {
		$found = preg_match( '@(https?://|www\.)[^\",]+@i', $commentdata[ 'comment_content' ] );
		if( ! empty( $commentdata[ 'comment_author_url' ] ) || $found === 1 ) {
			// increment counters
			update_option( 'no_links_please_anti_spam_count', no_links_please_anti_spam_counter() + 1, false );

			// die with an error message
			$message = __( "Please try again but without links in the text. Thank you.", 'no-links-please-anti-spam' );
			$message = apply_filters( 'no_links_please_anti_spam_error', $message );
			wp_die( $message, $title, [
				'response'  => 400,
				'back_link' => true,
			] );
		}
	}
	return $approved;
}
add_filter( 'pre_comment_approved', 'no_links_please_anti_spam_handler', '99', 2 );

/**
 * Remove the author URL from the comment form for anonymous users
 */
function no_links_please_anti_spam_form_default_fields( $fields ) {
	if( ! is_user_logged_in() ) {
		// remove author URL
		unset( $fields[ 'url' ] );

		// show netiquette message
		$netiquette = __( "Please remember that links are not appreciated inside comments.", 'no-links-please-anti-spam' );
		$netiquette = apply_filters( 'no_links_please_anti_spam_netiquette', $netiquette );
		$fields[ 'comment_form_before' ] .= "<p class=\"no-links-please-anti-spam-netiquette\">$netiquette</p>";
	}
	return $fields;
}
add_filter( 'comment_form_default_fields', 'no_links_please_anti_spam_form_default_fields' );

/**
 * Unuseful callback fired when the shortcode is used
 */
function no_links_please_anti_spam_counter() {
	return get_option( 'no_links_please_anti_spam_count', 0 );
}
add_shortcode( 'no_links_please_anti_spam_counter', 'no_links_please_anti_spam_counter' );

/**
 * Register the unuseful Dashboard widget
 */
function no_links_please_anti_spam_dashboard_widget() {
	wp_add_dashboard_widget( 'no_links_please_anti_spam_dashboard_widget', __( "Anti-spam stats from \"No links, please!\"", 'no-links-please-anti-spam' ), 'no_links_please_anti_spam_dashboard_widget_content' );
}

/**
 * Register the unuseful Dashboard widget content
 */
function no_links_please_anti_spam_dashboard_widget_content() {
	echo '<p>';
	printf(
		__( "Spammers blocked since activation: %s and counting!", 'no-links-please-anti-spam' ),
		'<b>' . no_links_please_anti_spam_counter() . '</b>'
	);
	echo '</p>';
}
add_action( 'wp_dashboard_setup', 'no_links_please_anti_spam_dashboard_widget' );

// allow shortcodes to be used in widgets
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Unuseful callback fired when the plugin is activated
 */
function no_links_please_anti_spam_activation() {
	add_option( 'no_links_please_anti_spam_init',  date('U') );
	add_option( 'no_links_please_anti_spam_count', 0 );
}
register_uninstall_hook( __FILE__, 'no_links_please_anti_spam_activation' );

/**
 * Unuseful callback fired when the plugin is uninstalled
 */
function no_links_please_anti_spam_uninstall() {
	delete_option( 'no_links_please_anti_spam_init' );
	delete_option( 'no_links_please_anti_spam_count' );
}
register_uninstall_hook( __FILE__, 'no_links_please_anti_spam_uninstall' );

/**
 * Load plugin textdomain
 */
function no_links_please_anti_spam_load_textdomain() {
	load_plugin_textdomain( 'no-links-please-anti-spam', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'no_links_please_anti_spam_load_textdomain' );

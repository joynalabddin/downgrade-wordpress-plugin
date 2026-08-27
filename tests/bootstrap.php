<?php
/**
 * PHPUnit bootstrap for DevJoynal Downgrade unit tests.
 *
 * @package DevJoynal_Downgrade
 */

define( 'ABSPATH', __DIR__ . '/fixture-wordpress/' );

define( 'MINUTE_IN_SECONDS', 60 );

$GLOBALS['wpdg_test_options'] = array();
$GLOBALS['wpdg_test_settings_errors'] = array();
$GLOBALS['wpdg_test_locale'] = 'en_US';

function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function plugin_basename( $file ) {
	return basename( dirname( $file ) ) . '/' . basename( $file );
}
function load_plugin_textdomain( $domain, $deprecated = false, $plugin_rel_path = false ) {}
function __( $text, $domain = null ) {
	return $text;
}
function esc_html__( $text, $domain = null ) {
	return $text;
}
function trailingslashit( $value ) {
	return rtrim( $value, '/\\' ) . '/';
}
function determine_locale() {
	return $GLOBALS['wpdg_test_locale'];
}
function get_option( $option, $default = false ) {
	return array_key_exists( $option, $GLOBALS['wpdg_test_options'] ) ? $GLOBALS['wpdg_test_options'][ $option ] : $default;
}
function add_settings_error( $setting, $code, $message, $type = 'error' ) {
	$GLOBALS['wpdg_test_settings_errors'][] = compact( 'setting', 'code', 'message', 'type' );
}
function esc_url_raw( $url, $protocols = null ) {
	$scheme = strtolower( (string) wp_parse_url( $url, PHP_URL_SCHEME ) );
	if ( null !== $protocols && ! in_array( $scheme, $protocols, true ) ) {
		return '';
	}
	return filter_var( $url, FILTER_SANITIZE_URL );
}
function wp_http_validate_url( $url ) {
	$parts = wp_parse_url( $url );
	return is_array( $parts ) && ! empty( $parts['host'] ) && in_array( strtolower( $parts['scheme'] ?? '' ), array( 'http', 'https' ), true );
}
function wp_parse_url( $url, $component = -1 ) {
	return parse_url( $url, $component );
}

require_once dirname( __DIR__ ) . '/devjoynal-downgrade/devjoynal-downgrade.php';

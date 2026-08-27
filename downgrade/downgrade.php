<?php
/**
 * Plugin Name: Downgrade
 * Plugin URI: https://devjoynal.com
 * Description: Pin WordPress Core to an exact release for controlled rollback, compatibility testing, reinstall, or upgrade workflows.
 * Version: 2.0.0
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Tested up to: 7.1
 * Author: Joynal Abdin
 * Author URI: https://devjoynal.com
 * License: GPL-2.0-or-later
 * Text Domain: downgrade
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || exit;

define( 'DOWNGRADE_VERSION', '2.0.0' );
define( 'DOWNGRADE_OPTION_VERSION', 'wpdg_specific_version_name' );
define( 'DOWNGRADE_OPTION_URL', 'wpdg_download_url' );
define( 'DOWNGRADE_OPTION_CUSTOM_URL', 'wpdg_edit_download_url' );

add_action( 'plugins_loaded', 'downgrade_load_textdomain' );
add_action( 'admin_menu', 'downgrade_register_menu' );
add_action( 'admin_init', 'downgrade_register_settings' );
add_action( 'admin_init', 'downgrade_handle_reset' );
add_action( 'admin_enqueue_scripts', 'downgrade_enqueue_admin_assets' );
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'downgrade_plugin_action_links' );
add_filter( 'pre_site_option_update_core', 'downgrade_filter_core_updates' );
add_filter( 'site_transient_update_core', 'downgrade_filter_core_updates' );

/** Load translations without producing output. */
function downgrade_load_textdomain() {
	load_plugin_textdomain( 'downgrade', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/** Register the settings screen under Settings. */
function downgrade_register_menu() {
	add_submenu_page(
		'options-general.php',
		__( 'Downgrade', 'downgrade' ),
		__( 'Downgrade', 'downgrade' ),
		'update_core',
		'downgrade',
		'downgrade_render_settings_page'
	);
}

/** Register settings with WordPress sanitization callbacks. */
function downgrade_register_settings() {
	register_setting(
		'wpdg-settings-group',
		DOWNGRADE_OPTION_VERSION,
		array(
			'type'              => 'string',
			'sanitize_callback' => 'downgrade_sanitize_version',
			'default'           => '',
		)
	);
	register_setting(
		'wpdg-settings-group',
		DOWNGRADE_OPTION_URL,
		array(
			'type'              => 'string',
			'sanitize_callback' => 'downgrade_sanitize_url',
			'default'           => '',
		)
	);
	register_setting(
		'wpdg-settings-group',
		DOWNGRADE_OPTION_CUSTOM_URL,
		array(
			'type'              => 'boolean',
			'sanitize_callback' => 'downgrade_sanitize_boolean',
			'default'           => false,
		)
	);
}

/** Validate a WordPress version without accepting arbitrary strings. */
function downgrade_sanitize_version( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value ) {
		return '';
	}
	if ( ! preg_match( '/^\d+(?:\.\d+){1,2}$/', $value ) ) {
		add_settings_error( 'wpdg_messages', 'invalid_version', __( 'Enter a valid WordPress version such as 7.0.6.', 'downgrade' ), 'error' );
		return get_option( DOWNGRADE_OPTION_VERSION, '' );
	}
	return $value;
}

/** Accept only absolute HTTP(S) URLs for the optional custom package. */
function downgrade_sanitize_url( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value ) {
		return '';
	}
	$url = esc_url_raw( $value, array( 'http', 'https' ) );
	if ( ! $url || ! wp_http_validate_url( $url ) ) {
		add_settings_error( 'wpdg_messages', 'invalid_url', __( 'Enter a valid HTTP or HTTPS ZIP URL.', 'downgrade' ), 'error' );
		return get_option( DOWNGRADE_OPTION_URL, '' );
	}
	return $url;
}

function downgrade_sanitize_boolean( $value ) {
	return (bool) $value;
}

/** Add a direct Settings link to the plugin row. */
function downgrade_plugin_action_links( $links ) {
	$settings_link = sprintf(
		'<a href="%s">%s</a>',
		esc_url( admin_url( 'options-general.php?page=downgrade' ) ),
		esc_html__( 'Settings', 'downgrade' )
	);
	array_unshift( $links, $settings_link );
	return $links;
}

/** Load a small, scoped stylesheet only on the Downgrade screen. */
function downgrade_enqueue_admin_assets( $hook ) {
	if ( 'settings_page_downgrade' !== $hook ) {
		return;
	}
	wp_register_style( 'downgrade-admin', false, array(), DOWNGRADE_VERSION );
	wp_enqueue_style( 'downgrade-admin' );
	wp_add_inline_style(
		'downgrade-admin',
		'.downgrade-grid{display:grid;grid-template-columns:minmax(0,2fr) minmax(260px,1fr);gap:20px;max-width:1100px}.downgrade-card{background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:22px;box-shadow:0 1px 2px rgba(0,0,0,.04)}.downgrade-card h2{margin-top:0}.downgrade-status{display:inline-flex;align-items:center;gap:7px;font-weight:600}.downgrade-dot{width:10px;height:10px;border-radius:50%;display:inline-block}.downgrade-dot.active{background:#00a32a}.downgrade-dot.inactive{background:#d63638}.downgrade-author{display:flex;align-items:center;gap:14px}.downgrade-author img{width:72px;height:72px;border-radius:50%;object-fit:cover;border:2px solid #2271b1}.downgrade-muted{color:#50575e}.downgrade-warning{border-left:4px solid #dba617;background:#fff8e5;padding:12px 14px}.downgrade-actions{display:flex;gap:10px;align-items:center;flex-wrap:wrap}@media(max-width:800px){.downgrade-grid{grid-template-columns:1fr}}'
	);
}

/** Reset the version pin after a nonce and capability check. */
function downgrade_handle_reset() {
	if ( ! isset( $_POST['downgrade_reset_pin'] ) ) {
		return;
	}
	if ( ! current_user_can( 'update_core' ) || ! check_admin_referer( 'downgrade_reset_pin_action', 'downgrade_reset_pin_nonce' ) ) {
		wp_die( esc_html__( 'You are not allowed to reset the Downgrade settings.', 'downgrade' ) );
	}
	delete_option( DOWNGRADE_OPTION_VERSION );
	delete_option( DOWNGRADE_OPTION_URL );
	delete_option( DOWNGRADE_OPTION_CUSTOM_URL );
	wp_safe_redirect( add_query_arg( array( 'page' => 'downgrade', 'downgrade_reset' => '1' ), admin_url( 'options-general.php' ) ) );
	exit;
}

/** Build the official release URL for the site locale. */
function downgrade_get_release_url( $version ) {
	$locale = determine_locale();
	$locale = ( 'en_US' === $locale || 'en' === $locale ) ? '' : trailingslashit( $locale );
	return 'https://downloads.wordpress.org/release/' . $locale . 'wordpress-' . rawurlencode( $version ) . '.zip';
}

/** Return the effective package URL, respecting the opt-in custom URL setting. */
function downgrade_get_effective_url( $version = '' ) {
	$version = $version ?: get_option( DOWNGRADE_OPTION_VERSION, '' );
	$custom_enabled = (bool) get_option( DOWNGRADE_OPTION_CUSTOM_URL, false );
	$custom_url = get_option( DOWNGRADE_OPTION_URL, '' );
	if ( $custom_enabled && $custom_url ) {
		return $custom_url;
	}
	return $version ? downgrade_get_release_url( $version ) : '';
}

/** Check an endpoint without breaking the admin screen on network errors. */
function downgrade_check_url( $url ) {
	if ( ! $url ) {
		return array( 'ok' => false, 'code' => 0 );
	}
	$response = wp_remote_head( $url, array( 'timeout' => 8, 'redirection' => 3 ) );
	if ( is_wp_error( $response ) ) {
		return array( 'ok' => false, 'code' => 0 );
	}
	$code = (int) wp_remote_retrieve_response_code( $response );
	return array( 'ok' => in_array( $code, array( 200, 301, 302 ), true ), 'code' => $code );
}

/** Safely redirect WordPress Core updates to the configured version. */
function downgrade_filter_core_updates( $updates ) {
	$target = get_option( DOWNGRADE_OPTION_VERSION, '' );
	if ( ! $target || ! is_object( $updates ) || empty( $updates->updates ) || ! is_array( $updates->updates ) ) {
		return $updates;
	}
	global $wp_version;
	if ( version_compare( $wp_version, $target, '=' ) ) {
		return $updates;
	}
	$update = $updates->updates[0];
	if ( ! is_object( $update ) ) {
		return $updates;
	}
	$url = downgrade_get_effective_url( $target );
	$update->download = $url;
	if ( ! isset( $update->packages ) || ! is_object( $update->packages ) ) {
		$update->packages = new stdClass();
	}
	$update->packages->full = $url;
	$update->packages->no_content = '';
	$update->packages->new_bundled = '';
	$update->current = $target;
	$updates->updates[0] = $update;
	return $updates;
}

/** Render the professional settings and diagnostics interface. */
function downgrade_render_settings_page() {
	if ( ! current_user_can( 'update_core' ) ) {
		wp_die( esc_html__( 'You do not have permission to manage Core updates.', 'downgrade' ) );
	}
	global $wp_version;
	$target = get_option( DOWNGRADE_OPTION_VERSION, '' );
	$custom_enabled = (bool) get_option( DOWNGRADE_OPTION_CUSTOM_URL, false );
	$custom_url = get_option( DOWNGRADE_OPTION_URL, '' );
	$effective_url = downgrade_get_effective_url( $target );
	$check = $target ? downgrade_check_url( $effective_url ) : array( 'ok' => false, 'code' => 0 );
	$author_image = plugins_url( 'assets/joynal-abdin.jpg', __FILE__ );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Downgrade', 'downgrade' ); ?></h1>
		<?php settings_errors( 'wpdg_messages' ); ?>
		<?php if ( isset( $_GET['downgrade_reset'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Version pin and custom download settings were reset.', 'downgrade' ); ?></p></div>
		<?php endif; ?>
		<div class="downgrade-grid">
			<div class="downgrade-card">
				<h2><?php esc_html_e( 'Core version control', 'downgrade' ); ?></h2>
				<p class="downgrade-status"><span class="downgrade-dot <?php echo $target ? 'active' : 'inactive'; ?>"></span><?php echo $target ? esc_html__( 'Version pin is active', 'downgrade' ) : esc_html__( 'Version pin is inactive', 'downgrade' ); ?></p>
				<div class="downgrade-warning"><strong><?php esc_html_e( 'Before you continue:', 'downgrade' ); ?></strong> <?php esc_html_e( 'Create and verify a complete files-and-database backup. Test on staging first. A Core change may affect plugins, themes, database data, and server requirements.', 'downgrade' ); ?></div>
				<form method="post" action="options.php">
					<?php settings_fields( 'wpdg-settings-group' ); ?>
					<table class="form-table" role="presentation">
						<tr><th scope="row"><label for="wpdg_specific_version_name"><?php esc_html_e( 'Target WordPress version', 'downgrade' ); ?></label></th><td><input class="regular-text" id="wpdg_specific_version_name" name="wpdg_specific_version_name" type="text" inputmode="decimal" pattern="\d+(\.\d+){1,2}" placeholder="<?php echo esc_attr( $wp_version ); ?>" value="<?php echo esc_attr( $target ); ?>" /><p class="description"><?php esc_html_e( 'Use an exact release, for example 7.0.6. Leave empty to disable the pin.', 'downgrade' ); ?></p></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Current WordPress version', 'downgrade' ); ?></th><td><strong><?php echo esc_html( $wp_version ); ?></strong></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Detected locale', 'downgrade' ); ?></th><td><?php echo esc_html( determine_locale() ); ?></td></tr>
					</table>
					<h2><?php esc_html_e( 'Optional custom package URL', 'downgrade' ); ?></h2>
					<p><label><input type="checkbox" name="wpdg_edit_download_url" value="1" <?php checked( $custom_enabled ); ?> /> <?php esc_html_e( 'Use a custom HTTP(S) WordPress ZIP URL', 'downgrade' ); ?></label></p>
					<p><input class="large-text" name="wpdg_download_url" type="url" placeholder="https://downloads.wordpress.org/release/wordpress-7.0.6.zip" value="<?php echo esc_attr( $custom_url ); ?>" /></p>
					<p class="description"><?php esc_html_e( 'Only use a trusted source. This plugin does not inspect the archive contents.', 'downgrade' ); ?></p>
					<?php submit_button( __( 'Save settings', 'downgrade' ) ); ?>
				</form>
				<form method="post" class="downgrade-actions">
					<?php wp_nonce_field( 'downgrade_reset_pin_action', 'downgrade_reset_pin_nonce' ); ?>
					<button class="button" type="submit" name="downgrade_reset_pin" value="1"><?php esc_html_e( 'Reset all Downgrade settings', 'downgrade' ); ?></button>
					<a class="button button-secondary" href="<?php echo esc_url( admin_url( 'update-core.php' ) ); ?>"><?php esc_html_e( 'Open Update Core', 'downgrade' ); ?></a>
				</form>
			</div>
			<aside class="downgrade-card">
				<h2><?php esc_html_e( 'Diagnostics', 'downgrade' ); ?></h2>
				<p><strong><?php esc_html_e( 'Plugin version:', 'downgrade' ); ?></strong> <?php echo esc_html( DOWNGRADE_VERSION ); ?></p>
				<p><strong><?php esc_html_e( 'Package status:', 'downgrade' ); ?></strong> <?php echo $target ? ( $check['ok'] ? esc_html__( 'Reachable', 'downgrade' ) : esc_html__( 'Could not verify', 'downgrade' ) ) : esc_html__( 'Not checked until a target is saved', 'downgrade' ); ?></p>
				<?php if ( $effective_url ) : ?><p class="downgrade-muted"><strong><?php esc_html_e( 'Effective URL:', 'downgrade' ); ?></strong><br><code><?php echo esc_html( $effective_url ); ?></code><?php if ( $check['code'] ) : ?><br><?php printf( esc_html__( 'HTTP status: %d', 'downgrade' ), (int) $check['code'] ); ?><?php endif; ?></p><?php endif; ?>
				<hr>
				<div class="downgrade-author"><img src="<?php echo esc_url( $author_image ); ?>" alt="<?php esc_attr_e( 'Joynal Abdin, Downgrade plugin author', 'downgrade' ); ?>"><div><strong><?php esc_html_e( 'Joynal Abdin', 'downgrade' ); ?></strong><br><a href="https://devjoynal.com" target="_blank" rel="noopener noreferrer">devjoynal.com</a></div></div>
				<p class="downgrade-muted"><?php esc_html_e( 'Downgrade is maintained for controlled WordPress Core version management. Review the backup and recovery plan before every change.', 'downgrade' ); ?></p>
			</aside>
		</div>
	</div>
	<?php
}

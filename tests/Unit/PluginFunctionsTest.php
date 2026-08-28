<?php
/**
 * Unit tests for validation and URL-building behavior.
 *
 * @package DevJoynal_Downgrade
 */

use PHPUnit\Framework\TestCase;

final class PluginFunctionsTest extends TestCase {
	protected function setUp(): void {
		parent::setUp();
		$GLOBALS['wpdg_test_options'] = array();
		$GLOBALS['wpdg_test_settings_errors'] = array();
		$GLOBALS['wpdg_test_locale'] = 'en_US';
	}

	public function test_valid_version_is_preserved(): void {
		$this->assertSame( '7.0.4', downgrade_sanitize_version( ' 7.0.4 ' ) );
		$this->assertCount( 0, $GLOBALS['wpdg_test_settings_errors'] );
	}

	public function test_invalid_version_returns_previous_value_and_records_error(): void {
		$GLOBALS['wpdg_test_options'][ DOWNGRADE_OPTION_VERSION ] = '6.4.3';

		$this->assertSame( '6.4.3', downgrade_sanitize_version( 'latest' ) );
		$this->assertSame( 'invalid_version', $GLOBALS['wpdg_test_settings_errors'][0]['code'] );
	}

	public function test_valid_https_url_is_preserved(): void {
		$this->assertSame(
			'https://downloads.example.test/wordpress-7.0.4.zip',
			downgrade_sanitize_url( 'https://downloads.example.test/wordpress-7.0.4.zip' )
		);
	}

	public function test_non_http_url_returns_previous_value_and_records_error(): void {
		$GLOBALS['wpdg_test_options'][ DOWNGRADE_OPTION_URL ] = 'https://trusted.example.test/package.zip';

		$this->assertSame( 'https://trusted.example.test/package.zip', downgrade_sanitize_url( 'file:///tmp/package.zip' ) );
		$this->assertSame( 'invalid_url', $GLOBALS['wpdg_test_settings_errors'][0]['code'] );
	}

	public function test_checkbox_normalization_is_explicit(): void {
		$this->assertTrue( downgrade_sanitize_boolean( '1' ) );
		$this->assertTrue( downgrade_sanitize_boolean( 'true' ) );
		$this->assertTrue( downgrade_sanitize_boolean( 'on' ) );
		$this->assertFalse( downgrade_sanitize_boolean( '0' ) );
		$this->assertFalse( downgrade_sanitize_boolean( '' ) );
	}

	public function test_sha256_accepts_only_a_64_character_hex_digest(): void {
		$digest = str_repeat( 'a', 64 );

		$this->assertSame( $digest, downgrade_sanitize_sha256( strtoupper( $digest ) ) );
		$this->assertSame( '', downgrade_sanitize_sha256( '' ) );
		$this->assertSame( '', downgrade_sanitize_sha256( 'not-a-digest' ) );
		$this->assertSame( 'invalid_sha256', $GLOBALS['wpdg_test_settings_errors'][0]['code'] );
	}

	public function test_release_url_is_locale_aware(): void {
		$GLOBALS['wpdg_test_locale'] = 'en_US';
		$this->assertSame( 'https://downloads.wordpress.org/release/wordpress-7.0.4.zip', downgrade_get_release_url( '7.0.4' ) );

		$GLOBALS['wpdg_test_locale'] = 'de_DE';
		$this->assertSame( 'https://downloads.wordpress.org/release/de_DE/wordpress-7.0.4.zip', downgrade_get_release_url( '7.0.4' ) );
	}

	public function test_effective_url_uses_custom_url_only_when_enabled(): void {
		$GLOBALS['wpdg_test_options'][ DOWNGRADE_OPTION_VERSION ] = '7.0.4';
		$GLOBALS['wpdg_test_options'][ DOWNGRADE_OPTION_URL ] = 'https://mirror.example.test/wordpress-7.0.4.zip';

		$this->assertSame( 'https://downloads.wordpress.org/release/wordpress-7.0.4.zip', downgrade_get_effective_url() );

		$GLOBALS['wpdg_test_options'][ DOWNGRADE_OPTION_CUSTOM_URL ] = true;
		$this->assertSame( 'https://mirror.example.test/wordpress-7.0.4.zip', downgrade_get_effective_url() );
	}
}

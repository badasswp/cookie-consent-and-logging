<?php
/**
 * Plugin Name: Cookie Consent And Logging
 * Plugin URI:  https://github.com/badasswp/cookie-consent-and-logging
 * Description: Manage Cookie consent & logging on your WP website.
 * Version:     1.0.0
 * Author:      badasswp
 * Author URI:  https://github.com/badasswp
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: cookie-consent-and-logging
 * Domain Path: /languages
 *
 * @package CookieConsentAndLogging
 */

namespace badasswp\CookieConsentAndLogging;

if ( ! defined( 'WPINC' ) ) {
	exit;
}

define( 'COOKIE_CONSENT_AND_LOGGING_AUTOLOAD', __DIR__ . '/vendor/autoload.php' );

// Composer Check.
if ( ! file_exists( COOKIE_CONSENT_AND_LOGGING_AUTOLOAD ) ) {
	add_action(
		'admin_notices',
		function () {
			vprintf(
				/* translators: Plugin directory path. */
				esc_html__( 'Fatal Error: Composer not setup in %s', 'cookie-consent-and-logging' ),
				[ __DIR__ ]
			);
		}
	);

	return;
}

// Run Plugin.
require_once COOKIE_CONSENT_AND_LOGGING_AUTOLOAD;
( \CookieConsentAndLogging\Plugin::get_instance() )->run();

// Run activation hook.
register_activation_hook(
	__FILE__,
	function () {
		\CookieConsentAndLogging\Services\Setup::init()
	}
);

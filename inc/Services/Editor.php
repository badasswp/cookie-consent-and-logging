<?php
/**
 * Editor Service.
 *
 * This service manages the registration and
 * binding of the Editor service.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Services;

use CookieConsentAndLogging\Abstracts\Service;
use CookieConsentAndLogging\Interfaces\Kernel;

class Editor extends Service implements Kernel {
	/**
	 * Bind to WP.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register(): void {
		add_filter( 'gettext', [ $this, 'add_custom_title' ], 20, 3 );
		add_filter( 'gettext', [ $this, 'add_custom_description' ], 20, 3 );
	}

	/**
	 * Editor Title.
	 *
	 * Add custom title for the Block
	 * editor view.
	 *
	 * @since 1.0.0
	 *
	 * @param string $translated_text
	 * @param string $text
	 * @param string $domain
	 *
	 * @return string
	 */
	public function add_custom_title( $translated_text, $text, $domain ): string {
		if ( ! is_admin() || 'Add title' !== $text ) {
			return $translated_text;
		}

		$screen = get_current_screen();

		if ( ! $screen || 'ccal_cookie' !== $screen->post_type ) {
			return $translated_text;
		}

		return __( 'Cookie Name', 'cookie-consent-and-logging' );
	}

	/**
	 * Editor Description.
	 *
	 * Add custom description for the Block
	 * editor view.
	 *
	 * @since 1.0.0
	 *
	 * @param string $translated_text
	 * @param string $text
	 * @param string $domain
	 *
	 * @return string
	 */
	public function add_custom_description( $translated_text, $text, $domain ): string {
		if ( ! is_admin() || 'Type / to choose a block' !== $text ) {
			return $translated_text;
		}

		$screen = get_current_screen();

		if ( ! $screen || 'ccal_cookie' !== $screen->post_type ) {
			return $translated_text;
		}

		return __( 'Type in a detailed description for the Cookie and what it does...', 'cookie-consent-and-logging' );
	}
}

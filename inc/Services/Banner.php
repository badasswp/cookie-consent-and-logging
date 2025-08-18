<?php
/**
 * Banner Service.
 *
 * This service manages the registration and
 * binding of the Banner service.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Services;

use CookieConsentAndLogging\Abstracts\Service;
use CookieConsentAndLogging\Interfaces\Kernel;

class Banner extends Service implements Kernel {
	/**
	 * Asset name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected static $name = 'ccal';

	/**
	 * Bind to WP.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register(): void {
		add_action( 'wp_head', [ $this, 'display_cookie_banner' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_assets' ] );
	}

	/**
	 * Enqueue Frontend assets.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_frontend_assets(): void {
		wp_enqueue_style(
			sprintf( '%s-frontend-style', static::$name ),
			plugins_url( '../ccal.css', __DIR__ ),
			[],
			'1.0.0'
		);

		wp_enqueue_script(
			sprintf( '%s-frontend-script', static::$name ),
			plugins_url( '../dist/ccal.js', __DIR__ ),
			[],
			'1.0.0',
			true
		);

		$banner = get_option( 'cookie_consent_and_logging', [] );

		wp_localize_script(
			sprintf( '%s-frontend-script', static::$name ),
			'ccal',
			[
				'isEnabled' => $banner['enable'] ?? false,
			]
		);
	}

	/**
	 * Display Cookie Banner.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_cookie_banner(): void {
		$banner = get_option( 'cookie_consent_and_logging', [] );

		if ( ! ( $banner['enable'] ?? false ) ) {
			return;
		}

		if ( empty( $banner['title'] ) ) {
			$banner['title'] = esc_html__( 'Cookie Consent', 'cookie-consent-and-logging' );
		}

		if ( empty( $banner['content'] ) ) {
			$banner['content'] = esc_html__( 'We use cookies to provide you the best user experience on our website.', 'cookie-consent-and-logging' );
		}

		if ( empty( $banner['yes_btn'] ) ) {
			$banner['yes_btn'] = esc_html__( 'Accept (Yes)', 'cookie-consent-and-logging' );
		}

		if ( empty( $banner['no_btn'] ) ) {
			$banner['no_btn'] = esc_html__( 'Reject (No)', 'cookie-consent-and-logging' );
		}

		if ( empty( $banner['pref_btn'] ) ) {
			$banner['pref_btn'] = esc_html__( 'Manage Preferences', 'cookie-consent-and-logging' );
		}

		printf(
			'<section class="ccal_banner">
				<h1>%s</h1>
				<p>%s</p>
				<div>
					<button>%s</button>
					<button>%s</button>
					<button class="ccal_pref">%s</button>
				</div>
			</section>',
			$banner['title'],
			$banner['content'],
			$banner['yes_btn'],
			$banner['no_btn'],
			$banner['pref_btn']
		);
	}
}

<?php
/**
 * Taxonomy Service.
 *
 * This service manages the taxonomy
 * registrations for the plugin.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Services;

use CookieConsentAndLogging\Abstracts\Service;
use CookieConsentAndLogging\Interfaces\Kernel;
use CookieConsentAndLogging\Taxonomies\Cookie;

class Taxonomy extends Service implements Kernel {
	/**
	 * Taxonomy Objects.
	 *
	 * @since 1.0.0
	 *
	 * @var mixed[]
	 */
	public array $objects;

	/**
	 * Set up.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$taxonomies = [
			Cookie::class,
		];

		/**
		 * Filter list of taxonomies.
		 *
		 * @since 1.0.0
		 *
		 * @param mixed[] $taxonomies Taxonomies.
		 * @return mixed[]
		 */
		$taxonomies = (array) apply_filters( 'cookie_consent_and_logging_taxonomies', $taxonomies );

		foreach ( $taxonomies as $class ) {
			if ( ! class_exists( $class ) ) {
				throw new \LogicException( $class . ' does not exist.' );
			}
			$this->objects[] = new $class();
		}
	}

	/**
	 * Bind to WP.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register(): void {
		add_action( 'init', [ $this, 'register_taxonomies' ] );
	}

	/**
	 * Register Taxonomy type implementation.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_taxonomies(): void {
		foreach ( $this->objects as $object ) {
			$object->register_taxonomy();
		}
	}
}

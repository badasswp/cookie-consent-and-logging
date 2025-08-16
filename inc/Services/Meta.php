<?php
/**
 * Meta Service.
 *
 * This service manages the meta service
 * that registers meta fields.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Services;

use CookieConsentAndLogging\Abstracts\Service;
use CookieConsentAndLogging\Interfaces\Kernel;
use CookieConsentAndLogging\Meta\Consent;
use CookieConsentAndLogging\Meta\Cookie;

class Meta extends Service implements Kernel {
	/**
	 * Meta Objects.
	 *
	 * @since 1.0.0
	 *
	 * @var mixed[]
	 */
	public array $objects = [];

	/**
	 * Set up.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$meta = [
			Cookie::class,
			Consent::class,
		];

		/**
		 * Filter list of meta.
		 *
		 * @since 1.0.0
		 *
		 * @param mixed[] $meta Meta.
		 * @return mixed[]
		 */
		$meta = (array) apply_filters( 'cookie_consent_and_logging_meta', $meta );

		foreach ( $meta as $class ) {
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
		foreach ( $this->objects as $object ) {
			$object->register_meta();
		}
	}
}

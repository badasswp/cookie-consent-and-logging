<?php
/**
 * MetaBox Service.
 *
 * This service manages custom meta boxes within the
 * plugin. It provides functionality for registering and binding
 * custom meta boxes to CPTs in WordPress.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Services;

use CookieConsentAndLogging\Abstracts\Service;
use CookieConsentAndLogging\Interfaces\Kernel;
use CookieConsentAndLogging\MetaBoxes\CookieID;
use CookieConsentAndLogging\MetaBoxes\CookieDomain;

class MetaBox extends Service implements Kernel {
	/**
	 * MetaBox Objects.
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
		$meta_boxes = [
			CookieID::class,
			CookieDomain::class,
		];

		/**
		 * Filter list of meta boxes.
		 *
		 * @since 1.0.0
		 *
		 * @param mixed[] $meta_boxes Meta boxes.
		 * @return mixed[]
		 */
		$meta_boxes = (array) apply_filters( 'cookie_consent_and_logging_meta_boxes', $meta_boxes );

		foreach ( $meta_boxes as $class ) {
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
		add_action( 'add_meta_boxes', [ $this, 'register_meta_boxes' ] );

		/**
		 * Specify MetaBox Instance types.
		 *
		 * @since 1.0.0
		 *
		 * @var CookieID|CookieDomain $object
		 */
		foreach ( $this->objects as $object ) {
			add_action( 'publish_' . $object->get_post_type(), [ $object, 'save_meta_box' ], 10, 2 );
		}
	}

	/**
	 * Register Meta box implementation.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_meta_boxes(): void {
		foreach ( $this->objects as $object ) {
			$object->register_meta_box();
		}
	}
}

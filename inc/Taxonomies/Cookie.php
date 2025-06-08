<?php
/**
 * Cookie Class.
 *
 * This class defines the Cookie taxonomy
 * for the plugin.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Taxonomies;

use CookieConsentAndLogging\Abstracts\Taxonomy;
use CookieConsentAndLogging\Posts\Cookie as CookiePost;

class Cookie extends Taxonomy {
	/**
	 * Taxonomy type.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $name = 'ccal_cookie_tax';

	/**
	 * Return singular label.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_singular_label(): string {
		return 'Cookie Category';
	}

	/**
	 * Return plural label.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_plural_label(): string {
		return 'Cookie Categories';
	}

	/**
	 * Get Post type.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_post_type(): string {
		return CookiePost::$name;
	}
}

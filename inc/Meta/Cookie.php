<?php
/**
 * Cookie Class.
 *
 * This class defines the Cookie meta
 * for the plugin.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Meta;

use CookieConsentAndLogging\Abstracts\Meta;

class Cookie extends Meta {
	/**
	 * Post type.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $name = 'ccal_cookie';

	/**
	 * Get Post meta.
	 *
	 * This method should return an array of key value
	 * pairs representing the post meta schema for the
	 * custom post type.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed[]
	 */
	public static function get_post_meta(): array {
		return [
			'url' => [
				'label'     => esc_html__( 'URL', 'cookie-consent-and-logging' ),
				'value'     => get_post_meta( get_the_ID(), 'url', true ),
				'type'      => 'string',
				'default'   => 'https://example.com',
				'rest_name' => 'url',
			],
		];
	}
}

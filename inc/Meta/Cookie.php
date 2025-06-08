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
	public static $name = CookiePost::$name;

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
		$post_id = absint( get_the_ID() );

		return [
			'ccal_cookie_id'     => [
				'label'     => esc_html__( 'ID', 'cookie-consent-and-logging' ),
				'value'     => get_post_meta( $post_id, 'ccal_cookie_id', true ),
				'type'      => 'string',
				'default'   => '',
				'rest_name' => 'ccalCookieId',
			],
			'ccal_cookie_domain' => [
				'label'     => esc_html__( 'Domain', 'cookie-consent-and-logging' ),
				'value'     => get_post_meta( $post_id, 'ccal_cookie_domain', true ),
				'type'      => 'string',
				'default'   => '',
				'rest_name' => 'ccalCookieDomain',
			],
		];
	}
}

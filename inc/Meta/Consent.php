<?php
/**
 * Consent Class.
 *
 * This class defines the Consent
 * for the plugin.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Meta;

use CookieConsentAndLogging\Abstracts\Meta;

class Consent extends Meta {
	/**
	 * Post type.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $name = 'ccal_consent';

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
			'ccal_consent_name'       => [
				'label'     => esc_html__( 'Consent Name', 'cookie-consent-and-logging' ),
				'value'     => get_post_meta( $post_id, 'ccal_consent_name', true ),
				'type'      => 'string',
				'default'   => '',
				'rest_name' => 'ccalConsentName',
			],
			'ccal_consent_ip_address' => [
				'label'     => esc_html__( 'Consent IP Address', 'cookie-consent-and-logging' ),
				'value'     => get_post_meta( $post_id, 'ccal_consent_ip_address', true ),
				'type'      => 'string',
				'default'   => '',
				'rest_name' => 'ccalConsentIpAddress',
			],
			'ccal_consent_setting'    => [
				'label'     => esc_html__( 'Consent Setting', 'cookie-consent-and-logging' ),
				'value'     => get_post_meta( $post_id, 'ccal_consent_setting', true ),
				'type'      => 'string',
				'default'   => '',
				'rest_name' => 'ccalConsentSetting',
			],
		];
	}
}

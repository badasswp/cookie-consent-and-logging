<?php
/**
 * Cookie Expiration Meta box.
 *
 * This class defines a meta box for managing the
 * Cookie Expiration.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\MetaBoxes;

use CookieConsentAndLogging\Posts\Cookie;
use CookieConsentAndLogging\Abstracts\MetaBox;

/**
 * Cookie Expiration class.
 */
class CookieExpiration extends MetaBox {
	/**
	 * Meta box name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $name = 'ccal_cookie_expiration';

	/**
	 * Return meta box heading.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_heading(): string {
		return 'Cookie Expiration';
	}

	/**
	 * Return parent post type.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_post_type(): string {
		return Cookie::$name;
	}

	/**
	 * Return meta box position.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_position(): string {
		return '';
	}

	/**
	 * Return meta box priority.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_priority(): string {
		return 'high';
	}

	/**
	 * Return callback.
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_Post $post WP Post.
	 * @return void
	 */
	public function get_metabox_callback( $post ): void {
		wp_nonce_field( 'ccal_action', 'ccal_nonce' );

		$cookie_expiration = get_post_meta( $post->ID, static::$name, true );

		printf(
			'<input
				type="text"
				class="widefat"
				name="%s"
				style="margin-top: 5px;"
				value="%s"
			/>',
			esc_attr( static::$name ),
			esc_attr( $cookie_expiration )
		);
	}

	/**
	 * Save Meta box.
	 *
	 * @since 1.0.0
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post WP Post.
	 * @return void
	 */
	public function save_meta_box( $post_id, $post ): void {
		$name = static::$name;

		// Verify nonce.
		if ( ! isset( $_POST['ccal_nonce'] ) || ! wp_verify_nonce( $_POST['ccal_nonce'], 'ccal_action' ) ) {
			return;
		}

		// Sanitize and save data.
		update_post_meta( $post_id, $name, sanitize_text_field( $_POST[ $name ] ?? '' ) );
	}
}

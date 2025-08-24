<?php
/**
 * Consent Name Meta box.
 *
 * This class defines a meta box for managing the
 * Consent Name.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\MetaBoxes;

use CookieConsentAndLogging\Posts\Consent;
use CookieConsentAndLogging\Abstracts\MetaBox;

/**
 * Consent Name class.
 */
class ConsentName extends MetaBox {
	/**
	 * Meta box name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $name = 'ccal_consent_name';

	/**
	 * Return meta box heading.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_heading(): string {
		return 'Consent Name';
	}

	/**
	 * Return parent post type.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_post_type(): string {
		return Consent::$name;
	}

	/**
	 * Return meta box position.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_position(): string {
		return '';
	}

	/**
	 * Return meta box priority.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_priority(): string {
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
		wp_nonce_field( static::$name, 'ccal_nonce' );

		$consent_name = get_post_meta( $post->ID, static::$name, true );

		printf(
			'<input
				type="text"
				class="widefat"
				name="%s"
				style="margin-top: 5px;"
				value="%s"
			/>',
			esc_attr( static::$name ),
			esc_attr( $consent_name )
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

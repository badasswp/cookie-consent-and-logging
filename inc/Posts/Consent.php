<?php
/**
 * Consent Class.
 *
 * This class defines the Consent CPT
 * for the plugin.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Posts;

use CookieConsentAndLogging\Abstracts\Post;

class Consent extends Post {
	/**
	 * Post type.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $name = 'ccal_consent';

	/**
	 * Get Singular Label.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_singular_label(): string {
		return 'Consent';
	}

	/**
	 * Get Plural Label.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_plural_label(): string {
		return 'Consents';
	}

	/**
	 * Get Support options.
	 *
	 * @since 1.0.0
	 *
	 * @return string[]
	 */
	protected function get_supports(): array {
		return [ 'title', 'thumbnail', 'editor' ];
	}

	/**
	 *
	 * Slug on rewrite.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_slug(): string {
		return 'consent';
	}

	/**
	 * Is Post visible in REST.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	protected function is_post_visible_in_rest(): bool {
		return true;
	}

	/**
	 * Is Post visible in Menu.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	protected function is_post_visible_in_menu(): bool {
		return true;
	}

	/**
	 * Get Post meta schema.
	 *
	 * This method should return an array of key value pairs representing
	 * the post meta schema for the custom post type.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed[]
	 */
	protected function get_post_meta_schema(): array {
		return [
			'url' => [
				'label'   => esc_html__( 'URL', 'cookie-consent-and-logging' ),
				'value'   => get_post_meta( get_the_ID(), 'url', true ),
				'type'    => 'string',
				'default' => 'https://example.com',
			],
		];
	}

	/**
	 * Save Post Type.
	 *
	 * @since 1.0.0
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    WP Post.
	 * @return void
	 */
	public function save_post_type( $post_id, $post ): void {}

	/**
	 * Delete Post Type.
	 *
	 * @since 1.0.0
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    WP Post.
	 * @return void
	 */
	public function delete_post_type( $post_id, $post ): void {}
}

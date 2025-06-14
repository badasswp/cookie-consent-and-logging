<?php
/**
 * Cookie Class.
 *
 * This class defines the Cookie CPT
 * for the plugin.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Posts;

use CookieConsentAndLogging\Abstracts\Post;
use CookieConsentAndLogging\Meta\Cookie as CookieMeta;

class Cookie extends Post {
	/**
	 * Post type.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $name = 'ccal_cookie';

	/**
	 * Get Singular Label.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_singular_label(): string {
		return 'Cookie';
	}

	/**
	 * Get Plural Label.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_plural_label(): string {
		return 'Cookies';
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
		return 'cookie';
	}

	/**
	 * Is Post visible in REST.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	protected function is_post_visible_in_rest(): bool {
		return false;
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
		return CookieMeta::get_post_meta();
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

<?php
/**
 * Container class.
 *
 * This class is responsible for registering the
 * plugin's services.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Core;

use CookieConsentAndLogging\Interfaces\Kernel;
use CookieConsentAndLogging\Services\Setup;
use CookieConsentAndLogging\Services\Banner;
use CookieConsentAndLogging\Services\MetaBox;
use CookieConsentAndLogging\Services\Editor;
use CookieConsentAndLogging\Services\Meta;
use CookieConsentAndLogging\Services\Taxonomy;
use CookieConsentAndLogging\Services\Post;
use CookieConsentAndLogging\Services\Admin;

class Container implements Kernel {
	/**
	 * Services.
	 *
	 * @since 1.0.0
	 *
	 * @var mixed[]
	 */
	public static array $services = [];

	/**
	 * Prepare Singletons.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		static::$services = [
			Admin::class,
			Post::class,
			Taxonomy::class,
			Meta::class,
			Editor::class,
			MetaBox::class,
			Banner::class,
			Setup::class,
		];
	}

	/**
	 * Register Service.
	 *
	 * Establish singleton version for each Service
	 * concrete class.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register(): void {
		foreach ( static::$services as $service ) {
			( $service::get_instance() )->register();
		}
	}
}

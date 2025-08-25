<?php
/**
 * Setup Service.
 *
 * This service manages the registration and
 * binding of the Setup service.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Services;

use CookieConsentAndLogging\Abstracts\Service;
use CookieConsentAndLogging\Interfaces\Kernel;

class Setup extends Service implements Kernel {
	/**
	 * Bind to WP.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register(): void {
		// Do nothing...
	}

	/**
	 * Set up cookie list here.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function init(): void {
		// Do nothing...
	}
}

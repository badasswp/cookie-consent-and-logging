<?php
/**
 * Kernel Interface
 *
 * Establish base methods for Concrete services
 * used across plugin.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Interfaces;

interface Kernel {
	/**
	 * Register logic.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register(): void;
}

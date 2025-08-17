<?php
/**
 * Admin Service.
 *
 * This service manages the admin area of the
 * plugin. It provides functionality for registering
 * the plugin options/settings.
 *
 * @package CookieConsentAndLogging
 */

namespace CookieConsentAndLogging\Services;

use CookieConsentAndLogging\Abstracts\Service;
use CookieConsentAndLogging\Interfaces\Kernel;

class Admin extends Service implements Kernel {
	/**
	 * Plugin Option.
	 *
	 * @var string
	 */
	const PLUGIN_SLUG = 'cookie-consent-and-logging';

	/**
	 * Plugin Option.
	 *
	 * @var string
	 */
	const PLUGIN_OPTION = 'cookie_consent_and_logging';

	/**
	 * Plugin Group.
	 *
	 * @var string
	 */
	const PLUGIN_GROUP = 'cookie-consent-and-logging-group';

	/**
	 * Plugin Options.
	 *
	 * @var mixed[]
	 */
	public array $options;

	/**
	 * Bind to WP.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register(): void {
		add_action( 'admin_menu', [ $this, 'register_options_page' ] );
	}

	/**
	 * Register Options Page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_options_page(): void {
		add_menu_page(
			esc_html__( 'Cookie Consent And Logging', 'cookie-consent-and-logging' ),
			esc_html__( 'Cookie Consent And Logging', 'cookie-consent-and-logging' ),
			'manage_options',
			self::PLUGIN_SLUG,
			null,
			'dashicons-admin-customizer',
			100
		);

		add_submenu_page(
			self::PLUGIN_SLUG,
			esc_html__( 'Settings', 'manage-block-template' ),
			esc_html__( 'Settings', 'manage-block-template' ),
			'manage_options',
			'ccal_settings',
			[ $this, 'register_options_cb' ],
		);
	}

	/**
	 * Register Options Callback.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_options_cb(): void {
		$this->options = get_option( self::PLUGIN_OPTION, [] );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Cookie Consent And Logging', 'cookie-consent-and-logging' ); ?></h1>
			<p><?php esc_html_e( 'Manage Cookie consent & logging on your WP website.', 'cookie-consent-and-logging' ); ?></p>
			<form method="post" action="options.php">
			<?php
				settings_fields( self::PLUGIN_GROUP );
				do_settings_sections( self::PLUGIN_SLUG );
				submit_button();
			?>
			</form>
		</div>
		<?php
	}
}

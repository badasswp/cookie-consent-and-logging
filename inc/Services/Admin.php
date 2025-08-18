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
	 * Plugin Section.
	 *
	 * @var string
	 */
	const PLUGIN_SECTION = 'cookie-consent-and-logging-section';

	/**
	 * Notice Title.
	 *
	 * @var string
	 */
	const CCAL_TITLE = 'title';

	/**
	 * Notice Content.
	 *
	 * @var string
	 */
	const CCAL_CONTENT = 'content';

	/**
	 * Notice Button (Yes).
	 *
	 * @var string
	 */
	const CCAL_YES_BTN = 'yes_btn';

	/**
	 * Notice Button (No).
	 *
	 * @var string
	 */
	const CCAL_NO_BTN = 'no_btn';

	/**
	 * Notice Button (Preferences).
	 *
	 * @var string
	 */
	const CCAL_PREF_BTN = 'pref_btn';

	/**
	 * Enable Cookie Banner.
	 *
	 * @var string
	 */
	const CCAL_ENABLE = 'enable';

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
		add_action( 'admin_init', [ $this, 'register_options_init' ] );
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
			'dashicons-art',
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

	/**
	 * Register Options Init.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_options_init(): void {
		register_setting(
			self::PLUGIN_GROUP,
			self::PLUGIN_OPTION,
			[ $this, 'sanitize_options' ]
		);

		foreach ( $this->get_sections() as $section ) {
			add_settings_section(
				$section['name'] ?? '',
				$section['label'] ?? '',
				null,
				self::PLUGIN_SLUG
			);
		}

		foreach ( $this->get_options() as $option ) {
			if ( ! isset( $option['name'] ) || ! isset( $option['cb'] ) || ! is_callable( $option['cb'] ) ) {
				continue;
			}

			add_settings_field(
				$option['name'] ?? '',
				$option['label'] ?? '',
				$option['cb'],
				$option['page'] ?? '',
				$option['section'] ?? ''
			);
		}
	}

	/**
	 * Get Form Sections.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed[]
	 */
	protected function get_sections(): array {
		return [
			[
				'name'  => self::PLUGIN_SECTION,
				'label' => esc_html__( 'Settings', 'cookie-and-consent-logging' ),
			],
		];
	}

	/**
	 * Get Callback name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Form Control name.
	 * @return string
	 */
	protected function get_callback_name( $name ): string {
		return sprintf( '%s_cb', $name );
	}

	/**
	 * Get Plugin Options.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed[]
	 */
	protected function get_options(): array {
		$options = [
			[
				'name'    => self::CCAL_ENABLE,
				'label'   => esc_html__( 'Enable Cookie Banner', 'cookie-and-consent-logging' ),
				'cb'      => [ $this, $this->get_callback_name( self::CCAL_ENABLE ) ],
				'page'    => self::PLUGIN_SLUG,
				'section' => self::PLUGIN_SECTION,
			],
			[
				'name'    => self::CCAL_TITLE,
				'label'   => esc_html__( 'Banner Title', 'cookie-and-consent-logging' ),
				'cb'      => [ $this, $this->get_callback_name( self::CCAL_TITLE ) ],
				'page'    => self::PLUGIN_SLUG,
				'section' => self::PLUGIN_SECTION,
			],
			[
				'name'    => self::CCAL_CONTENT,
				'label'   => esc_html__( 'Banner Content', 'cookie-and-consent-logging' ),
				'cb'      => [ $this, $this->get_callback_name( self::CCAL_CONTENT ) ],
				'page'    => self::PLUGIN_SLUG,
				'section' => self::PLUGIN_SECTION,
			],
			[
				'name'    => self::CCAL_YES_BTN,
				'label'   => esc_html__( 'Button Label (Yes)', 'cookie-and-consent-logging' ),
				'cb'      => [ $this, $this->get_callback_name( self::CCAL_YES_BTN ) ],
				'page'    => self::PLUGIN_SLUG,
				'section' => self::PLUGIN_SECTION,
			],
			[
				'name'    => self::CCAL_NO_BTN,
				'label'   => esc_html__( 'Button Label (No)', 'cookie-and-consent-logging' ),
				'cb'      => [ $this, $this->get_callback_name( self::CCAL_NO_BTN ) ],
				'page'    => self::PLUGIN_SLUG,
				'section' => self::PLUGIN_SECTION,
			],
			[
				'name'    => self::CCAL_PREF_BTN,
				'label'   => esc_html__( 'Button Label (Preferences)', 'cookie-and-consent-logging' ),
				'cb'      => [ $this, $this->get_callback_name( self::CCAL_PREF_BTN ) ],
				'page'    => self::PLUGIN_SLUG,
				'section' => self::PLUGIN_SECTION,
			],
		];

		/**
		 * Filter Option Fields.
		 *
		 * @since 1.0.0
		 *
		 * @param mixed[] $options Option Fields.
		 * @return mixed[]
		 */
		return apply_filters( 'cookie_and_consent_logging_admin_fields', $options );
	}

	/**
	 * Enable Banner Callback.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enable_cb(): void {
		printf(
			'<input
				type="checkbox"
				id="%2$s"
				name="%1$s[%2$s]"
				value="1" %3$s
			/>',
			esc_attr( self::PLUGIN_OPTION ),
			esc_attr( self::CCAL_ENABLE ),
			checked( 1, $this->options[ self::CCAL_ENABLE ] ?? 0, false )
		);
	}

	/**
	 * Title Callback.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function title_cb(): void {
		printf(
			'<input
			   type="text"
			   id="%2$s"
			   name="%1$s[%2$s]"
			   placeholder="%4$s"
			   value="%3$s"
			   class="wide"
		   />',
			esc_attr( self::PLUGIN_OPTION ),
			esc_attr( self::CCAL_TITLE ),
			esc_attr( $this->options[ self::CCAL_TITLE ] ?? '' ),
			esc_html__( 'Cookies Consent', 'cookie-consent-and-logging' )
		);
	}

	/**
	 * Content Callback.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function content_cb(): void {
		printf(
			'<textarea
				id="%2$s"
				name="%1$s[%2$s]"
				rows="5"
				cols="50"
				placeholder="%4$s"
			>%3$s</textarea>',
			esc_attr( self::PLUGIN_OPTION ),
			esc_attr( self::CCAL_CONTENT ),
			esc_attr( $this->options[ self::CCAL_CONTENT ] ?? '' ),
			esc_html__( 'We use cookies to provide you the best user experience on our website.', 'cookie-consent-and-logging' )
		);
	}

	/**
	 * Yes Button Callback.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function yes_btn_cb(): void {
		printf(
			'<input
			   type="text"
			   id="%2$s"
			   name="%1$s[%2$s]"
			   placeholder="%4$s"
			   value="%3$s"
			   class="wide"
		   />',
			esc_attr( self::PLUGIN_OPTION ),
			esc_attr( self::CCAL_YES_BTN ),
			esc_attr( $this->options[ self::CCAL_YES_BTN ] ?? '' ),
			esc_html__( 'Accept (Yes)', 'cookie-consent-and-logging' )
		);
	}

	/**
	 * No Button Callback.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function no_btn_cb(): void {
		printf(
			'<input
			   type="text"
			   id="%2$s"
			   name="%1$s[%2$s]"
			   placeholder="%4$s"
			   value="%3$s"
			   class="wide"
		   />',
			esc_attr( self::PLUGIN_OPTION ),
			esc_attr( self::CCAL_NO_BTN ),
			esc_attr( $this->options[ self::CCAL_NO_BTN ] ?? '' ),
			esc_html__( 'Reject (No)', 'cookie-consent-and-logging' )
		);
	}

	/**
	 * Preferences Button Callback.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function pref_btn_cb(): void {
		printf(
			'<input
			   type="text"
			   id="%2$s"
			   name="%1$s[%2$s]"
			   placeholder="%4$s"
			   value="%3$s"
			   class="wide"
		   />',
			esc_attr( self::PLUGIN_OPTION ),
			esc_attr( self::CCAL_PREF_BTN ),
			esc_attr( $this->options[ self::CCAL_PREF_BTN ] ?? '' ),
			esc_html__( 'Manage Preferences', 'cookie-consent-and-logging' )
		);
	}

	/**
	 * Sanitize Options.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed[] $input Plugin Options.
	 * @return mixed[]
	 */
	public function sanitize_options( $input ): array {
		$sanitized_options = [];

		if ( isset( $input[ self::CCAL_ENABLE ] ) ) {
			$input_data = trim( (string) $input[ self::CCAL_ENABLE ] );

			$sanitized_options[ self::CCAL_ENABLE ] = absint( $input_data );
		}

		if ( isset( $input[ self::CCAL_TITLE ] ) ) {
			$input_data = trim( (string) $input[ self::CCAL_TITLE ] );

			$sanitized_options[ self::CCAL_TITLE ] = sanitize_text_field( $input_data );
		}

		if ( isset( $input[ self::CCAL_CONTENT ] ) ) {
			$input_data = trim( (string) $input[ self::CCAL_CONTENT ] );

			$sanitized_options[ self::CCAL_CONTENT ] = sanitize_textarea_field( $input_data );
		}

		if ( isset( $input[ self::CCAL_YES_BTN ] ) ) {
			$input_data = trim( (string) $input[ self::CCAL_YES_BTN ] );

			$sanitized_options[ self::CCAL_YES_BTN ] = sanitize_text_field( $input_data );
		}

		if ( isset( $input[ self::CCAL_NO_BTN ] ) ) {
			$input_data = trim( (string) $input[ self::CCAL_NO_BTN ] );

			$sanitized_options[ self::CCAL_NO_BTN ] = sanitize_text_field( $input_data );
		}

		if ( isset( $input[ self::CCAL_PREF_BTN ] ) ) {
			$input_data = trim( (string) $input[ self::CCAL_PREF_BTN ] );

			$sanitized_options[ self::CCAL_PREF_BTN ] = sanitize_text_field( $input_data );
		}

		return $sanitized_options;
	}
}

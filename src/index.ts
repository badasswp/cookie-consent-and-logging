import domReady from '@wordpress/dom-ready';

/**
 * Cookie Consent and Logging.
 *
 * Expire Cookies not consented to by
 * user with IP address.
 *
 * @since 1.0.0
 *
 * @return {void}
 */
const expireCookiesNotConsentedTo = (): void => {
	const { isEnabled, cookies } = window.cookieConsentAndLogging;

	if ( ! isEnabled || ! document.cookie.includes( 'ccal' ) ) {
		return;
	}

	document.cookie.split( ';' ).forEach( ( cookie ) => {
		const [ name ] = cookie.trim().split( '=' );

		for ( let j = 0; j < cookies.length; j++ ) {
			if ( name.includes( cookies[ j ].id ) ) {
				document.cookie = `${ name }=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
			}
		}
	} );
};

// Run once DOM is ready.
domReady( () => {
	expireCookiesNotConsentedTo();
} );

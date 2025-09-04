# cookie-consent-and-logging

Manage Cookie consent & logging on your WP website.

<img width="449" height="417" alt="screenshot-1" src="https://github.com/user-attachments/assets/6c07ff60-7e2d-4d8f-b42e-4713319ae17b" />

---

<img width="673" height="657" alt="screenshot-2" src="https://github.com/user-attachments/assets/085a24b0-0444-40a6-a4f4-af0d0a145268" />

## Why Cookie Consent & Logging?

In today’s digital landscape, transparency and accountability have become non-negotiable cornerstones of user trust. Cookie consent isn’t just about compliance with regulations like GDPR or CCPA, __it's about giving users control__ over their __personal data__. By explicitly asking for consent, websites demonstrate respect for user privacy, ensuring that tracking technologies are only activated when individuals agree.

This plugin helps you solve the afore-mentioned problems in one swoop. Now you can get users to consent and log accordingly to ensure trust & build credibility on your website.

## Hooks

### PHP Hooks

#### `cookie_consent_and_logging_meta_options`

This custom hook (filter) provides a way to modify the `meta` abstraction options.

```php
add_filter( 'cookie_consent_and_logging_meta_options', [ $this, 'custom_meta_options' ], 10, 3 );

public function custom_meta_options( $options, $key, $value ) {
    if ( 'ccal_cookie_name' === $key ) {
        $options['show_in_rest'] = [
            'name' => 'restCookieName',
            ...$options['show_in_rest']
        ]
    }

    return $options;
}
```

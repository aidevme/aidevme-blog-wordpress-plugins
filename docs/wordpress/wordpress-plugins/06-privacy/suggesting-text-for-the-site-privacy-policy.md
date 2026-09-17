# Suggesting Text for the Site Privacy Policy

Reference: <https://developer.wordpress.org/plugins/privacy/suggesting-text-for-the-site-privacy-policy/>

## Overview

Plugins that handle user data should contribute suggested privacy policy language via the `wp_add_privacy_policy_content()` function. This enables site administrators to incorporate data handling disclosures into their privacy policies.

## Recommended Policy Sections

The suggested text should address these key areas:

- Personal data collection and the rationale for collecting it
- Data sharing practices
- Data retention periods
- User rights regarding their information
- Data transmission locations
- Contact information
- Data protection methods
- Breach response procedures
- Third-party data sources
- Automated decision-making processes
- Applicable regulatory requirements

Not all sections apply universally; particular attention should focus on data-sharing disclosures.

## Implementation Guidelines

The function call should occur during the `admin_init` action hook to avoid complications. Content marked with the `.privacy-policy-tutorial` CSS class is excluded when administrators copy sections into their policies.

## Code Example

```php
function wporg_add_privacy_policy_content() {
	if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
		return;
	}
	$content = '<p class="privacy-policy-tutorial">' . __( 'Some introductory content for the suggested text.', 'text-domain' ) . '</p>'
			. '<strong class="privacy-policy-tutorial">' . __( 'Suggested Text:', 'my_plugin_textdomain' ) . '</strong> '
			. sprintf(
				__( 'When you leave a comment on this site, we send your name, email address, IP address and comment text to example.com.', 'text-domain' ),
				'https://example.com/privacy-policy'
			);
	wp_add_privacy_policy_content( 'Example Plugin', wp_kses_post( wpautop( $content, false ) ) );
}

add_action( 'admin_init', 'wporg_add_privacy_policy_content' );
```

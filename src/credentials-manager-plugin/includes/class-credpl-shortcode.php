<?php
/**
 * Registers and renders the [credential-block] shortcode. See
 * SPECIFICATION.md §7.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Credpl_Shortcode {

	const TAG = 'credential-block';

	public static function init() {
		add_shortcode( self::TAG, array( __CLASS__, 'render' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'maybe_enqueue_styles' ) );
	}

	/**
	 * Build the copy-paste shortcode string for a given block row, e.g.
	 * [credential-block id="a2949a2"]. Shared by the admin edit screen and
	 * the Blocks list table. The heading shown on the front end always
	 * tracks the block's own Title field (see render()) rather than being
	 * a separately editable shortcode attribute, so it isn't included here.
	 */
	public static function build_tag( array $block ) {
		return sprintf(
			'[%s id="%s"]',
			self::TAG,
			$block['block_key']
		);
	}

	/**
	 * Only load the front-end stylesheet on pages that actually contain
	 * the shortcode, not site-wide.
	 */
	public static function maybe_enqueue_styles() {
		if ( ! is_singular() ) {
			return;
		}

		$post = get_post();

		if ( ! $post || ! has_shortcode( $post->post_content, self::TAG ) ) {
			return;
		}

		wp_enqueue_style(
			'credpl-credential-block',
			plugins_url( 'assets/css/credpl-credential-block.css', CREDPL_PLUGIN_FILE ),
			array(),
			CREDPL_VERSION
		);
	}

	/**
	 * Shortcode callback. Renders nothing (rather than a PHP notice/error)
	 * if the `id` is missing or doesn't match a saved block.
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts,
			self::TAG
		);

		$block_key = sanitize_text_field( $atts['id'] );

		if ( '' === $block_key ) {
			return '';
		}

		$block = Credpl_Data::get_credential_block_by_key( $block_key );

		if ( ! $block ) {
			return '';
		}

		$credential_ids = json_decode( $block['credential_ids'], true );
		$credential_ids = is_array( $credential_ids ) ? array_map( 'absint', $credential_ids ) : array();

		$credentials = array();
		foreach ( $credential_ids as $credential_id ) {
			$credential = Credpl_Data::get_credential( $credential_id );

			// Skip IDs for credentials deleted since this block was saved.
			if ( $credential ) {
				$credentials[] = $credential;
			}
		}

		if ( empty( $credentials ) ) {
			return '';
		}

		return self::render_html( $block, $credentials, $block['title'] );
	}

	private static function render_html( array $block, array $credentials, $heading ) {
		ob_start();
		?>
		<div class="credpl-credential-block" data-credpl-block="<?php echo esc_attr( $block['block_key'] ); ?>">
			<?php if ( '' !== $heading ) : ?>
				<h3 class="credpl-credential-block-heading"><?php echo esc_html( $heading ); ?></h3>
			<?php endif; ?>
			<ul class="credpl-credential-list">
				<?php foreach ( $credentials as $credential ) : ?>
					<?php self::render_item( $credential ); ?>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
		return ob_get_clean();
	}

	private static function render_item( array $credential ) {
		$link = $credential['credential_link'];

		$badge_media = absint( $credential['badge_media'] );
		$image_url   = $badge_media ? wp_get_attachment_image_url( $badge_media, 'medium' ) : '';
		$badge_inner = self::badge_inner( $image_url, $credential['title'] );

		$is_award = 'Awards' === $credential['credentials_type']; // Must match the literal in Credpl_Admin_Credentials::CREDENTIALS_TYPES (§6.2) — same convention as credential.tsx's own conditional Award Category/Technology Area rendering (§10 v30).
		$tag      = self::format_tag( $credential );

		// Awards show Award Category/Technology Area lines instead of dates
		// (§10 v32): earned/expires dates aren't meaningful for awards.
		$show_dates = ! $is_award && ( ! empty( $credential['earned_on'] ) || ! empty( $credential['expires_on'] ) );
		?>
		<li class="credpl-credential-item">
			<?php if ( $link ) : ?>
				<a class="credpl-credential-badge" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $credential['title'] ); ?>">
					<?php echo $badge_inner; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built by badge_inner() from escaped values and static markup. ?>
				</a>
			<?php else : ?>
				<span class="credpl-credential-badge">
					<?php echo $badge_inner; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- see above. ?>
				</span>
			<?php endif; ?>

			<div class="credpl-credential-info">
				<h3 class="credpl-credential-title">
					<?php if ( $link ) : ?>
						<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $credential['title'] ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $credential['title'] ); ?>
					<?php endif; ?>
				</h3>
				<?php if ( '' !== $tag ) : ?>
					<span class="credpl-credential-tag"><?php echo esc_html( $tag ); ?></span>
				<?php endif; ?>
				<?php if ( $is_award ) : ?>
					<?php if ( ! empty( $credential['award_category'] ) ) : ?>
						<p class="credpl-credential-meta">
							<?php
							printf(
								/* translators: %s: award category. */
								esc_html__( 'Award Category: %s', 'credentials-manager-plugin' ),
								esc_html( $credential['award_category'] )
							);
							?>
						</p>
					<?php endif; ?>
					<?php if ( ! empty( $credential['technology_area'] ) ) : ?>
						<p class="credpl-credential-meta">
							<?php
							printf(
								/* translators: %s: technology area. */
								esc_html__( 'Technology Area: %s', 'credentials-manager-plugin' ),
								esc_html( $credential['technology_area'] )
							);
							?>
						</p>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<?php if ( $show_dates ) : ?>
				<div class="credpl-credential-dates">
					<?php self::render_date( __( 'Earned on', 'credentials-manager-plugin' ), $credential['earned_on'] ); ?>
					<?php self::render_date( __( 'Expires on', 'credentials-manager-plugin' ), $credential['expires_on'] ); ?>
				</div>
			<?php endif; ?>
		</li>
		<?php
	}

	/**
	 * The pill under a credential's title: "{issuer} {type}", e.g.
	 * "Microsoft Applied Skills" (uppercased by the stylesheet, not here, so
	 * the stored text stays as typed). Either half is dropped if empty;
	 * returns '' if both are, so the caller can skip the pill entirely.
	 */
	private static function format_tag( array $credential ) {
		return trim( $credential['issuer'] . ' ' . $credential['credentials_type'] );
	}

	/**
	 * One "Earned on"/"Expires on" entry — calendar icon, small label, and
	 * the date formatted per the site's `date_format` option (localized via
	 * date_i18n()). Renders nothing if the date isn't set (or unparseable),
	 * so a credential with only one of the two dates shows only that one.
	 */
	private static function render_date( $label, $date ) {
		$timestamp = empty( $date ) ? false : strtotime( $date );

		if ( ! $timestamp ) {
			return;
		}
		?>
		<div class="credpl-credential-date">
			<?php echo self::calendar_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static markup. ?>
			<span class="credpl-credential-date-text">
				<span class="credpl-credential-date-label"><?php echo esc_html( $label ); ?></span>
				<time class="credpl-credential-date-value" datetime="<?php echo esc_attr( gmdate( 'Y-m-d', $timestamp ) ); ?>"><?php echo esc_html( date_i18n( get_option( 'date_format' ), $timestamp ) ); ?></time>
			</span>
		</div>
		<?php
	}

	/**
	 * The contents of a credential's round badge slot: its uploaded badge
	 * image, or — so a credential with no image still lines up with the
	 * others — a generic star badge. Returns ready-to-echo markup.
	 */
	private static function badge_inner( $image_url, $title ) {
		if ( $image_url ) {
			return sprintf(
				'<img src="%s" alt="%s" />',
				esc_url( $image_url ),
				esc_attr( $title )
			);
		}

		return '<svg class="credpl-credential-badge-fallback" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" aria-hidden="true" focusable="false"><circle cx="24" cy="24" r="20" fill="currentColor"/><path fill="#fff" d="M24 13l3.4 6.9 7.6 1.1-5.5 5.4 1.3 7.6-6.8-3.6-6.8 3.6 1.3-7.6L13 21l7.6-1.1z"/></svg>';
	}

	private static function calendar_icon() {
		return '<svg class="credpl-credential-date-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3.5" y="5" width="17" height="15.5" rx="3"/><path d="M3.5 10h17M8 3v4M16 3v4"/><path d="M8 14h.01M12 14h.01M16 14h.01M8 17h.01M12 17h.01" stroke-width="2.2"/></svg>';
	}
}

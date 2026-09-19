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

		$meta = self::format_earned_expires( $credential );
		?>
		<li class="credpl-credential-item">
			<?php if ( $image_url ) : ?>
				<?php if ( $link ) : ?>
					<a class="credpl-credential-badge" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer">
						<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $credential['title'] ); ?>" />
					</a>
				<?php else : ?>
					<span class="credpl-credential-badge">
						<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $credential['title'] ); ?>" />
					</span>
				<?php endif; ?>
			<?php endif; ?>

			<div class="credpl-credential-info">
				<h3 class="credpl-credential-title">
					<?php if ( $link ) : ?>
						<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $credential['title'] ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $credential['title'] ); ?>
					<?php endif; ?>
				</h3>
				<?php // 'Awards' must match the literal in Credpl_Admin_Credentials::CREDENTIALS_TYPES (§6.2) — same convention already followed by credential.tsx's own conditional Award Category/Technology Area rendering (§10 v30). The Earned on/Expires on line is suppressed for Awards credentials (§10 v32): those dates aren't meaningful for awards and the screenshot driving §7's example doesn't show them. ?>
				<?php if ( '' !== $meta && 'Awards' !== $credential['credentials_type'] ) : ?>
					<p class="credpl-credential-meta"><?php echo esc_html( $meta ); ?></p>
				<?php endif; ?>
				<?php if ( 'Awards' === $credential['credentials_type'] ) : ?>
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
		</li>
		<?php
	}

	/**
	 * "Expires on {date} · Earned on {date}" (site's configured date
	 * format, localized), with either clause dropped if that date isn't
	 * set — and the separator only appearing when both are. Returns ''
	 * if neither date is set, so callers can skip the line entirely.
	 */
	private static function format_earned_expires( array $credential ) {
		$date_format = get_option( 'date_format' );
		$parts       = array();

		if ( ! empty( $credential['expires_on'] ) ) {
			$parts[] = sprintf(
				/* translators: %s: formatted expiration date. */
				__( 'Expires on %s', 'credentials-manager-plugin' ),
				date_i18n( $date_format, strtotime( $credential['expires_on'] ) )
			);
		}

		if ( ! empty( $credential['earned_on'] ) ) {
			$parts[] = sprintf(
				/* translators: %s: formatted earned date. */
				__( 'Earned on %s', 'credentials-manager-plugin' ),
				date_i18n( $date_format, strtotime( $credential['earned_on'] ) )
			);
		}

		return implode( ' · ', $parts );
	}
}

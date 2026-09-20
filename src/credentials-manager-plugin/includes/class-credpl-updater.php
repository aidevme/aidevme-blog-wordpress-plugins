<?php
/**
 * Lets WordPress notice, and install, new releases of this plugin published on
 * GitHub, even though the plugin isn't hosted on WordPress.org. See
 * SPECIFICATION.md §6.9.
 *
 * How it works: the plugin header carries an `Update URI:` pointing at the
 * GitHub repository. Since WordPress 5.8, core then skips WordPress.org for this
 * plugin and instead applies the `update_plugins_{$hostname}` filter — here
 * `update_plugins_github.com` — from `wp_update_plugins()`. This class answers
 * that filter with the newest matching GitHub *Release*, and core itself decides
 * whether that version is newer than the installed one.
 *
 * What counts as a release: only published GitHub Releases whose tag is
 * `credentials-manager-plugin-v<X.Y.Z>` (the tag the "Release Credentials
 * Manager Plugin" workflow creates — plugin-scoped because the repository holds
 * more than one plugin) and which have the matching
 * `credentials-manager-plugin-<X.Y.Z>.zip` asset attached. The `main` branch is
 * never consulted: a version bump only becomes an update once a release exists.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Credpl_Updater {

	const REPOSITORY  = 'aidevme/aidevme-blog-wordpress-plugins';
	const PLUGIN_SLUG = 'credentials-manager-plugin';
	const TAG_PREFIX  = 'credentials-manager-plugin-v';
	const UPDATE_HOST = 'github.com';

	/**
	 * Site transient holding the last answer from GitHub, so WordPress's own
	 * (frequent) update checks don't each cost an API request — unauthenticated
	 * GitHub API calls are limited to 60 per hour per IP address.
	 */
	const CACHE_KEY = 'credpl_latest_release';

	/** Seconds to remember a successful answer (including "no release"). */
	const CACHE_TTL = 21600; // 6 hours.

	/** Seconds to remember a failed request before trying GitHub again. */
	const FAILURE_TTL = 3600; // 1 hour.

	public static function init() {
		add_filter( 'update_plugins_' . self::UPDATE_HOST, array( __CLASS__, 'filter_update' ), 10, 3 );
		add_filter( 'plugins_api', array( __CLASS__, 'filter_plugins_api' ), 10, 3 );

		// "Dashboard > Updates > Check Again" clears WordPress's own update
		// cache; clear ours with it so that button really re-checks GitHub.
		add_action( 'delete_site_transient_update_plugins', array( __CLASS__, 'clear_cache' ) );
	}

	/**
	 * Answers core's `update_plugins_github.com` filter.
	 *
	 * The filter runs once per installed plugin whose `Update URI` is on
	 * github.com, so anything that isn't this plugin is passed straight through.
	 * The latest release is always reported; core compares it with the installed
	 * version and files it under "update available" or "no update" itself.
	 *
	 * @param array|false $update      Update data so far (false by default).
	 * @param array       $plugin_data Plugin headers.
	 * @param string      $plugin_file Plugin file, relative to the plugins directory.
	 * @return array|false
	 */
	public static function filter_update( $update, $plugin_data, $plugin_file ) {
		if ( plugin_basename( CREDPL_PLUGIN_FILE ) !== $plugin_file ) {
			return $update;
		}

		$release = self::get_latest_release();

		if ( null === $release ) {
			return $update;
		}

		return array(
			'slug'    => self::PLUGIN_SLUG,
			'version' => $release['version'],
			'url'     => $release['url'],
			'package' => $release['package'],
		);
	}

	/**
	 * Supplies the "View version x.y.z details" popup on the Plugins screen.
	 * Without this, WordPress would ask WordPress.org about our slug and show
	 * "Plugin not found".
	 *
	 * @param false|object|array $result The result so far.
	 * @param string             $action The `plugins_api()` action.
	 * @param object             $args   The request arguments.
	 * @return false|object|array
	 */
	public static function filter_plugins_api( $result, $action, $args ) {
		if ( 'plugin_information' !== $action || ! is_object( $args ) || ! isset( $args->slug ) || self::PLUGIN_SLUG !== $args->slug ) {
			return $result;
		}

		$release = self::get_latest_release();

		if ( null === $release ) {
			return $result;
		}

		$headers = get_file_data(
			CREDPL_PLUGIN_FILE,
			array(
				'requires'     => 'Requires at least',
				'requires_php' => 'Requires PHP',
			)
		);

		return (object) array(
			'name'          => 'Credentials Manager',
			'slug'          => self::PLUGIN_SLUG,
			'version'       => $release['version'],
			'author'        => '<a href="https://github.com/aidevme">AIDevMe</a>',
			'homepage'      => 'https://github.com/' . self::REPOSITORY,
			'requires'      => $headers['requires'],
			'requires_php'  => $headers['requires_php'],
			'last_updated'  => $release['published_at'],
			'download_link' => $release['package'],
			'sections'      => array(
				'description' => esc_html__( 'Manage credentials, credential blocks, and Microsoft Learn certifications and exams, and show a selection of them anywhere with a shortcode.', 'credentials-manager-plugin' ),
				// The release body is plain text/Markdown from GitHub, so it is
				// escaped before being turned into paragraphs.
				'changelog'   => wp_kses_post( wpautop( esc_html( $release['body'] ) ) ),
			),
		);
	}

	/**
	 * Forget the cached GitHub answer.
	 */
	public static function clear_cache() {
		delete_site_transient( self::CACHE_KEY );
	}

	/**
	 * Whether pre-releases count as updates. On while the plugin is 0.x — the
	 * "Release Credentials Manager Plugin" workflow marks every 0.x release as a
	 * pre-release by default, so excluding them would mean no update was ever
	 * offered — and off from 1.0.0, so production sites aren't offered betas.
	 * Filterable: `add_filter( 'credpl_updater_include_prereleases', '__return_false' )`.
	 *
	 * @return bool
	 */
	public static function include_prereleases() {
		$default = version_compare( CREDPL_VERSION, '1.0.0', '<' );

		return (bool) apply_filters( 'credpl_updater_include_prereleases', $default );
	}

	/**
	 * The newest qualifying release, from the cache when possible.
	 *
	 * @return array|null See select_release(). Null when there is none, or when
	 *                    GitHub couldn't be reached.
	 */
	public static function get_latest_release() {
		$cached = get_site_transient( self::CACHE_KEY );

		if ( is_array( $cached ) && array_key_exists( 'release', $cached ) ) {
			return $cached['release'];
		}

		$releases = self::fetch_releases();

		if ( null === $releases ) {
			// Cache the failure briefly so a GitHub outage or a rate limit
			// doesn't add a slow request to every update check.
			set_site_transient( self::CACHE_KEY, array( 'release' => null ), self::FAILURE_TTL );

			return null;
		}

		$release = self::select_release( $releases, self::include_prereleases() );

		set_site_transient( self::CACHE_KEY, array( 'release' => $release ), self::CACHE_TTL );

		return $release;
	}

	/**
	 * Fetch the repository's most recent releases from the GitHub REST API. 100
	 * is the API maximum: this repository holds more than one plugin, so this
	 * plugin's newest release has to be found among all their releases.
	 *
	 * @return array|null The decoded releases, or null on any failure.
	 */
	private static function fetch_releases() {
		$response = wp_remote_get(
			'https://api.github.com/repos/' . self::REPOSITORY . '/releases?per_page=100',
			array(
				'timeout' => 8,
				'headers' => array(
					'Accept'               => 'application/vnd.github+json',
					'X-GitHub-Api-Version' => '2022-11-28',
					'User-Agent'           => 'credentials-manager-plugin/' . CREDPL_VERSION,
				),
			)
		);

		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			return null;
		}

		$releases = json_decode( wp_remote_retrieve_body( $response ), true );

		return is_array( $releases ) ? $releases : null;
	}

	/**
	 * Pick the newest release of *this plugin* out of a GitHub releases list.
	 * Pure function of its arguments (no WordPress calls), so it can be tested
	 * on its own.
	 *
	 * A release qualifies when it is not a draft, is not a pre-release (unless
	 * $include_prereleases), is tagged `credentials-manager-plugin-vX.Y.Z`, and
	 * has the `credentials-manager-plugin-X.Y.Z.zip` asset fully uploaded. The
	 * newest is decided by version number, not by the order GitHub returns.
	 *
	 * The download and details URLs are built here from the repository, tag and
	 * asset name, never copied from the API response, so a malformed or tampered
	 * response can't point WordPress at another host.
	 *
	 * @param array $releases            Decoded GitHub "list releases" response.
	 * @param bool  $include_prereleases Whether pre-releases qualify.
	 * @return array|null {
	 *     @type string $version      X.Y.Z, without the tag prefix.
	 *     @type string $tag          The full tag name.
	 *     @type string $package      URL of the zip asset.
	 *     @type string $url          URL of the release page.
	 *     @type string $body         The release notes (plain text/Markdown).
	 *     @type string $published_at Publication time, as GitHub reports it.
	 * }
	 */
	public static function select_release( array $releases, $include_prereleases ) {
		$best = null;

		foreach ( $releases as $release ) {
			if ( ! is_array( $release ) || ! empty( $release['draft'] ) ) {
				continue;
			}

			if ( ! $include_prereleases && ! empty( $release['prerelease'] ) ) {
				continue;
			}

			$tag = isset( $release['tag_name'] ) && is_string( $release['tag_name'] ) ? $release['tag_name'] : '';

			if ( 0 !== strpos( $tag, self::TAG_PREFIX ) ) {
				continue;
			}

			$version = substr( $tag, strlen( self::TAG_PREFIX ) );

			if ( 1 !== preg_match( '/^\d+\.\d+\.\d+$/', $version ) ) {
				continue;
			}

			$asset_name = self::PLUGIN_SLUG . '-' . $version . '.zip';

			if ( ! self::has_uploaded_asset( $release, $asset_name ) ) {
				continue;
			}

			if ( null !== $best && ! version_compare( $version, $best['version'], '>' ) ) {
				continue;
			}

			$best = array(
				'version'      => $version,
				'tag'          => $tag,
				'package'      => 'https://github.com/' . self::REPOSITORY . '/releases/download/' . $tag . '/' . $asset_name,
				'url'          => 'https://github.com/' . self::REPOSITORY . '/releases/tag/' . $tag,
				'body'         => isset( $release['body'] ) && is_string( $release['body'] ) ? $release['body'] : '',
				'published_at' => isset( $release['published_at'] ) && is_string( $release['published_at'] ) ? $release['published_at'] : '',
			);
		}

		return $best;
	}

	/**
	 * Whether a release has an asset with exactly this name, fully uploaded.
	 * (GitHub lists an asset as "starter" while its upload is still in progress.)
	 *
	 * @param array  $release    One release from the GitHub API.
	 * @param string $asset_name The expected asset file name.
	 * @return bool
	 */
	private static function has_uploaded_asset( array $release, $asset_name ) {
		if ( empty( $release['assets'] ) || ! is_array( $release['assets'] ) ) {
			return false;
		}

		foreach ( $release['assets'] as $asset ) {
			if (
				is_array( $asset )
				&& isset( $asset['name'] )
				&& $asset_name === $asset['name']
				&& ( ! isset( $asset['state'] ) || 'uploaded' === $asset['state'] )
			) {
				return true;
			}
		}

		return false;
	}
}

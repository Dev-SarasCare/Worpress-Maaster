<?php

namespace WPMailSMTP\Pro;

use WPMailSMTP\Pro\Emails\Logs\Logs;

/**
 * Class Pro handles all Pro plugin code and functionality registration.
 * Initialized inside 'init' WordPress hook.
 *
 * @since 1.5.0
 */
class Pro {

	/**
	 * Plugin slug.
	 *
	 * @since 1.5.0
	 */
	const SLUG = 'wp-mail-smtp-pro';

	/**
	 * List of files to be included early.
	 * Path from the root of the plugin directory.
	 *
	 * @since 1.5.0
	 */
	const PLUGGABLE_FILES = array(
		'src/Pro/Emails/Control/functions.php',
		'src/Pro/activation.php',
	);

	/**
	 * URL to Pro plugin assets directory.
	 *
	 * @since 1.5.0
	 *
	 * @var string Without trailing slash.
	 */
	public $assets_url = '';

	/**
	 * Pro class constructor.
	 *
	 * @since 1.5.0
	 */
	public function __construct() {

		$this->assets_url = wp_mail_smtp()->assets_url . '/pro';

		$this->init();
	}

	/**
	 * Initialize the main Pro logic.
	 *
	 * @since 1.5.0
	 */
	public function init() {

		// Load translations just in case.
		load_plugin_textdomain( 'wp-mail-smtp-pro', false, plugin_basename( wp_mail_smtp()->plugin_path ) . '/assets/pro/languages' );

		add_filter( 'http_request_args', [ $this, 'request_lite_translations' ], 10, 2 );

		// Add the action links to a plugin on Plugins page.
		add_filter( 'plugin_action_links_' . plugin_basename( WPMS_PLUGIN_FILE ), [ $this, 'add_plugin_action_link' ], 15, 1 );

		// Register Action Scheduler tasks.
		add_filter( 'wp_mail_smtp_tasks_get_tasks', [ $this, 'get_tasks' ] );

		// Add Pro specific DB tables to the list of custom DB tables.
		add_filter( 'wp_mail_smtp_core_get_custom_db_tables', [ $this, 'add_pro_specific_custom_db_tables' ] );

		$this->get_multisite()->init();
		$this->get_control();
		$this->get_logs();
		$this->get_providers();
		$this->get_license();
		$this->get_site_health()->init();
	}

	/**
	 * Load the Control functionality.
	 *
	 * @since 1.5.0
	 *
	 * @return Emails\Control\Control
	 */
	public function get_control() {

		static $control;

		if ( ! isset( $control ) ) {
			$control = apply_filters( 'wp_mail_smtp_pro_get_control', new Emails\Control\Control() );
		}

		return $control;
	}

	/**
	 * Load the Logs functionality.
	 *
	 * @since 1.5.0
	 *
	 * @return Emails\Logs\Logs
	 */
	public function get_logs() {

		static $logs;

		if ( ! isset( $logs ) ) {
			$logs = apply_filters( 'wp_mail_smtp_pro_get_logs', new Emails\Logs\Logs() );
		}

		return $logs;
	}

	/**
	 * Load the new Providers functionality.
	 *
	 * @since 1.5.0
	 *
	 * @return \WPMailSMTP\Pro\Providers\Providers
	 */
	public function get_providers() {

		static $providers;

		if ( ! isset( $providers ) ) {
			$providers = apply_filters( 'wp_mail_smtp_pro_get_providers', new Providers\Providers() );
		}

		return $providers;
	}

	/**
	 * Load the new License functionality.
	 *
	 * @since 1.5.0
	 *
	 * @return \WPMailSMTP\Pro\License\License
	 */
	public function get_license() {

		static $license;

		if ( ! isset( $license ) ) {
			$license = apply_filters( 'wp_mail_smtp_pro_get_license', new License\License() );
		}

		return $license;
	}

	/**
	 * Load the Site Health functionality.
	 *
	 * @since 1.9.0
	 *
	 * @return \WPMailSMTP\Pro\SiteHealth
	 */
	public function get_site_health() {

		static $site_health;

		if ( ! isset( $site_health ) ) {
			$site_health = apply_filters( 'wp_mail_smtp_pro_get_site_health', new SiteHealth() );
		}

		return $site_health;
	}

	/**
	 * Get the Multisite object.
	 *
	 * @since 2.2.0
	 *
	 * @return Multisite
	 */
	public function get_multisite() {

		static $multisite;

		if ( ! isset( $multisite ) ) {
			$multisite = apply_filters( 'wp_mail_smtp_pro_get_multisite', new Multisite() );
		}

		return $multisite;
	}

	/**
	 * Adds WP Mail SMTP (Lite) to the update checklist of installed plugins, to check for new translations.
	 *
	 * @since 1.6.0
	 *
	 * @param array  $args HTTP Request arguments to modify.
	 * @param string $url  The HTTP request URI that is executed.
	 *
	 * @return array The modified Request arguments to use in the update request.
	 */
	public function request_lite_translations( $args, $url ) {

		// Only do something on upgrade requests.
		if ( strpos( $url, 'api.wordpress.org/plugins/update-check' ) === false ) {
			return $args;
		}

		/*
		 * If WP Mail SMTP is already in the list, don't add it again.
		 *
		 * Checking this by name because the install path is not guaranteed.
		 * The capitalized json data defines the array keys, therefore we need to check and define these as such.
		 */
		$plugins = json_decode( $args['body']['plugins'], true );
		foreach ( $plugins['plugins'] as $slug => $data ) {
			if ( isset( $data['Name'] ) && $data['Name'] === 'WP Mail SMTP' ) {
				return $args;
			}
		}

		// Pro plugin (current plugin) key in $plugins['plugins'].
		$pro_plugin_key = plugin_basename( wp_mail_smtp()->plugin_path ) . '/wp_mail_smtp.php';

		// The pro plugin key has to exist for the code below to work.
		if ( ! isset( $plugins['plugins'][ $pro_plugin_key ] ) ) {
			return $args;
		}

		/*
		 * Add an entry to the list that matches the WordPress.org slug for WP Mail SMTP Lite.
		 *
		 * This entry is based on the currently present data from this plugin, to make sure the version and textdomain
		 * settings are as expected. Take care of the capitalized array key as before.
		 */
		$plugins['plugins']['wp-mail-smtp/wp_mail_smtp.php'] = $plugins['plugins'][ $pro_plugin_key ];
		// Override the name of the plugin.
		$plugins['plugins']['wp-mail-smtp/wp_mail_smtp.php']['Name'] = 'WP Mail SMTP';
		// Override the version of the plugin to prevent increasing the update count.
		$plugins['plugins']['wp-mail-smtp/wp_mail_smtp.php']['Version'] = '9999.0';

		// Overwrite the plugins argument in the body to be sent in the upgrade request.
		$args['body']['plugins'] = wp_json_encode( $plugins );

		return $args;
	}

	/**
	 * Get the list of all custom DB tables that should be present in the DB.
	 *
	 * @since 1.9.0
	 *
	 * @return array List of table names.
	 */
	public function get_custom_db_tables() {

		return [
			Logs::get_table_name(),
		];
	}

	/**
	 * Add Pro specific custom DB tables to the list of all plugin's custom DB tables.
	 *
	 * @since 2.1.2
	 *
	 * @param array $tables A list of existing custom tables.
	 *
	 * @return array
	 */
	public function add_pro_specific_custom_db_tables( $tables ) {

		$pro_tables = [];

		if ( $this->get_logs()->is_enabled() ) {
			$pro_tables[] = Logs::get_table_name();
		}

		return array_merge( $tables, $pro_tables );
	}

	/**
	 * Add plugin action links on Plugins page.
	 *
	 * @since 2.0.0
	 *
	 * @param array $links Existing plugin action links.
	 *
	 * @return array
	 */
	public function add_plugin_action_link( $links ) {

		$custom['settings'] = sprintf(
			'<a href="%s" aria-label="%s">%s</a>',
			esc_url( wp_mail_smtp()->get_admin()->get_admin_page_url() ),
			esc_attr__( 'Go to WP Mail SMTP Settings page', 'wp-mail-smtp-pro' ),
			esc_html__( 'Settings', 'wp-mail-smtp-pro' )
		);

		$custom['docs'] = sprintf(
			'<a href="%1$s" target="_blank" aria-label="%2$s" rel="noopener noreferrer">%3$s</a>',
			'https://wpmailsmtp.com/docs/',
			esc_attr__( 'Go to WPMailSMTP.com documentation page', 'wp-mail-smtp-pro' ),
			esc_html__( 'Docs', 'wp-mail-smtp-pro' )
		);

		$custom['support'] = sprintf(
			'<a href="%1$s" target="_blank" aria-label="%2$s" rel="noopener noreferrer">%3$s</a>',
			'https://wpmailsmtp.com/account/support/',
			esc_attr__( 'Go to WPMailSMTP.com support page', 'wp-mail-smtp-pro' ),
			esc_html__( 'Support', 'wp-mail-smtp-pro' )
		);

		return array_merge( $custom, (array) $links );
	}

	/**
	 * Register the pro version Action Scheduler tasks.
	 *
	 * @since 2.1.0
	 * @since 2.1.2 Add EmailLogMigration4 task.
	 * @since 2.2.0 Add EmailLogMigration5 task.
	 *
	 * @param array $tasks Action Scheduler tasks to be registered.
	 *
	 * @return array
	 */
	public function get_tasks( $tasks ) {

		return array_merge(
			$tasks,
			[
				\WPMailSMTP\Pro\Tasks\EmailLogCleanupTask::class,
				\WPMailSMTP\Pro\Tasks\Migrations\EmailLogMigration4::class,
				\WPMailSMTP\Pro\Tasks\Migrations\EmailLogMigration5::class,
			]
		);
	}
}

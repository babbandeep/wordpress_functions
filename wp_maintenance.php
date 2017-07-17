<?php

/**
 * Die with a maintenance message when conditions are met.
 *
 * Checks for a file in the WordPress root directory named ".maintenance".
 * This file will contain the variable $upgrading, set to the time the file
 * was created. If the file was created less than 10 minutes ago, WordPress
 * enters maintenance mode and displays a message.
 *
 * The default message can be replaced by using a drop-in (maintenance.php in
 * the wp-content directory).
 *
 * @since 3.0.0
 * @access private
 *
 * @global int $upgrading the unix timestamp marking when upgrading WordPress began.
 */
function wp_maintenance() {
	if ( ! file_exists( ABSPATH . '.maintenance' ) || wp_installing() )
		return;
	global $upgrading;
	include( ABSPATH . '.maintenance' );
	// If the $upgrading timestamp is older than 10 minutes, don't die.
	if ( ( time() - $upgrading ) >= 600 )
		return;
	/**
	 * Filters whether to enable maintenance mode.
	 *
	 * This filter runs before it can be used by plugins. It is designed for
	 * non-web runtimes. If this filter returns true, maintenance mode will be
	 * active and the request will end. If false, the request will be allowed to
	 * continue processing even if maintenance mode should be active.
	 *
	 * @since 4.6.0
	 *
	 * @param bool $enable_checks Whether to enable maintenance mode. Default true.
	 * @param int  $upgrading     The timestamp set in the .maintenance file.
	 */
	if ( ! apply_filters( 'enable_maintenance_mode', true, $upgrading ) ) {
		return;
	}
	if ( file_exists( WP_CONTENT_DIR . '/maintenance.php' ) ) {
		require_once( WP_CONTENT_DIR . '/maintenance.php' );
		die();
	}
	wp_load_translations_early();
	$protocol = wp_get_server_protocol();
	header( "$protocol 503 Service Unavailable", true, 503 );
	header( 'Content-Type: text/html; charset=utf-8' );
	header( 'Retry-After: 600' );
?>
	<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml"<?php if ( is_rtl() ) echo ' dir="rtl"'; ?>>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php _e( 'Maintenance' ); ?></title>

	</head>
	<body>
		<h1><?php _e( 'Briefly unavailable for scheduled maintenance. Check back in a minute.' ); ?></h1>
	</body>
	</html>
<?php
	die();
}

?>

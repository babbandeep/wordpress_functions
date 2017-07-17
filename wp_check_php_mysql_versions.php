<?php

/**
 * Check for the required PHP version, and the MySQL extension or
 * a database drop-in.
 *
 * Dies if requirements are not met.
 *
 * @since 3.0.0
 * @access private
 *
 * @global string $required_php_version The required PHP version string.
 * @global string $wp_version           The WordPress version string.
 */
function wp_check_php_mysql_versions() {
	global $required_php_version, $wp_version;
	$php_version = phpversion();
	if ( version_compare( $required_php_version, $php_version, '>' ) ) {
		wp_load_translations_early();
		$protocol = wp_get_server_protocol();
		header( sprintf( '%s 500 Internal Server Error', $protocol ), true, 500 );
		header( 'Content-Type: text/html; charset=utf-8' );
		/* translators: 1: Current PHP version number, 2: WordPress version number, 3: Minimum required PHP version number */
		die( sprintf( __( 'Your server is running PHP version %1$s but WordPress %2$s requires at least %3$s.' ), $php_version, $wp_version, $required_php_version ) );
	}
	if ( ! extension_loaded( 'mysql' ) && ! extension_loaded( 'mysqli' ) && ! extension_loaded( 'mysqlnd' ) && ! file_exists( WP_CONTENT_DIR . '/db.php' ) ) {
		wp_load_translations_early();
		$protocol = wp_get_server_protocol();
		header( sprintf( '%s 500 Internal Server Error', $protocol ), true, 500 );
		header( 'Content-Type: text/html; charset=utf-8' );
		die( __( 'Your PHP installation appears to be missing the MySQL extension which is required by WordPress.' ) );
	}
}

?>

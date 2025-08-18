<?php 
defined( 'ABSPATH' ) || exit;
define( 'POWERED_CACHE_PAGE_CACHING', true );

$config_locations[] = WP_CONTENT_DIR . '/pc-config/config-network.php';
if ( is_multisite() && defined( 'SUBDOMAIN_INSTALL' ) && ! SUBDOMAIN_INSTALL ) {
	$request_uri = explode( '/', ltrim( $_SERVER['REQUEST_URI'], '/' ) );
	if ( ! empty( $request_uri[0] ) ) {
		$config_locations[] = WP_CONTENT_DIR . '/pc-config/config-' . $_SERVER['HTTP_HOST'] . '-' . $request_uri[0] . '.php';
	}
}
$config_locations[] = WP_CONTENT_DIR . '/pc-config/config-' . $_SERVER['HTTP_HOST'] . '.php';

foreach ( $config_locations as $config_file ) {
	if ( @file_exists( $config_file ) ) {
		include( $config_file );
		break;
	}
}

if ( ! isset( $GLOBALS['powered_cache_options'] ) ) {
	return;
}

if ( defined( 'POWERED_CACHE_ADVANCED_CACHE_DROPIN') && @file_exists( POWERED_CACHE_ADVANCED_CACHE_DROPIN ) ) {
	include( POWERED_CACHE_ADVANCED_CACHE_DROPIN );
} elseif ( @file_exists( 'C:\xampp1\htdocs\zdrava_hrana\wordpress\wp-content\plugins\powered-cache/includes/dropins/page-cache.php' ) ) {
	include( 'C:\xampp1\htdocs\zdrava_hrana\wordpress\wp-content\plugins\powered-cache/includes/dropins/page-cache.php' );
} else {
	define( 'POWERED_CACHE_PAGE_CACHING_HAS_PROBLEM', true );
}
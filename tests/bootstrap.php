<?php
/**
 * PHPUnit bootstrap. Runs in the wp-env tests container, which sets WP_TESTS_DIR.
 */

const WP_TESTS_PHPUNIT_POLYFILLS_PATH = __DIR__ . '/../vendor/yoast/phpunit-polyfills';

// Tests never reach the network.
const WP_HTTP_BLOCK_EXTERNAL = true;

$tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $tests_dir ) {
	echo 'WP_TESTS_DIR is not set. Run npm test, which uses the wp-env container.' . PHP_EOL;
	exit( 1 );
}

require_once $tests_dir . '/includes/functions.php';

tests_add_filter(
	'muplugins_loaded',
	static function () {
		require WP_PLUGIN_DIR . '/woocommerce/woocommerce.php';
		require dirname( __DIR__ ) . '/rename-vat-to-gst-wc.php';
	}
);
tests_add_filter( 'setup_theme', array( 'WC_Install', 'install' ) );

require $tests_dir . '/includes/bootstrap.php';

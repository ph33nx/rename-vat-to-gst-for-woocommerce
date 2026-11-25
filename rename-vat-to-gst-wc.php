<?php
/**
 * Plugin Name:       Rename VAT and Tax to GST for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/rename-vat-to-gst-for-woocommerce/
 * Description:       WooCommerce GST plugin: change VAT and Tax to GST on the cart, checkout, orders and emails, block and classic. No setup.
 * Version:           2.0.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            abhi9
 * Author URI:        https://github.com/ph33nx
 * License:           GPL-2.0-or-later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rename-vat-to-gst-for-woocommerce
 * Requires Plugins:  woocommerce
 * WC requires at least: 8.0.0
 * WC tested up to:   11.3
 *
 * @package Rvtgiwc
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

final class RVTGIWC_VAT_To_GST_Rename {

	private const WORDS = '(?:VAT|V\.A\.T\.?|[Tt]ax(?:es)?)';

	/** Never inside a longer word, a CSS class or a URL. Runs in the browser too, so no lookbehind: Safari before 16.4 rejects it. */
	private const PATTERN = '(^|[^\w\/-])' . self::WORDS . '(?![\w-])';

	/** Admin screens rename whole labels only, so settings and CSV columns keep the words the WooCommerce documentation uses. */
	private const ADMIN_LABEL = '/^\(?(?:(?:incl?|exc?|including|excluding)\.? )?' . self::WORDS . '(?: amount)?\)?$/';

	public static function register(): void {
		add_action(
			'before_woocommerce_init',
			static function (): void {
				if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
					\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
					\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, true );
				}
			}
		);
		add_filter( 'gettext_woocommerce', array( self::class, 'rename' ), 20 );
		add_filter( 'gettext_with_context_woocommerce', array( self::class, 'rename' ), 20 );
		add_filter( 'ngettext_woocommerce', array( self::class, 'rename' ), 20 );
		add_filter( 'woocommerce_cart_tax_totals', array( self::class, 'rename_rates' ), 20 );
		add_filter( 'woocommerce_order_get_tax_totals', array( self::class, 'rename_rates' ), 20 );
		add_action( 'wp_enqueue_scripts', array( self::class, 'rename_in_scripts' ) );
	}

	/**
	 * Renames the tax words in a translated WooCommerce string.
	 *
	 * @param mixed $text The translated string.
	 * @return mixed The renamed string.
	 */
	public static function rename( $text ) {
		if ( ! is_string( $text ) || ( is_admin() && ! preg_match( self::ADMIN_LABEL, $text ) ) ) {
			return $text;
		}
		return self::replace( $text );
	}

	/**
	 * Renames the tax rate labels of a cart or an order.
	 *
	 * @param mixed $totals Objects carrying a label, keyed by rate code.
	 * @return mixed The same totals, renamed.
	 */
	public static function rename_rates( $totals ) {
		foreach ( (array) $totals as $total ) {
			if ( is_object( $total ) && isset( $total->label ) ) {
				$total->label = self::replace( (string) $total->label );
			}
		}
		return $totals;
	}

	/**
	 * The block cart and checkout translate their labels in the browser, out of reach of the PHP filters.
	 */
	public static function rename_in_scripts(): void {
		wp_add_inline_script(
			'wp-i18n',
			sprintf(
				'(function(words){["gettext","gettext_with_context","ngettext"].forEach(function(type){wp.hooks.addFilter("i18n."+type+"_woocommerce","rename-vat-to-gst",function(text){return text.replace(words,"$1GST");});});})(new RegExp(%s,"g"));',
				wp_json_encode( self::PATTERN )
			)
		);
	}

	private static function replace( string $text ): string {
		return (string) preg_replace( '/' . self::PATTERN . '/', '$1GST', $text );
	}
}

RVTGIWC_VAT_To_GST_Rename::register();

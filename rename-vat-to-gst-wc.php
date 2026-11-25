<?php
/**
 * Plugin Name:       Rename VAT to GST for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/rename-vat-to-gst-for-woocommerce/
 * Description:       Replaces VAT and Tax terminology with GST throughout WooCommerce (emails, cart, checkout, admin).
 * Version:           2.0.0
 * Requires at least: 6.7
 * Requires PHP: 7.4
 * Author:            abhi9
 * Author URI:        https://github.com/ph33nx
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rvtgiwc
 * Domain Path:       /languages
 * WC requires at least: 8.0.0
 * WC tested up to:   10.3.5
 *
 * @package Rvtgiwc
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

/**
 * Declare HPOS compatibility for WooCommerce.
 */
add_action('before_woocommerce_init', function() {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

if (!class_exists('RVTGIWC_VAT_To_GST_Rename')) :

final class RVTGIWC_VAT_To_GST_Rename {
    private const VERSION = '2.0.0';
    protected static ?self $_instance = null;

    private array $replacements;

    /**
     * Main Instance.
     */
    public static function instance(): self {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Cloning is forbidden.
     */
    public function __clone() {
        _doing_it_wrong(__FUNCTION__, 'Cloning is forbidden.', '2.0.0');
    }

    /**
     * Unserializing instances is forbidden.
     */
    public function __wakeup() {
        _doing_it_wrong(__FUNCTION__, 'Unserializing instances is forbidden.', '2.0.0');
    }

    private function __construct() {
        $this->replacements = [
            // VAT variations
            'VAT'           => 'GST',
            'Vat'           => 'GST',
            'vat'           => 'gst',
            'V.A.T'         => 'GST',
            'V.A.T.'        => 'GST',
            
            // Tax variations - only common WC strings
            'Tax'           => 'GST',
            'tax'           => 'gst',
            'Taxes'         => 'GST',
            'taxes'         => 'gst',
            'Tax amount'    => 'GST amount',
            'tax amount'    => 'gst amount',
            
            // Common WooCommerce strings
            '(incl. VAT)'   => '(incl. GST)',
            '(ex. VAT)'     => '(ex. GST)',
            '(incl. tax)'   => '(incl. GST)',
            '(ex. tax)'     => '(ex. GST)',
            'Inc. VAT'      => 'Inc. GST',
            'Exc. VAT'      => 'Exc. GST',
            'Inc. tax'      => 'Inc. GST',
            'Exc. tax'      => 'Exc. GST',
            'including VAT' => 'including GST',
            'excluding VAT' => 'excluding GST',
            'including tax' => 'including GST',
            'excluding tax' => 'excluding GST',
        ];

        $this->init_hooks();
    }

    private function init_hooks(): void {
        // Translation filters
        add_filter('gettext', [$this, 'replace_text'], 20, 3);
        add_filter('gettext_with_context', [$this, 'replace_text_with_context'], 20, 4);
        add_filter('ngettext', [$this, 'replace_plural_text'], 20, 5);
        
        // Order item totals filter (order received page, emails)
        add_filter('woocommerce_get_order_item_totals', [$this, 'replace_order_item_totals'], 20, 3);
        
        // Cart/Checkout tax totals
        add_filter('woocommerce_cart_tax_totals', [$this, 'replace_tax_totals_labels'], 20, 2);
    }

    public function replace_text(string $translation, string $text, string $domain): string {
        if ('woocommerce' !== $domain) {
            return $translation;
        }

        return $this->replacements[$translation] ?? $translation;
    }

    public function replace_text_with_context(string $translation, string $text, string $context, string $domain): string {
        if ('woocommerce' !== $domain) {
            return $translation;
        }

        return $this->replacements[$translation] ?? $translation;
    }

    public function replace_plural_text(string $translation, string $single, string $plural, int $number, string $domain): string {
        if ('woocommerce' !== $domain) {
            return $translation;
        }

        return $this->replacements[$translation] ?? $translation;
    }

    /**
     * Replace tax labels in order item totals (Order Received page, Emails, My Account)
     */
    public function replace_order_item_totals(array $total_rows, ?\WC_Order $order, bool $tax_display): array {
        foreach ($total_rows as $key => $row) {
            // Replace tax row labels
            if (isset($row['label'])) {
                $total_rows[$key]['label'] = $this->replace_in_string($row['label']);
            }
        }
        return $total_rows;
    }

    /**
     * Replace tax labels in cart/checkout tax totals
     */
    public function replace_tax_totals_labels(array $tax_totals, \WC_Cart $cart): array {
        foreach ($tax_totals as $code => $tax) {
            if (isset($tax->label)) {
                $tax_totals[$code]->label = $this->replace_in_string($tax->label);
            }
        }
        return $tax_totals;
    }

    /**
     * Replace VAT/Tax with GST in any string
     */
    private function replace_in_string(string $text): string {
        $patterns = [
            '/\bVAT\b/' => 'GST',
            '/\bTax\b/' => 'GST',
            '/\btax\b/' => 'gst',
            '/\bTaxes\b/' => 'GST',
            '/\btaxes\b/' => 'gst',
        ];
        
        return preg_replace(array_keys($patterns), array_values($patterns), $text);
    }
}

endif;

/**
 * Initialize plugin after WooCommerce is loaded.
 */
function rvtgiwc_initialize() {
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', function() {
            echo '<div class="error"><p><strong>Rename VAT to GST for WooCommerce</strong> requires WooCommerce to be installed and active.</p></div>';
        });
        return;
    }

    $GLOBALS['rvtgiwc'] = RVTGIWC_VAT_To_GST_Rename::instance();
}

add_action('plugins_loaded', 'rvtgiwc_initialize', 10);

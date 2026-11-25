=== Rename VAT and Tax to GST for WooCommerce ===
Contributors: abhi9
Tags: woocommerce, gst, vat, tax, india
Requires at least: 6.7
Tested up to: 7.2
Requires PHP: 7.4
Stable tag: 2.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WooCommerce GST plugin: change VAT and Tax to GST on the cart, checkout, orders and emails, block and classic. No setup.

== Description ==

**Rename VAT and Tax to GST for WooCommerce changes the words VAT, Tax and Taxes to GST across your store, on the block and classic cart and checkout, in orders, emails and account pages.**

Stores in India, Australia, New Zealand, Singapore and Canada charge GST, while WooCommerce says Tax or VAT. Activate this WooCommerce GST plugin and customers read GST everywhere.

**Where it works**

* Cart and checkout, block and classic
* Order confirmation page
* Order emails
* My Account pages
* Order screens in the admin

**Features**

* Nothing to configure
* Works with translated stores
* Compatible with WooCommerce HPOS
* Works with every theme, with no template overrides

Source code and issues: [GitHub](https://github.com/ph33nx/rename-vat-to-gst-for-woocommerce)

== Installation ==

1. Install the plugin from Plugins > Add New, or upload it.
2. Activate it. WooCommerce must be active.
3. Open your checkout. Tax now reads GST.

== Frequently Asked Questions ==

= How do I change Tax to GST in WooCommerce? =
Activate this plugin. VAT, Tax and Taxes read GST on the cart, checkout, orders, emails and account pages, with no code and no settings.

= How do I change VAT to GST in WooCommerce? =
The same way. The plugin renames VAT and Tax, including labels such as (incl. VAT) and (ex. tax).

= Does it work with the WooCommerce block checkout? =
Yes. It renames the labels on the block cart and block checkout as well as the classic shortcode pages.

= How do I set up GST in WooCommerce? =
Turn on taxes under WooCommerce > Settings > General, then add your GST rates under WooCommerce > Settings > Tax. WooCommerce calculates the amount and this plugin shows it as GST.

= Does it add GST to my prices or change my tax rates? =
No. It changes the words only. Rates and amounts stay as you set them.

= Does it work for GST in India with CGST, SGST and IGST? =
Yes. Rates you name CGST, SGST or IGST keep those names, and every other Tax label reads GST.

= Does it work for GST in Australia and New Zealand? =
Yes. It shows GST wherever WooCommerce shows Tax, for any country.

= Does it create GST invoices? =
It renames labels on your store and in WooCommerce emails. Invoices come from your invoice plugin.

= Does it work with multilingual sites? =
Yes. It renames VAT and Tax after translation, so any language that uses those words reads GST.

= Does this work with the latest WooCommerce? =
Yes, tested up to WooCommerce 11.3 and supports HPOS (High-Performance Order Storage).

== Changelog ==

= 2.1.0 =
* Fixed: the block cart and block checkout show GST.
* Improved: order emails and account pages rename the tax rate itself, and tax settings keep the words the WooCommerce documentation uses.
* Improved: tested against WordPress 7.2, PHP 8.6 and WooCommerce 11.3.

= 2.0.0 =
* Complete rewrite with modern PHP 8+ practices
* Added HPOS compatibility
* Enhanced coverage: now replaces Tax/VAT in emails, cart, checkout, orders
* Better performance with optimized filters
* Updated for WooCommerce 10.3.5 and WordPress 6.8
* Requires PHP 7.4+, WordPress 6.7+, WooCommerce 8.0+

= 1.0.1 =
* Tested up to WP 6.0 and WC 6.5.1

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 2.1.0 =
The block cart and checkout show GST. Tested against WordPress 7.2 and PHP 8.6.

= 2.0.0 =
Major update with complete rewrite, HPOS support, and enhanced coverage. Requires PHP 7.4+, WP 6.7+, WC 8.0+.
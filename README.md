# Rename VAT and Tax to GST for WooCommerce

[![WordPress plugin version](https://img.shields.io/wordpress/plugin/v/rename-vat-to-gst-for-woocommerce?label=WordPress%20plugin&logo=wordpress)](https://wordpress.org/plugins/rename-vat-to-gst-for-woocommerce/)
[![Tested up to](https://img.shields.io/wordpress/plugin/tested/rename-vat-to-gst-for-woocommerce?label=tested%20up%20to)](https://wordpress.org/plugins/rename-vat-to-gst-for-woocommerce/)
[![Requires PHP](https://img.shields.io/wordpress/plugin/required-php/rename-vat-to-gst-for-woocommerce)](https://wordpress.org/plugins/rename-vat-to-gst-for-woocommerce/)
[![CI](https://github.com/ph33nx/rename-vat-to-gst-for-woocommerce/actions/workflows/ci.yml/badge.svg)](https://github.com/ph33nx/rename-vat-to-gst-for-woocommerce/actions/workflows/ci.yml)
[![License: GPL v2 or later](https://img.shields.io/badge/license-GPL--2.0--or--later-blue)](LICENSE.txt)

**Rename VAT and Tax to GST for WooCommerce changes the words VAT, Tax and Taxes to GST across your store, on the block and classic cart and checkout, in orders, emails and account pages.**

Stores in India, Australia, New Zealand, Singapore and Canada charge GST, while WooCommerce says Tax or VAT. Activate this WooCommerce GST plugin and customers read GST everywhere.

## Where it works

-   Cart and checkout, block and classic
-   Order confirmation page
-   Order emails
-   My Account pages
-   Order screens in the admin

## Features

-   Nothing to configure
-   Works with translated stores
-   Compatible with WooCommerce HPOS
-   Works with every theme, with no template overrides

## Install

[Download it from WordPress.org](https://wordpress.org/plugins/rename-vat-to-gst-for-woocommerce/), or search for "Rename VAT and Tax to GST for WooCommerce" under Plugins > Add New. Requires WooCommerce, WordPress 6.7 and PHP 7.4 or newer.

## Questions

### How do I change Tax to GST in WooCommerce?

Activate this plugin. VAT, Tax and Taxes read GST on the cart, checkout, orders, emails and account pages, with no code and no settings.

### How do I change VAT to GST in WooCommerce?

The same way. The plugin renames VAT and Tax, including labels such as (incl. VAT) and (ex. tax).

### Does it work with the WooCommerce block checkout?

Yes. It renames the labels on the block cart and block checkout as well as the classic shortcode pages.

### How do I set up GST in WooCommerce?

Turn on taxes under WooCommerce > Settings > General, then add your GST rates under WooCommerce > Settings > Tax. WooCommerce calculates the amount and this plugin shows it as GST.

### Does it add GST to my prices or change my tax rates?

No. It changes the words only. Rates and amounts stay as you set them.

### Does it work for GST in India with CGST, SGST and IGST?

Yes. Rates you name CGST, SGST or IGST keep those names, and every other Tax label reads GST.

### Does it work for GST in Australia and New Zealand?

Yes. It shows GST wherever WooCommerce shows Tax, for any country.

### Does it create GST invoices?

It renames labels on your store and in WooCommerce emails. Invoices come from your invoice plugin.

### Does it work with multilingual sites?

Yes. It renames VAT and Tax after translation, so any language that uses those words reads GST.

### Does this work with the latest WooCommerce?

Yes, tested up to WooCommerce 11.3 and supports HPOS (High-Performance Order Storage).

## Development

Needs Docker, Node 24, PHP and Composer.

```bash
npm ci && npx lefthook install && composer install
npm run env:start   # http://localhost:8888, admin / password
npm test
npm run plugin-check
```

## License

GPL-2.0-or-later

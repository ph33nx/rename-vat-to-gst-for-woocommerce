<?php

class Test_Rename extends WP_UnitTestCase {

	public function tear_down(): void {
		set_current_screen( 'front' );
		parent::tear_down();
	}

	/**
	 * @dataProvider customer_strings
	 */
	public function test_a_customer_string_is_renamed( string $from, string $to ): void {
		$this->assertSame( $to, RVTGIWC_VAT_To_GST_Rename::rename( $from ) );
	}

	public function customer_strings(): array {
		return array(
			array( 'VAT', 'GST' ),
			array( 'V.A.T.', 'GST' ),
			array( 'Tax', 'GST' ),
			array( 'Taxes', 'GST' ),
			array( '(incl. tax)', '(incl. GST)' ),
			array( '(ex. VAT)', '(ex. GST)' ),
			array( 'Taxes calculated at checkout.', 'GST calculated at checkout.' ),
			array( 'Tax, shipping and tax', 'GST, shipping and GST' ),
			array( '%1$s tax', '%1$s GST' ),
			array( '', '' ),
			array( 'Taxonomy', 'Taxonomy' ),
			array( 'Syntax', 'Syntax' ),
			array( '<small class="tax_label">', '<small class="tax_label">' ),
			array( '<a class="wc-tax-link" href="https://example.com/tax/">Tax</a>', '<a class="wc-tax-link" href="https://example.com/tax/">GST</a>' ),
		);
	}

	/**
	 * @dataProvider admin_strings
	 */
	public function test_an_admin_screen_renames_whole_labels_only( string $from, string $to ): void {
		set_current_screen( 'dashboard' );
		$this->assertSame( $to, RVTGIWC_VAT_To_GST_Rename::rename( $from ) );
	}

	public function admin_strings(): array {
		return array(
			array( 'Tax', 'GST' ),
			array( 'Tax amount', 'GST amount' ),
			array( '(incl. VAT)', '(incl. GST)' ),
			array( 'including tax', 'including GST' ),
			array( 'Tax class', 'Tax class' ),
			array( 'Tax status', 'Tax status' ),
			array( 'Standard tax rates', 'Standard tax rates' ),
		);
	}

	public function test_a_value_that_is_not_text_is_left_alone(): void {
		$this->assertNull( RVTGIWC_VAT_To_GST_Rename::rename( null ) );
	}

	public function test_woocommerce_strings_are_renamed_and_other_domains_are_not(): void {
		$this->assertSame( 'GST', __( 'Tax', 'woocommerce' ) );
		$this->assertSame( 'GST', _x( 'Tax', 'context', 'woocommerce' ) );
		$this->assertSame( 'GST', _n( 'Tax', 'Taxes', 2, 'woocommerce' ) );
		$this->assertSame( 'Tax', __( 'Tax', 'another-plugin' ) );
	}

	public function test_a_cart_rate_label_is_renamed(): void {
		$totals = apply_filters( 'woocommerce_cart_tax_totals', array( 'IN-1' => (object) array( 'label' => 'VAT 18%' ) ), null );
		$this->assertSame( 'GST 18%', $totals['IN-1']->label );
	}

	public function test_an_order_rate_label_is_renamed(): void {
		$rate  = WC_Tax::_insert_tax_rate(
			array(
				'tax_rate_country' => 'IN',
				'tax_rate'         => '18',
				'tax_rate_name'    => 'VAT',
			)
		);
		$order = wc_create_order();
		$item  = new WC_Order_Item_Tax();
		$item->set_rate( $rate );
		$item->set_tax_total( 18 );
		$order->add_item( $item );
		$order->save();
		$this->assertSame( array( 'GST' ), array_values( wp_list_pluck( $order->get_tax_totals(), 'label' ) ) );
	}

	public function test_totals_without_labels_are_left_alone(): void {
		$this->assertSame( array(), RVTGIWC_VAT_To_GST_Rename::rename_rates( array() ) );
		$totals = array( (object) array( 'amount' => 1 ), 'text' );
		$this->assertSame( $totals, RVTGIWC_VAT_To_GST_Rename::rename_rates( $totals ) );
	}

	public function test_the_browser_filters_ship_with_wp_i18n_and_no_lookbehind(): void {
		RVTGIWC_VAT_To_GST_Rename::rename_in_scripts();
		$script = implode( '', array_filter( (array) wp_scripts()->get_data( 'wp-i18n', 'after' ), 'is_string' ) );
		$this->assertStringContainsString( 'rename-vat-to-gst', $script );
		$this->assertStringNotContainsString( '(?<', $script );
	}
}

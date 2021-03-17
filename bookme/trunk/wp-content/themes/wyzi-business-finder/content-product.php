<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php post_class(); ?>>
	<?php
	
	do_action( 'woocommerce_before_shop_loop_item' );

	do_action( 'woocommerce_before_shop_loop_item_title' );

	do_action( 'woocommerce_shop_loop_item_title' );

	do_action( 'woocommerce_after_shop_loop_item_title' );

	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>

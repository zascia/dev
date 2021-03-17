<div class="page-area section pt-90 pb-90">
	<div class="container">
		<div class="row">
		

			<?php get_template_part( 'sidebar/left-sidebar-shop' ); ?>

			<div class="<?php if ( 'full-width' === wyz_get_option( 'shop-sidebar-layout' ) ) { ?> col-lg-12 col-md-12 col-xs-12"<?php } elseif ( 'off' == wyz_get_option( 'resp' ) ) { ?> col-xs-8<?php } else { ?> col-lg-9 col-md-8 col-xs-12<?php } ?>">

			<?php 
			$template_type = wyz_get_theme_template();
			if ( false && 2 == $template_type && ! is_singular( 'product' ) ) {
				wyz_woocommerce_content();
			} else {
				woocommerce_content(); 
			}?>

			</div>

			<?php get_template_part( 'sidebar/right-sidebar-shop' ); ?>

		</div>
	</div>
</div>

<?php
function wyz_woocommerce_content() {

	if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

		<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

	<?php endif;

	do_action( 'woocommerce_archive_description' );

	if ( have_posts() ) :

		do_action( 'woocommerce_before_shop_loop' );

		$product_ids = array();

		while ( have_posts() ) : the_post();

			$product_ids[] = get_the_ID();

		endwhile;
		echo do_shortcode( '[ess_grid alias="jason" posts='.implode(',',$product_ids).']' );

		do_action( 'woocommerce_after_shop_loop' );

	elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) :

		do_action( 'woocommerce_no_products_found' );

	endif;
}
?>